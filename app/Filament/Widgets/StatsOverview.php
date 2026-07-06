<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Finance;
use App\Models\Lead;
use App\Models\News;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = -3;

    protected function getStats(): array
    {
        $masuk = (int) Finance::where('type', 'masuk')->sum('amt');
        $keluar = (int) Finance::where('type', 'keluar')->sum('amt');
        $saldo = $masuk - $keluar;

        return [
            Stat::make('Data Masuk', (string) Lead::count())
                ->description('Total pesan dari form kontak')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('primary'),
            Stat::make('Belum Diproses', (string) Lead::where('status', 'Baru')->count())
                ->description('Perlu ditindaklanjuti')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color('warning'),
            Stat::make('Berita Terbit', (string) News::count())
                ->description('Artikel di halaman publik')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),
            Stat::make('Saldo Yayasan', rp($saldo))
                ->description('Masuk ' . rp($masuk) . ' / Keluar ' . rp($keluar))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($saldo >= 0 ? 'success' : 'danger'),
            Stat::make('Donasi Terverifikasi', rp((int) Donation::where('status', 'Terverifikasi')->sum('nominal')))
                ->description(Donation::where('status', 'Terverifikasi')->count() . ' donasi terverifikasi')
                ->descriptionIcon('heroicon-m-gift')
                ->color('success'),
            Stat::make('Donasi Menunggu', (string) Donation::whereIn('status', ['Menunggu Verifikasi', 'Menunggu Pembayaran'])->count())
                ->description('Perlu verifikasi / pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
