<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $r)
    {
        // Honeypot anti-spam: field "website" tersembunyi; jika terisi -> bot.
        if ($r->filled('website')) {
            return redirect()->route('kontak')->with('ok', 'Terima kasih, pesan Anda telah dikirim.');
        }

        $data = $r->validate([
            'nama'     => 'required|string|max:120',
            'wa'       => 'required|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
            'email'    => 'nullable|email|max:120',
            'kategori' => 'required|string|max:60',
            'pesan'    => 'nullable|string|max:2000',
        ], [
            'nama.required'     => 'Nama wajib diisi.',
            'wa.required'       => 'Nomor WhatsApp wajib diisi.',
            'wa.regex'          => 'Format nomor WhatsApp tidak valid (contoh: 08123456789).',
            'email.email'       => 'Format email tidak valid.',
            'kategori.required' => 'Silakan pilih kebutuhan Anda.',
        ]);

        $data['status'] = 'Baru';
        Lead::create($data);

        // Notifikasi email otomatis ke admin (aman bila mail belum diatur).
        notify_admin(
            'Lead baru: ' . $data['nama'] . ' (' . $data['kategori'] . ')',
            "Ada pesan/kebutuhan baru dari website:\n\n"
            . 'Nama: ' . $data['nama'] . "\n"
            . 'WhatsApp: ' . $data['wa'] . "\n"
            . 'Email: ' . ($data['email'] ?: '-') . "\n"
            . 'Kebutuhan: ' . $data['kategori'] . "\n"
            . 'Pesan: ' . ($data['pesan'] ?: '-') . "\n\n"
            . 'Kelola di panel admin: ' . url('/admin/leads')
        );

        // Susun pesan WhatsApp ke admin (tetap seperti prototype)
        $adminWa = setting('wa', config('yayasan.wa_admin'));
        $msg = "Halo Yayasan TM Menusantara,\n\n"
            . 'Nama: ' . $data['nama'] . "\n"
            . 'WhatsApp: ' . $data['wa'] . "\n"
            . 'Email: ' . ($data['email'] ?: '-') . "\n"
            . 'Kebutuhan: ' . $data['kategori'] . "\n"
            . 'Pesan: ' . ($data['pesan'] ?: '-');

        return redirect()->route('kontak')
            ->with('lead', $data)
            ->with('wa_url', wa_link($adminWa, $msg));
    }
}
