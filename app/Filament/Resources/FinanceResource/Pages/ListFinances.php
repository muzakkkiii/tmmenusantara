<?php

namespace App\Filament\Resources\FinanceResource\Pages;

use App\Filament\Resources\FinanceResource;
use App\Models\Finance;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinances extends ListRecords
{
    protected static string $resource = FinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Finance::orderByDesc('tgl')->orderByDesc('id')->get();

                    return response()->streamDownload(function () use ($rows) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
                        fputcsv($out, ['Tanggal', 'Jenis', 'Sumber/Tujuan', 'Program', 'Keterangan', 'Nominal']);
                        foreach ($rows as $r) {
                            fputcsv($out, [
                                (string) $r->tgl,
                                $r->type === 'masuk' ? 'Masuk' : 'Keluar',
                                $r->nama,
                                $r->prog,
                                $r->ket,
                                (int) $r->amt,
                            ]);
                        }
                        fclose($out);
                    }, 'keuangan-' . date('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
