<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\Member;
use App\Models\Participant;
use App\Models\Partner;
use Livewire\Component;

class PublicForm extends Component
{
    public string $type = 'kontak';

    public string $nama = '';
    public string $wa = '';
    public string $email = '';
    public string $pesan = '';
    public string $organisasi = '';
    public string $jenis = '';
    public string $peran = 'Relawan';
    public string $bidang = '';
    public string $alamat = '';
    public string $program = '';
    public string $asal = '';
    public string $catatan = '';
    public string $kategori = 'Lainnya';
    public string $website = '';

    public bool $done = false;
    public string $okMessage = '';
    public ?string $waUrl = null;

    public function mount(string $type = 'kontak', string $program = ''): void
    {
        $this->type = $type;
        if ($program !== '') {
            $this->program = $program;
        }
    }

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    protected function rules(): array
    {
        return match ($this->type) {
            'mitra' => [
                'nama' => 'required|string|max:120',
                'organisasi' => 'nullable|string|max:160',
                'wa' => 'nullable|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
                'email' => 'nullable|email|max:120',
                'jenis' => 'nullable|string|max:80',
                'pesan' => 'nullable|string|max:3000',
            ],
            'daftar' => [
                'nama' => 'required|string|max:120',
                'wa' => 'nullable|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
                'email' => 'nullable|email|max:120',
                'program' => 'nullable|string|max:80',
                'asal' => 'nullable|string|max:160',
                'catatan' => 'nullable|string|max:2000',
            ],
            'relawan' => [
                'nama' => 'required|string|max:120',
                'wa' => 'nullable|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
                'email' => 'nullable|email|max:120',
                'peran' => 'nullable|string|max:40',
                'bidang' => 'nullable|string|max:120',
                'alamat' => 'nullable|string|max:255',
            ],
            default => [
                'nama' => 'required|string|max:120',
                'wa' => 'required|regex:/^[0-9+\-\s().]{8,20}$/|max:40',
                'email' => 'nullable|email|max:120',
                'kategori' => 'required|string|max:60',
                'pesan' => 'nullable|string|max:2000',
            ],
        };
    }

    protected function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'wa.required' => 'Nomor WhatsApp wajib diisi.',
            'wa.regex' => 'Format nomor WhatsApp tidak valid (contoh: 08123456789).',
            'email.email' => 'Format email tidak valid.',
            'kategori.required' => 'Silakan pilih kebutuhan Anda.',
        ];
    }

    public function submit()
    {
        if (filled($this->website)) {
            $this->finish('Terima kasih, pesan Anda telah kami terima.');
            return;
        }

        $data = $this->validate();
        $data['status'] = 'Baru';

        switch ($this->type) {
            case 'mitra':
                $row = Partner::create($data);
                notify_admin(
                    'Pengajuan kemitraan baru: ' . $row->nama,
                    'Nama: ' . $row->nama . "\n"
                    . 'Organisasi: ' . ($row->organisasi ?: '-') . "\n"
                    . 'Jenis: ' . ($row->jenis ?: '-') . "\n"
                    . 'WhatsApp: ' . ($row->wa ?: '-') . "\n"
                    . 'Email: ' . ($row->email ?: '-') . "\n"
                    . 'Detail: ' . ($row->pesan ?: '-') . "\n\n"
                    . 'Kelola: ' . url('/admin/partners')
                );
                $this->finish('Terima kasih, ' . $row->nama . '! Pengajuan kemitraan Anda sudah kami terima dan akan segera ditindaklanjuti tim kami.');
                break;

            case 'daftar':
                $row = Participant::create($data);
                notify_admin(
                    'Pendaftar peserta baru: ' . $row->nama,
                    'Nama: ' . $row->nama . "\n"
                    . 'Program: ' . ($row->program ?: '-') . "\n"
                    . 'WhatsApp: ' . ($row->wa ?: '-') . "\n"
                    . 'Asal: ' . ($row->asal ?: '-') . "\n\n"
                    . 'Kelola: ' . url('/admin/participants')
                );
                $this->finish('Terima kasih, ' . $row->nama . '! Pendaftaran Anda berhasil. Tim kami akan menghubungi Anda melalui kontak yang diberikan.');
                break;

            case 'relawan':
                $data['peran'] = $data['peran'] ?? 'Relawan';
                $data['status'] = 'Aktif';
                $row = Member::create($data);
                notify_admin(
                    'Anggota/relawan baru: ' . $row->nama,
                    'Nama: ' . $row->nama . "\n"
                    . 'Peran: ' . $row->peran . "\n"
                    . 'Bidang: ' . ($row->bidang ?: '-') . "\n"
                    . 'WhatsApp: ' . ($row->wa ?: '-') . "\n\n"
                    . 'Kelola: ' . url('/admin/members')
                );
                $this->finish('Terima kasih, ' . $row->nama . '! Anda berhasil terdaftar sebagai ' . strtolower($row->peran) . '. Sampai jumpa di kegiatan kami.');
                break;

            default:
                $row = Lead::create($data);
                notify_admin(
                    'Lead baru: ' . $row->nama . ' (' . $row->kategori . ')',
                    'Nama: ' . $row->nama . "\n"
                    . 'WhatsApp: ' . $row->wa . "\n"
                    . 'Email: ' . ($row->email ?: '-') . "\n"
                    . 'Kebutuhan: ' . $row->kategori . "\n"
                    . 'Pesan: ' . ($row->pesan ?: '-') . "\n\n"
                    . 'Kelola: ' . url('/admin/leads')
                );
                $adminWa = setting('wa', config('yayasan.wa_admin'));
                $msg = "Halo Yayasan TM Menusantara,\n\n"
                    . 'Nama: ' . $row->nama . "\n"
                    . 'WhatsApp: ' . $row->wa . "\n"
                    . 'Email: ' . ($row->email ?: '-') . "\n"
                    . 'Kebutuhan: ' . $row->kategori . "\n"
                    . 'Pesan: ' . ($row->pesan ?: '-');
                $this->waUrl = wa_link($adminWa, $msg);
                $this->finish('Terima kasih, ' . $row->nama . '! Pesan Anda sudah kami terima.');
        }
    }

    protected function finish(string $message): void
    {
        $this->done = true;
        $this->okMessage = $message;
    }

    public function resetForm(): void
    {
        $this->reset(['nama', 'wa', 'email', 'pesan', 'organisasi', 'jenis', 'bidang', 'alamat', 'asal', 'catatan', 'website', 'done', 'okMessage', 'waUrl']);
    }

    public function render()
    {
        $labels = [
            'kontak' => 'Kirim & Lanjut ke WhatsApp',
            'mitra' => 'Kirim Pengajuan Kemitraan',
            'relawan' => 'Daftar Sekarang',
            'daftar' => 'Kirim Pendaftaran',
        ];

        return view('livewire.public-form', [
            'submitLabel' => $labels[$this->type] ?? 'Kirim',
            'jenisOptions' => ['Program', 'Sponsorship/CSR', 'Penyediaan SDM', 'Hukum & Perizinan', 'Lainnya'],
            'peranOptions' => ['Relawan', 'Anggota'],
            'progOptions' => config('donasi.progs', ['Umum']),
        ]);
    }
}
