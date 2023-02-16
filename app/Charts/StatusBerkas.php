<?php

namespace App\Charts;

use App\Models\Berkas;
use App\Models\Status;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StatusBerkas
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->addData([
                Berkas::where('status_id', '=', 2)->count(),
                Berkas::where('status_id', '=', 3)->count(),
            ])
            ->setColors(['#1cc88a', "#ff0000"])
            ->setLabels(['Diterima', 'Terlambat']);
    }
}
