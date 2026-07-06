<?php

namespace App\Filament\Resources\SubscriberResource\Pages;

use App\Filament\Resources\SubscriberResource;
use App\Models\Subscriber;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;

class ListSubscribers extends ListRecords
{
    protected static string $resource = SubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kirim')
                ->label('Kirim Newsletter')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->form([
                    Forms\Components\TextInput::make('subjek')->label('Subjek')->required()->maxLength(160),
                    Forms\Components\Textarea::make('isi')->label('Isi Pesan')->required()->rows(8),
                ])
                ->requiresConfirmation()
                ->modalHeading('Kirim newsletter ke semua pelanggan aktif')
                ->action(function (array $data): void {
                    $emails = Subscriber::where('active', true)->pluck('email')->filter()->all();
                    $ok = 0;
                    foreach ($emails as $to) {
                        try {
                            Mail::raw($data['isi'], function ($m) use ($to, $data) {
                                $m->to($to)->subject($data['subjek']);
                            });
                            $ok++;
                        } catch (\Throwable $e) {
                            // lanjut ke email berikutnya
                        }
                    }
                    Notification::make()->title('Newsletter dikirim ke ' . $ok . ' pelanggan')->success()->send();
                }),
            Actions\Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $rows = Subscriber::orderByDesc('id')->get();
                    return response()->streamDownload(function () use ($rows) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
                        fputcsv($out, ['Email', 'Nama', 'Aktif', 'Tanggal']);
                        foreach ($rows as $r) {
                            fputcsv($out, [$r->email, $r->nama, $r->active ? 'Ya' : 'Tidak', optional($r->created_at)->format('Y-m-d H:i')]);
                        }
                        fclose($out);
                    }, 'newsletter-' . date('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
