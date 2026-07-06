<?php

namespace App\Http\Controllers;

use App\Models\ActivityReport;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Finance;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PublicController extends Controller
{
    public function beranda()
    {
        $news = News::orderByDesc('id')->take(3)->get();
        return view('public.beranda', compact('news'));
    }

    public function tentang()
    {
        return view('public.tentang');
    }

    public function program()
    {
        $programs = Program::where('aktif', true)->orderBy('urutan')->orderBy('id')->get();
        if ($programs->isEmpty()) {
            $programs = $this->defaultPrograms();
        }
        return view('public.program', compact('programs'));
    }

    /** Fallback bila tabel programs belum di-seed. */
    private function defaultPrograms()
    {
        $wa = \App\Models\Setting::get('wa', '6282332651802');
        return collect([
            (object) [
                'tag' => 'Mitra Solusi Diskusi Terintegrasi',
                'judul' => 'Pendidikan @ Malang',
                'poin' => "Pendampingan memilih kampus dan jurusan\nInformasi hunian dan adaptasi kota\nKelas bahasa dan skill akademik\nOlahraga, silat, seni budaya, dan jejaring komunitas positif\nPendampingan komunikasi dengan orang tua dan calon mahasiswa",
                'pic_nama' => 'Joko', 'pic_telp' => $wa, 'info' => null,
                'visual_label' => 'Pendidikan', 'cta_label' => 'Daftar / Konsultasi', 'cta_route' => 'daftar',
            ],
            (object) [
                'tag' => 'Mitra Strategis Pengembangan Bisnis Anda',
                'judul' => 'Pengembangan Bisnis & SDM',
                'poin' => "Pelatihan dan penyediaan SDM\nDiskusi pengelolaan bisnis\nPendampingan dokumen hukum, pertanahan, dan perpajakan\nKemitraan dengan UMKM, perusahaan, komunitas, dan lembaga\nPenguatan tata kelola usaha agar lebih tertib dan efisien",
                'pic_nama' => 'Dadang', 'pic_telp' => $wa, 'info' => 'Gedung MCC Lt. 1, Malang',
                'visual_label' => 'Bisnis & SDM', 'cta_label' => 'Daftar / Konsultasi', 'cta_route' => 'daftar',
            ],
            (object) [
                'tag' => 'Hidup untuk Berprestasi',
                'judul' => 'Club Cakra Buana',
                'poin' => "Olahraga prestasi untuk pelajar dan umum\nSeni bela diri sebagai pembinaan budaya, disiplin, dan identitas\nBela diri praktis untuk masyarakat umum dan tenaga keamanan\nLatihan terprogram, terbuka untuk pelajar & umum",
                'pic_nama' => 'Sutopo', 'pic_telp' => $wa, 'info' => 'Gedung SKB, Blimbing - Kamis & Sabtu 19.00-23.00',
                'visual_label' => 'Olahraga & Bela Diri', 'cta_label' => 'Daftar Latihan', 'cta_route' => 'daftar',
            ],
            (object) [
                'tag' => 'Pengabdian & Pelestarian',
                'judul' => 'Sosial, Seni Budaya & Sarana Prasarana',
                'poin' => "Kegiatan bakti sosial, kemanusiaan, dan gotong royong\nPelestarian seni budaya lokal, banjari, dan semarak budaya\nPublikasi bantuan/hibah, inventaris, dan dokumentasi sarana\nPengembangan padepokan sebagai pusat kegiatan",
                'pic_nama' => null, 'pic_telp' => null, 'info' => 'Kolaborasi terbuka untuk relawan & mitra',
                'visual_label' => 'Sosial & Budaya', 'cta_label' => 'Kolaborasi & Dukungan', 'cta_route' => 'mitra',
            ],
        ]);
    }

    public function berita(Request $r)
    {
        $q = trim((string) $r->input('q', ''));
        $news = News::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%')
                    ->orWhere('body', 'like', '%' . $q . '%');
            })
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('public.berita', compact('news', 'q'));
    }

    public function beritaShow(News $news)
    {
        $others = News::where('id', '!=', $news->id)->orderByDesc('id')->take(3)->get();
        return view('public.berita-show', compact('news', 'others'));
    }

    public function kemitraan()
    {
        return view('public.kemitraan');
    }

    /* -------- Galeri Foto -------- */
    public function galeri()
    {
        $items = Gallery::orderByDesc('id')->get();
        return view('public.galeri', compact('items'));
    }

    /* -------- Form Kemitraan (khusus) -------- */
    public function mitra()
    {
        return view('public.mitra');
    }

    /* -------- Form Pendaftaran Peserta -------- */
    public function daftar()
    {
        return view('public.daftar');
    }

    /* -------- Gabung Anggota / Relawan -------- */
    public function relawan()
    {
        return view('public.relawan');
    }

    /* -------- Agenda / Kalender Kegiatan -------- */
    public function agenda()
    {
        $now = Carbon::now();
        $mendatang = Event::where('status', '!=', 'Batal')
            ->where('mulai', '>=', $now->copy()->startOfDay())
            ->orderBy('mulai')->get();
        $lampau = Event::where('mulai', '<', $now->copy()->startOfDay())
            ->orderByDesc('mulai')->limit(20)->get();

        // Kalender bulanan: navigasi via ?bulan=YYYY-MM
        $bulan = (string) request()->query('bulan', '');
        try {
            $cursor = $bulan !== ''
                ? Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()
                : $now->copy()->startOfMonth();
        } catch (\Throwable $e) {
            $cursor = $now->copy()->startOfMonth();
        }
        $calEvents = Event::where('status', '!=', 'Batal')
            ->whereBetween('mulai', [$cursor->copy()->startOfMonth()->startOfDay(), $cursor->copy()->endOfMonth()->endOfDay()])
            ->orderBy('mulai')->get()
            ->groupBy(fn ($e) => $e->mulai->format('Y-m-d'));
        $prevBulan = $cursor->copy()->subMonth()->format('Y-m');
        $nextBulan = $cursor->copy()->addMonth()->format('Y-m');

        return view('public.agenda', compact('mendatang', 'lampau', 'cursor', 'calEvents', 'prevBulan', 'nextBulan'));
    }

    /* -------- Laporan Kegiatan -------- */
    public function laporan()
    {
        $reports = ActivityReport::orderByDesc('tanggal')->orderByDesc('id')->get();
        return view('public.laporan', compact('reports'));
    }

    /* -------- Verifikasi Sertifikat -------- */
    public function sertifikat(?string $kode = null)
    {
        $cert = null;
        $notFound = false;
        if ($kode) {
            $cert = Certificate::where('kode', $kode)->first();
            $notFound = ! $cert;
        }
        return view('public.sertifikat', compact('cert', 'kode', 'notFound'));
    }

    public function transparansi(Request $r)
    {
        $all = Finance::orderBy('tgl')->get();

        $years = $all->map(fn ($f) => Carbon::parse($f->tgl)->year)
            ->push((int) date('Y'))
            ->unique()->sortDesc()->values();

        $year = (int) $r->input('tahun', $years->first() ?? date('Y'));

        $rows = $all->filter(fn ($f) => Carbon::parse($f->tgl)->year === $year);
        $ins  = $rows->where('type', 'masuk')->values();
        $outs = $rows->where('type', 'keluar')->values();
        $totalIn  = (int) $ins->sum('amt');
        $totalOut = (int) $outs->sum('amt');

        return view('public.transparansi', [
            'years'    => $years,
            'year'     => $year,
            'ins'      => $ins,
            'outs'     => $outs,
            'totalIn'  => $totalIn,
            'totalOut' => $totalOut,
            'saldo'    => $totalIn - $totalOut,
            'count'    => $rows->count(),
        ]);
    }

    public function kontak(Request $r)
    {
        return view('public.kontak', [
            'prefill' => $r->input('prefill'),
        ]);
    }
}
