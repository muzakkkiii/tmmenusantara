<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use App\Models\Partner;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartners extends ListRecords
{
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Partner::orderByDesc('id')->get();
                    return response()->streamDownload(function () use ($rows) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
                        fputcsv($out, ['Tanggal', 'PIC', 'Organisasi', 'Jenis', 'WhatsApp', 'Email', 'Status', 'Detail']);
                        foreach ($rows as $r) {
                            fputcsv($out, [optional($r->created_at)->format('Y-m-d H:i'), $r->nama, $r->organisasi, $r->jenis, $r->wa, $r->email, $r->status, $r->pesan]);
                        }
                        fclose($out);
                    }, 'kemitraan-' . date('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
