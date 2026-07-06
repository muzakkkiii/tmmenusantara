<?php

namespace App\Filament\Widgets;

use App\Models\Finance;
use Filament\Widgets\ChartWidget;

class FinanceChart extends ChartWidget
{
    protected static ?string $heading = 'Arus Kas 6 Bulan Terakhir';

    protected static ?int $sort = -1;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $labels = [];
        $masuk = [];
        $keluar = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->startOfMonth()->subMonths($i);
            $labels[] = $bulan->format('M Y');
            $masuk[] = (int) Finance::where('type', 'masuk')
                ->whereYear('tgl', $bulan->year)
                ->whereMonth('tgl', $bulan->month)
                ->sum('amt');
            $keluar[] = (int) Finance::where('type', 'keluar')
                ->whereYear('tgl', $bulan->year)
                ->whereMonth('tgl', $bulan->month)
                ->sum('amt');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Dana Masuk',
                    'data' => $masuk,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.5)',
                    'borderColor' => '#10b981',
                ],
                [
                    'label' => 'Dana Keluar',
                    'data' => $keluar,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => '#ef4444',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
