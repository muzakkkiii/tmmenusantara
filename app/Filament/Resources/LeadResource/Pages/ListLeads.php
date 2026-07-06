<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use App\Models\Lead;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Lead::orderByDesc('id')->get();

                    return response()->streamDownload(function () use ($rows) {
                        $out = fopen('php://output', 'w');
                        // BOM UTF-8 agar aman dibuka di Excel
                        fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
                        fputcsv($out, ['Tanggal', 'Nama', 'WhatsApp', 'Email', 'Kategori', 'Status', 'Pesan']);
                        foreach ($rows as $r) {
                            fputcsv($out, [
                                optional($r->created_at)->format('Y-m-d H:i'),
                                $r->nama,
                                $r->wa,
                                $r->email,
                                $r->kategori,
                                $r->status,
                                $r->pesan,
                            ]);
                        }
                        fclose($out);
                    }, 'data-masuk-' . date('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
