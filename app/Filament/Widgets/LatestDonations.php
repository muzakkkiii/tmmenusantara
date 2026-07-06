<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Finance;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestDonations extends BaseWidget
{
    protected static ?string $heading = 'Donasi Terbaru';

    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Donation::query()->latest()->limit(8))
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('nama')->label('Donatur')->searchable(),
                Tables\Columns\TextColumn::make('nominal')->label('Nominal')->money('IDR'),
                Tables\Columns\TextColumn::make('program')->label('Peruntukan')->badge(),
                Tables\Columns\TextColumn::make('metode')->label('Metode')->badge(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (?string $s): string => match ($s) {
                    'Menunggu Pembayaran' => 'info',
                    'Menunggu Verifikasi' => 'warning',
                    'Terverifikasi' => 'success',
                    'Batal' => 'danger',
                    default => 'gray',
                }),
            ])
            ->actions([
                Tables\Actions\Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (Donation $record): bool => $record->status !== 'Terverifikasi')
                    ->requiresConfirmation()
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
            ]);
    }
}
