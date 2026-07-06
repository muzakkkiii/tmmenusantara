<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Program';
    protected static ?string $modelLabel = 'Program';
    protected static ?string $pluralModelLabel = 'Program';
    protected static ?int $navigationSort = 2;

    public const ROUTES = [
        'daftar' => 'Form Pendaftaran / Konsultasi',
        'mitra'  => 'Form Kemitraan',
        'kontak' => 'Halaman Kontak',
        'donasi' => 'Halaman Donasi',
    ];

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')->label('Judul Program')->required()->maxLength(200)->columnSpanFull(),
            Forms\Components\TextInput::make('tag')->label('Tagline / Sub-judul')->maxLength(200)->columnSpanFull(),
            Forms\Components\Textarea::make('poin')->label('Poin Layanan (satu per baris)')->rows(5)->helperText('Tiap baris menjadi satu butir daftar di halaman program.')->columnSpanFull(),
            Forms\Components\TextInput::make('pic_nama')->label('Nama PIC')->maxLength(120),
            Forms\Components\TextInput::make('pic_telp')->label('No. Telp / WhatsApp PIC')->tel()->maxLength(40)->helperText('Format 62... atau 08... (otomatis jadi tautan WhatsApp).'),
            Forms\Components\TextInput::make('info')->label('Info tambahan (lokasi / jadwal)')->maxLength(255)->columnSpanFull(),
            Forms\Components\TextInput::make('visual_label')->label('Label pada gambar (opsional)')->maxLength(120)->placeholder('mis. Pendidikan'),
            Forms\Components\FileUpload::make('img')
                ->label('Foto / Flyer Program')
                ->image()->fetchFileInformation(false)->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                ->disk('public')
                ->directory('program')
                ->imageEditor()
                ->imageEditorAspectRatios(['3:4', '4:3', '1:1'])
                ->imageEditorViewportWidth('900')
                ->imageEditorViewportHeight('1200')
                ->openable()
                ->downloadable()
                ->maxSize(3072)
                ->helperText('Disarankan orientasi potret (3:4). Tampil sebagai flyer program di website. Atur area crop lewat tombol pensil.')
                ->columnSpanFull()
                ->nullable(),
            Forms\Components\TextInput::make('cta_label')->label('Teks tombol')->maxLength(120)->placeholder('Daftar / Konsultasi'),
            Forms\Components\Select::make('cta_route')->label('Tujuan tombol')->options(static::ROUTES)->default('daftar')->native(false),
            Forms\Components\TextInput::make('urutan')->label('Urutan tampil')->numeric()->default(0)->helperText('Angka lebih kecil tampil lebih dulu.'),
            Forms\Components\Toggle::make('aktif')->label('Tampilkan di website')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->sortable()->wrap(),
                Tables\Columns\TextColumn::make('pic_nama')->label('PIC')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('pic_telp')->label('Telp PIC')->toggleable(),
                Tables\Columns\IconColumn::make('aktif')->label('Aktif')->boolean(),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit'   => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
