<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Konten Halaman';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.site-content';
    protected static ?string $title = 'Konten Halaman (Teks & Gambar)';

    public ?array $data = [];

    /**
     * Definisi kolom per halaman. Format: 'kunci' => ['tipe', 'label'].
     * tipe: image | text | textarea. Kosongkan kolom untuk memakai tampilan bawaan.
     */
    public static function groups(): array
    {
        return [
            'Beranda' => [
                'home_hero_img' => ['image', 'Gambar Hero (background besar)'],
                'home_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'home_hero_title' => ['textarea', 'Hero – Judul (boleh <em>miring</em>)'],
                'home_hero_lead' => ['textarea', 'Hero – Deskripsi'],
                'home_about_img' => ['image', 'Gambar “Sekilas Yayasan”'],
                'home_why_img' => ['image', 'Gambar background “Kenapa Kami”'],
            ],
            'Tentang' => [
                'tentang_hero_img' => ['image', 'Gambar Hero'],
                'tentang_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'tentang_hero_title' => ['textarea', 'Hero – Judul'],
                'tentang_hero_lead' => ['textarea', 'Hero – Deskripsi'],
                'tentang_img2' => ['image', 'Gambar isi #1'],
                'tentang_img3' => ['image', 'Gambar isi #2'],
            ],
            'Program' => [
                'program_hero_img' => ['image', 'Gambar Hero'],
                'program_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'program_hero_title' => ['textarea', 'Hero – Judul'],
                'program_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Berita' => [
                'berita_hero_img' => ['image', 'Gambar Hero'],
                'berita_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'berita_hero_title' => ['textarea', 'Hero – Judul'],
                'berita_hero_lead' => ['textarea', 'Hero – Deskripsi'],
                'beritashow_hero_img' => ['image', 'Gambar Hero halaman detail berita'],
            ],
            'Kemitraan' => [
                'kemitraan_hero_img' => ['image', 'Gambar Hero'],
                'kemitraan_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'kemitraan_hero_title' => ['textarea', 'Hero – Judul'],
                'kemitraan_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Donasi' => [
                'donasi_hero_img' => ['image', 'Gambar Hero'],
                'donasi_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'donasi_hero_title' => ['textarea', 'Hero – Judul'],
                'donasi_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Kontak' => [
                'kontak_hero_img' => ['image', 'Gambar Hero'],
                'kontak_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'kontak_hero_title' => ['textarea', 'Hero – Judul'],
                'kontak_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Galeri' => [
                'galeri_hero_img' => ['image', 'Gambar Hero'],
                'galeri_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'galeri_hero_title' => ['textarea', 'Hero – Judul'],
                'galeri_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Agenda' => [
                'agenda_hero_img' => ['image', 'Gambar Hero'],
                'agenda_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'agenda_hero_title' => ['textarea', 'Hero – Judul'],
                'agenda_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Transparansi' => [
                'transparansi_hero_img' => ['image', 'Gambar Hero'],
                'transparansi_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'transparansi_hero_title' => ['textarea', 'Hero – Judul'],
                'transparansi_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Laporan' => [
                'laporan_hero_img' => ['image', 'Gambar Hero'],
                'laporan_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'laporan_hero_title' => ['textarea', 'Hero – Judul'],
                'laporan_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Form Mitra' => [
                'mitra_hero_img' => ['image', 'Gambar Hero'],
                'mitra_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'mitra_hero_title' => ['textarea', 'Hero – Judul'],
                'mitra_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Form Daftar' => [
                'daftar_hero_img' => ['image', 'Gambar Hero'],
                'daftar_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'daftar_hero_title' => ['textarea', 'Hero – Judul'],
                'daftar_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Form Relawan' => [
                'relawan_hero_img' => ['image', 'Gambar Hero'],
                'relawan_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'relawan_hero_title' => ['textarea', 'Hero – Judul'],
                'relawan_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
            'Sertifikat' => [
                'sertifikat_hero_img' => ['image', 'Gambar Hero'],
                'sertifikat_hero_eyebrow' => ['text', 'Hero – Label kecil'],
                'sertifikat_hero_title' => ['textarea', 'Hero – Judul'],
                'sertifikat_hero_lead' => ['textarea', 'Hero – Deskripsi'],
            ],
        ];
    }

    public function mount(): void
    {
        $data = [];
        foreach (static::groups() as $fields) {
            foreach ($fields as $key => $def) {
                $data[$key] = Setting::get($key);
            }
        }
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        $tabs = [];
        foreach (static::groups() as $page => $fields) {
            $schema = [];
            foreach ($fields as $key => $def) {
                [$type, $label] = $def;
                $schema[] = match ($type) {
                    'image' => FileUpload::make($key)
                        ->label($label)
                        ->image()->fetchFileInformation(false)
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                        ->disk('public')->directory('konten')->visibility('public')
                        ->maxSize(4096)->imagePreviewHeight('120')
                        ->imageEditor()->imageEditorAspectRatios([null, '16:9', '4:3', '1:1'])
                        ->openable()->downloadable()
                        ->helperText('Kosongkan untuk memakai gambar bawaan. Klik gambar untuk crop/atur posisi.'),
                    'textarea' => Textarea::make($key)->label($label)->rows(2)->maxLength(1000)
                        ->helperText('Kosongkan untuk memakai teks bawaan.'),
                    default => TextInput::make($key)->label($label)->maxLength(500)
                        ->helperText('Kosongkan untuk memakai teks bawaan.'),
                };
            }
            $tabs[] = Tabs\Tab::make($page)->schema($schema)->columns(2);
        }

        return $form
            ->schema([
                Tabs::make('Halaman')->tabs($tabs)->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        foreach (static::groups() as $fields) {
            foreach ($fields as $key => $def) {
                if (array_key_exists($key, $data)) {
                    $val = $data[$key];
                    Setting::put($key, $val === null ? '' : $val);
                }
            }
        }

        Notification::make()->title('Konten halaman tersimpan')->success()->send();
    }
}
