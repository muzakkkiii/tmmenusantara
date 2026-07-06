<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Participant;
use App\Models\Partner;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /* -------- Form Kemitraan -------- */
    public function mitra(Request $r)
    {
        if ($r->filled('website')) {
            return redirect()->route('mitra');
        }
        $data = $r->validate([
            'nama' => 'required|string|max:120',
            'organisasi' => 'nullable|string|max:160',
            'wa' => 'nullable|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
            'email' => 'nullable|email|max:120',
            'jenis' => 'nullable|string|max:80',
            'pesan' => 'nullable|string|max:3000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'wa.regex' => 'Format nomor WhatsApp tidak valid (contoh: 08123456789).',
            'email.email' => 'Format email tidak valid.',
        ]);
        $data['status'] = 'Baru';
        $row = Partner::create($data);

        notify_admin(
            'Pengajuan kemitraan baru: ' . $row->nama,
            "Pengajuan kemitraan baru:\n\n"
            . 'Nama: ' . $row->nama . "\n"
            . 'Organisasi: ' . ($row->organisasi ?: '-') . "\n"
            . 'Jenis: ' . ($row->jenis ?: '-') . "\n"
            . 'WhatsApp: ' . ($row->wa ?: '-') . "\n"
            . 'Email: ' . ($row->email ?: '-') . "\n\n"
            . 'Detail: ' . ($row->pesan ?: '-') . "\n\n"
            . 'Kelola di panel admin: ' . url('/admin/partners')
        );

        return redirect()->route('mitra')
            ->with('ok', 'Terima kasih, ' . $row->nama . '! Pengajuan kemitraan Anda sudah kami terima dan akan segera ditindaklanjuti tim kami.');
    }

    /* -------- Pendaftaran Peserta -------- */
    public function daftar(Request $r)
    {
        if ($r->filled('website')) {
            return redirect()->route('daftar');
        }
        $data = $r->validate([
            'nama' => 'required|string|max:120',
            'wa' => 'nullable|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
            'email' => 'nullable|email|max:120',
            'program' => 'nullable|string|max:80',
            'asal' => 'nullable|string|max:160',
            'catatan' => 'nullable|string|max:2000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'wa.regex' => 'Format nomor WhatsApp tidak valid (contoh: 08123456789).',
            'email.email' => 'Format email tidak valid.',
        ]);
        $data['status'] = 'Baru';
        $row = Participant::create($data);

        notify_admin(
            'Pendaftar peserta baru: ' . $row->nama,
            "Pendaftar peserta baru:\n\n"
            . 'Nama: ' . $row->nama . "\n"
            . 'Program: ' . ($row->program ?: '-') . "\n"
            . 'WhatsApp: ' . ($row->wa ?: '-') . "\n"
            . 'Asal: ' . ($row->asal ?: '-') . "\n\n"
            . 'Kelola di panel admin: ' . url('/admin/participants')
        );

        return redirect()->route('daftar')
            ->with('ok', 'Terima kasih, ' . $row->nama . '! Pendaftaran Anda berhasil. Tim kami akan menghubungi Anda melalui kontak yang diberikan.');
    }

    /* -------- Gabung Anggota / Relawan -------- */
    public function relawan(Request $r)
    {
        if ($r->filled('website')) {
            return redirect()->route('relawan');
        }
        $data = $r->validate([
            'nama' => 'required|string|max:120',
            'wa' => 'nullable|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
            'email' => 'nullable|email|max:120',
            'peran' => 'nullable|string|max:40',
            'bidang' => 'nullable|string|max:120',
            'alamat' => 'nullable|string|max:255',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'wa.regex' => 'Format nomor WhatsApp tidak valid (contoh: 08123456789).',
            'email.email' => 'Format email tidak valid.',
        ]);
        $data['peran'] = $data['peran'] ?? 'Relawan';
        $data['status'] = 'Aktif';
        $row = Member::create($data);

        notify_admin(
            'Anggota/relawan baru: ' . $row->nama,
            "Pendaftaran anggota/relawan baru:\n\n"
            . 'Nama: ' . $row->nama . "\n"
            . 'Peran: ' . $row->peran . "\n"
            . 'Bidang: ' . ($row->bidang ?: '-') . "\n"
            . 'WhatsApp: ' . ($row->wa ?: '-') . "\n\n"
            . 'Kelola di panel admin: ' . url('/admin/members')
        );

        return redirect()->route('relawan')
            ->with('ok', 'Terima kasih, ' . $row->nama . '! Anda berhasil terdaftar sebagai ' . strtolower($row->peran) . '. Sampai jumpa di kegiatan kami.');
    }

    /* -------- Newsletter (footer) -------- */
    public function newsletter(Request $r)
    {
        if ($r->filled('website')) {
            return back();
        }
        $data = $r->validate([
            'email' => 'required|email|max:160',
            'nama' => 'nullable|string|max:120',
        ]);
        Subscriber::firstOrCreate(
            ['email' => strtolower($data['email'])],
            ['nama' => $data['nama'] ?? null, 'active' => true]
        );
        return back()->with('news_ok', 'Terima kasih! Email Anda berhasil didaftarkan ke newsletter kami.');
    }
}
