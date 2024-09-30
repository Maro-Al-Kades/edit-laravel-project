<?php

namespace App\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AreaClientsChart extends ApexChartWidget
{

    protected int | string | array $columnSpan = 'full';


    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'areaClientsChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'عدد العملاء حسب المنطقة';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $arr = [];
        foreach(\App\Models\Area::all() as $area){
            $arr[] = count($area->clients);
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 400,
            ],


            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => $arr,
                ],
            ],
            'xaxis' => [
                'categories' => \App\Models\Area::pluck('name'),
                'labels' => [
                    'style' => [
                        // 'fontFamily' => 'inherit',
                        'fontWeight' => 900,
                    ],
                ],
            ],
            'yaxis' => [
                'show' => false,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#D7C50D'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'vertical' => true,
                ],
            ],
        ];
    }
}
