<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Resources\ParticipantResource;
use App\Models\Participant;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParticipants extends ListRecords
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Participant::orderByDesc('id')->get();
                    return response()->streamDownload(function () use ($rows) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
                        fputcsv($out, ['Tanggal', 'Nama', 'WhatsApp', 'Email', 'Program', 'Asal', 'Status', 'Catatan']);
                        foreach ($rows as $r) {
                            fputcsv($out, [optional($r->created_at)->format('Y-m-d H:i'), $r->nama, $r->wa, $r->email, $r->program, $r->asal, $r->status, $r->catatan]);
                        }
                        fclose($out);
                    }, 'peserta-' . date('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
