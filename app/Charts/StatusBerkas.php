<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Berkas;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::user()->role == 'admin') {
            return $this->chart->pieChart()
                ->addData([
                    Berkas::where('status_id', '=', 2)->whereMonth('created_at', Carbon::now()->month)->count(),
                    Berkas::where('status_id', '=', 3)->whereMonth('created_at', Carbon::now()->month)->count(),
                    Berkas::where('status_id', '=', 4)->whereMonth('created_at', Carbon::now()->month)->count(),
                ])
                ->setColors(['#1cc88a', '#FFDE00', "#ff0000"])
                ->setLabels(['Diterima', 'Terlambat', 'Ditolak'])
                ->setFontFamily('Sans-serif')
                ->setFontColor('#080808');
        } else {
            $id = Auth::user()->id;
            return $this->chart->pieChart()
                ->addData([
                    Berkas::where('status_id', '=', 2)->whereMonth('created_at', Carbon::now()->month)->count(),
                    Berkas::where('status_id', '=', 3)->whereMonth('created_at', Carbon::now()->month)->count(),
                    Berkas::where('status_id', '=', 4)->whereMonth('created_at', Carbon::now()->month)->count(),
                ])
                ->setColors(['#1cc88a', '#FFDE00', "#ff0000"])
                ->setLabels(['Diterima', 'Terlambat', 'Ditolak'])
                ->setFontFamily('Sans-serif')
                ->setFontColor('#080808');
        }
    }
}
