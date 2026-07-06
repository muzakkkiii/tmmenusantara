<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Models\Donation;
use App\Models\Finance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationLabel = 'Donasi';
    protected static ?string $modelLabel = 'Donasi';
    protected static ?string $pluralModelLabel = 'Donasi';
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama', 'email', 'wa'];
    }

    public static function getNavigationBadge(): ?string
    {
        $n = static::getModel()::where('status', 'Menunggu Verifikasi')->count();
        return $n > 0 ? (string) $n : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    protected static function opsi(string $configKey): array
    {
        $vals = (array) config($configKey, []);
        return array_combine($vals, $vals) ?: [];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->label('Nama Donatur')->required()->maxLength(120),
            Forms\Components\TextInput::make('wa')->label('WhatsApp')->maxLength(40),
            Forms\Components\TextInput::make('email')->label('Email')->email()->maxLength(120),
            Forms\Components\TextInput::make('nominal')->label('Nominal')->numeric()->required()->prefix('Rp')->minValue(0),
            Forms\Components\Select::make('program')->label('Peruntukan')->options(static::opsi('donasi.progs'))->native(false),
            Forms\Components\Select::make('metode')->label('Metode')->options([
                'online' => 'Bayar Online (Midtrans)',
                'transfer' => 'Transfer Bank',
                'qris' => 'QRIS',
                'tunai' => 'Tunai',
            ])->required()->native(false),
            Forms\Components\Select::make('status')->label('Status')->options(static::opsi('donasi.statuses'))->default('Menunggu Verifikasi')->native(false),
            Forms\Components\TextInput::make('bukti')->label('Bukti (path)')->maxLength(255)->helperText('Terisi otomatis dari form donasi publik.'),
            Forms\Components\Textarea::make('catatan')->label('Catatan')->rows(3)->maxLength(2000)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('nama')->label('Donatur')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nominal')->label('Nominal')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('program')->label('Peruntukan')->badge()->searchable(),
                Tables\Columns\TextColumn::make('metode')->label('Metode')->badge()->formatStateUsing(fn (?string $s): string => match ($s) {
                    'online' => 'Online',
                    'transfer' => 'Transfer',
                    'qris' => 'QRIS',
                    'tunai' => 'Tunai',
                    default => (string) $s,
                }),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (?string $s): string => match ($s) {
                    'Menunggu Pembayaran' => 'info',
                    'Menunggu Verifikasi' => 'warning',
                    'Terverifikasi' => 'success',
                    'Batal' => 'danger',
                    default => 'gray',
                }),
                Tables\Columns\TextColumn::make('bukti')->label('Bukti')->url(fn (Donation $r): ?string => $r->bukti)->openUrlInNewTab()->formatStateUsing(fn (?string $s): string => $s ? 'Lihat' : '-'),
                Tables\Columns\TextColumn::make('gateway_ref')->label('Ref Pembayaran')->toggleable(isToggledHiddenByDefault: true)->placeholder('-')->copyable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(static::opsi('donasi.statuses')),
                Tables\Filters\SelectFilter::make('metode')->options([
                    'online' => 'Bayar Online (Midtrans)',
                    'transfer' => 'Transfer Bank',
                    'qris' => 'QRIS',
                    'tunai' => 'Tunai',
                ]),
                Tables\Filters\SelectFilter::make('program')->label('Peruntukan')->options(static::opsi('donasi.progs')),
            ])
            ->actions([
                Tables\Actions\Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (Donation $record): bool => $record->status !== 'Terverifikasi')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi & catat ke Keuangan')
                    ->modalDescription('Donasi ditandai Terverifikasi dan otomatis dicatat sebagai dana masuk di menu Keuangan.')
                    ->action(function (Donation $record): void {
                        $record->update(['status' => 'Terverifikasi']);
                        Finance::create([
                            'type' => 'masuk',
                            'tgl' => now()->toDateString(),
                            'nama' => $record->nama,
                            'prog' => $record->program ?: 'Umum',
                            'ket' => 'Donasi (' . $record->metode . ')',
                            'amt' => (int) $record->nominal,
                        ]);
                        Notification::make()->title('Donasi diverifikasi & dicatat ke Keuangan')->success()->send();
                    }),
                Tables\Actions\Action::make('batalkan')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Donation $record): bool => $record->status !== 'Batal' && $record->status !== 'Terverifikasi')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan donasi ini?')
                    ->action(function (Donation $record): void {
                        $record->update(['status' => 'Batal']);
                        Notification::make()->title('Donasi ditandai Batal')->warning()->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit'   => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}
