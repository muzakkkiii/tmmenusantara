<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DonationController extends Controller
{
    public function index()
    {
        return view('public.donasi');
    }

    public function store(Request $r)
    {
        // Honeypot anti-bot: kolom tersembunyi 'website' harus kosong.
        if ($r->filled('website')) {
            return redirect()->route('donasi');
        }

        $gwEnabled = (bool) config('donasi.gateway.enabled');
        $metodes = $gwEnabled
            ? 'required|in:transfer,qris,tunai,online'
            : 'required|in:transfer,qris,tunai';

        $data = $r->validate([
            'nama' => 'required|string|max:120',
            'wa' => 'nullable|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
            'email' => 'nullable|email|max:120',
            'nominal' => 'required|numeric|min:1000',
            'program' => 'nullable|string|max:60',
            'metode' => $metodes,
            'catatan' => 'nullable|string|max:2000',
            'bukti' => 'nullable|image|max:2048',
        ], [
            'nama.required'    => 'Nama donatur wajib diisi.',
            'wa.regex'         => 'Format nomor WhatsApp tidak valid.',
            'email.email'      => 'Format email tidak valid.',
            'nominal.required' => 'Nominal donasi wajib diisi.',
            'nominal.numeric'  => 'Nominal harus berupa angka.',
            'nominal.min'      => 'Nominal donasi minimal Rp1.000.',
            'metode.required'  => 'Silakan pilih metode donasi.',
        ]);

        $buktiPath = null;
        if ($r->hasFile('bukti')) {
            $file = $r->file('bukti');
            $name = 'bukti-' . date('Ymd-His') . '-' . mt_rand(100000, 999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti'), $name);
            // Kompres & resize otomatis agar bukti transfer tidak memberatkan penyimpanan.
            compress_image(public_path('uploads/bukti/' . $name), 1400, 78);
            $buktiPath = '/uploads/bukti/' . $name;
        }

        $isOnline = ($data['metode'] === 'online');

        $don = Donation::create([
            'nama' => $data['nama'],
            'wa' => $data['wa'] ?? null,
            'email' => $data['email'] ?? null,
            'nominal' => (int) $data['nominal'],
            'program' => $data['program'] ?? 'Umum',
            'metode' => $data['metode'],
            'status' => $isOnline ? 'Menunggu Pembayaran' : 'Menunggu Verifikasi',
            'catatan' => $data['catatan'] ?? null,
            'bukti' => $buktiPath,
        ]);

        // Alur pembayaran online (Midtrans Snap) bila gateway diaktifkan.
        if ($isOnline && config('donasi.gateway.enabled')) {
            $redirect = $this->createMidtransPayment($don);
            if ($redirect) {
                return redirect()->away($redirect);
            }
            // Bila gagal membuat transaksi, jatuh ke alur manual.
            $don->update(['status' => 'Menunggu Verifikasi', 'metode' => 'transfer']);
        }

        // Notifikasi email otomatis ke admin (aman bila mail belum diatur).
        notify_admin(
            'Donasi baru: ' . rp($don->nominal) . ' - ' . $don->nama,
            "Ada donasi baru masuk dan menunggu verifikasi:\n\n"
            . 'Nama: ' . $don->nama . "\n"
            . 'WhatsApp: ' . ($don->wa ?: '-') . "\n"
            . 'Nominal: ' . rp($don->nominal) . "\n"
            . 'Peruntukan: ' . $don->program . "\n"
            . 'Metode: ' . $don->metode . "\n\n"
            . 'Verifikasi di panel admin: ' . url('/admin/donations')
        );

        $adminWa = setting('wa', config('yayasan.wa_admin'));
        $msg = "Halo Admin, saya ingin konfirmasi donasi:\n"
            . 'Nama: ' . $don->nama . "\n"
            . 'Nominal: ' . rp($don->nominal) . "\n"
            . 'Peruntukan: ' . $don->program . "\n"
            . 'Metode: ' . $don->metode;

        return redirect()->route('donasi')
            ->with('donasi_ok', 'Terima kasih, ' . $don->nama . '! Konfirmasi donasi sebesar ' . rp($don->nominal) . ' telah kami terima dan akan segera diverifikasi.')
            ->with('wa_url', wa_link($adminWa, $msg));
    }

    /* ---------------- MIDTRANS ---------------- */

    protected function midtransBase(): string
    {
        return config('donasi.gateway.production')
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

    protected function createMidtransPayment(Donation $don): ?string
    {
        $serverKey = (string) config('donasi.gateway.server_key');
        if ($serverKey === '') {
            return null;
        }

        $orderId = 'DON-' . $don->id . '-' . time();
        $don->update(['catatan' => trim(($don->catatan ? $don->catatan . ' ' : '') . '[order:' . $orderId . ']')]);

        try {
            $resp = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
            ])->post($this->midtransBase() . '/snap/v1/transactions', [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $don->nominal,
                ],
                'customer_details' => [
                    'first_name' => $don->nama,
                    'email' => $don->email ?: 'donatur@example.com',
                    'phone' => $don->wa ?: '',
                ],
                'item_details' => [[
                    'id' => 'donasi',
                    'price' => (int) $don->nominal,
                    'quantity' => 1,
                    'name' => 'Donasi - ' . $don->program,
                ]],
                'callbacks' => [
                    'finish' => route('donasi.selesai'),
                ],
            ]);

            if ($resp->successful() && $resp->json('redirect_url')) {
                return $resp->json('redirect_url');
            }
        } catch (\Throwable $e) {
            // fallback ke manual
        }

        return null;
    }

    /**
     * Endpoint notifikasi (webhook) dari Midtrans.
     * Atur URL ini di dashboard Midtrans: /donasi/callback
     */
    public function callback(Request $r)
    {
        $serverKey = (string) config('donasi.gateway.server_key');
        $orderId = (string) $r->input('order_id');
        $statusCode = (string) $r->input('status_code');
        $gross = (string) $r->input('gross_amount');
        $trxStatus = (string) $r->input('transaction_status');
        $sig = (string) $r->input('signature_key');

        // Verifikasi signature untuk mencegah pemalsuan.
        $expected = hash('sha512', $orderId . $statusCode . $gross . $serverKey);
        if (! hash_equals($expected, $sig)) {
            return response()->json(['message' => 'invalid signature'], 403);
        }

        // order_id format: DON-{id}-{time}
        $parts = explode('-', $orderId);
        $id = isset($parts[1]) ? (int) $parts[1] : 0;
        $don = Donation::find($id);
        if (! $don) {
            return response()->json(['message' => 'not found'], 404);
        }

        if (in_array($trxStatus, ['settlement', 'capture'], true)) {
            if ($don->status !== 'Terverifikasi') {
                $don->update(['status' => 'Terverifikasi']);
                // Catat otomatis ke kas transparansi (idempoten by order marker).
                Finance::create([
                    'type' => 'masuk',
                    'tgl' => now()->toDateString(),
                    'nama' => 'Donasi Online - ' . $don->nama,
                    'prog' => $don->program,
                    'ket' => 'Pembayaran online ' . $orderId,
                    'amt' => (int) $don->nominal,
                ]);
            }
        } elseif (in_array($trxStatus, ['expire', 'cancel', 'deny'], true)) {
            $don->update(['status' => 'Batal']);
        }

        return response()->json(['message' => 'ok']);
    }

    public function selesai(Request $r)
    {
        return redirect()->route('donasi')
            ->with('donasi_ok', 'Terima kasih! Pembayaran Anda sedang diproses. Status akan otomatis terverifikasi setelah pembayaran dikonfirmasi.');
    }
}
