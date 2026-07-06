<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Sertifikat';
    protected static ?string $modelLabel = 'Sertifikat';
    protected static ?string $pluralModelLabel = 'Sertifikat';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode')
                ->label('Kode / Nomor')
                ->required()
                ->unique(ignoreRecord: true)
                ->default(fn (): string => 'CERT-' . strtoupper(Str::random(8)))
                ->maxLength(60)
                ->helperText('Dipakai untuk verifikasi publik di /sertifikat/{kode}.'),
            Forms\Components\TextInput::make('nama')->label('Nama Penerima')->required()->maxLength(160),
            Forms\Components\TextInput::make('pelatihan')->label('Nama Pelatihan')->required()->maxLength(200),
            Forms\Components\DatePicker::make('tanggal')->label('Tanggal')->native(false),
            Forms\Components\TextInput::make('penandatangan')->label('Penandatangan')->maxLength(160)->default('Dr. Ahmad Syaifudin, S.H., M.H.'),
            Forms\Components\TextInput::make('jabatan_ttd')->label('Jabatan Penandatangan')->maxLength(160)->default('Ketua Yayasan'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')->label('Kode')->searchable()->copyable()->sortable(),
                Tables\Columns\TextColumn::make('nama')->label('Penerima')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('pelatihan')->label('Pelatihan')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->date('d M Y')->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat / Cetak')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Certificate $r): string => url('/sertifikat/' . $r->kode))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit'   => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
