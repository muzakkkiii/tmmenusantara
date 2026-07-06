<?php

namespace App\Filament\Resources\DonationResource\Pages;

use App\Filament\Resources\DonationResource;
use App\Models\Donation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDonations extends ListRecords
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Donation::orderByDesc('id')->get();

                    return response()->streamDownload(function () use ($rows) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
                        fputcsv($out, ['Tanggal', 'Donatur', 'WhatsApp', 'Email', 'Nominal', 'Peruntukan', 'Metode', 'Status', 'Catatan']);
                        foreach ($rows as $r) {
                            fputcsv($out, [
                                optional($r->created_at)->format('Y-m-d H:i'),
                                $r->nama,
                                $r->wa,
                                $r->email,
                                (int) $r->nominal,
                                $r->program,
                                $r->metode,
                                $r->status,
                                $r->catatan,
                            ]);
                        }
                        fclose($out);
                    }, 'donasi-' . date('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
