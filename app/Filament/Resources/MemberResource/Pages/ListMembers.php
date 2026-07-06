<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Member;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Member::orderBy('nama')->get();
                    return response()->streamDownload(function () use ($rows) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
                        fputcsv($out, ['Nama', 'Peran', 'Bidang', 'WhatsApp', 'Email', 'Status', 'Alamat']);
                        foreach ($rows as $r) {
                            fputcsv($out, [$r->nama, $r->peran, $r->bidang, $r->wa, $r->email, $r->status, $r->alamat]);
                        }
                        fclose($out);
                    }, 'anggota-relawan-' . date('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
