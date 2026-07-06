<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteBranding extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Logo & Identitas';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.pages.site-branding';
    protected static ?string $title = 'Logo & Identitas Situs';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'logo_url' => Setting::get('logo_url'),
            'hero_img' => Setting::get('hero_img'),
            'qris_img' => Setting::get('qris_img'),
            'wa'       => Setting::get('wa'),
            'email'    => Setting::get('email'),
            'alamat'   => Setting::get('alamat'),
            'proposal_url' => Setting::get('proposal_url'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Logo Situs')
                    ->description('Logo tampil di header (dan menggantikan badge "TM" bawaan). Gunakan PNG berlatar transparan agar menyatu dengan desain.')
                    ->schema([
                        FileUpload::make('logo_url')
                            ->label('Berkas Logo')
                            ->image()->fetchFileInformation(false)->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imagePreviewHeight('80')
                            ->imageEditor()->imageEditorAspectRatios([null])->openable()->downloadable()
                            ->helperText('Disarankan PNG latar transparan, tinggi minimal 80px (mis. 240x80). Klik gambar untuk crop/atur posisi. Kosongkan untuk memakai badge "TM" bawaan.'),
                    ]),
                Section::make('Gambar Hero Beranda')
                    ->description('Foto latar besar di bagian paling atas beranda. Overlay gelap otomatis ditambahkan agar teks tetap terbaca. Kosongkan untuk memakai latar hijau bawaan.')
                    ->schema([
                        FileUpload::make('hero_img')
                            ->label('Foto Hero')
                            ->image()->fetchFileInformation(false)->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->disk('public')->directory('branding')->visibility('public')
                            ->maxSize(4096)->imagePreviewHeight('120')
                            ->imageEditor()->imageEditorAspectRatios([null, '16:9', '21:9'])->openable()->downloadable()
                            ->helperText('Landscape resolusi tinggi, disarankan 1920x1080. Klik gambar untuk crop/atur posisi. Maks 4 MB. Kosongkan untuk latar hijau bawaan.'),
                    ]),
                Section::make('Kode QRIS Donasi')
                    ->description('Gambar QRIS tampil di halaman Donasi. Kosongkan bila belum tersedia.')
                    ->schema([
                        FileUpload::make('qris_img')
                            ->label('Gambar QRIS')
                            ->image()->fetchFileInformation(false)->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->disk('public')->directory('branding')->visibility('public')
                            ->maxSize(2048)->imagePreviewHeight('160')
                            ->imageEditor()->imageEditorAspectRatios([null, '1:1'])->openable()->downloadable()
                            ->helperText('Ekspor QRIS sebagai PNG/JPG. Klik gambar untuk crop/atur posisi. Maks 2 MB.'),
                    ]),
                Section::make('Dokumen Proposal')
                    ->description('Berkas PDF proposal yang dapat diunduh pengunjung dari footer & halaman kemitraan. Kosongkan untuk memakai berkas bawaan.')
                    ->schema([
                        FileUpload::make('proposal_url')
                            ->label('Berkas Proposal (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')->directory('dokumen')->visibility('public')
                            ->maxSize(8192)->downloadable()->openable()
                            ->helperText('Format PDF, maksimal 8 MB.'),
                    ]),
                Section::make('Kontak Resmi')
                    ->description('Dipakai di tombol WhatsApp, halaman Kontak, dan footer.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('wa')
                            ->label('WhatsApp (format 62...)')
                            ->placeholder('6282332651802')
                            ->maxLength(20),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(120),
                        TextInput::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull()
                            ->maxLength(200),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (['logo_url', 'hero_img', 'qris_img', 'proposal_url', 'wa', 'email', 'alamat'] as $key) {
            if (array_key_exists($key, $data)) {
                $val = $data[$key];
                Setting::put($key, $val === null ? '' : $val);
            }
        }

        Notification::make()
            ->title('Pengaturan tersimpan')
            ->success()
            ->send();
    }
}
