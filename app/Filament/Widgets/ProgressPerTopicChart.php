<?php

namespace App\Filament\Widgets;

use App\Models\StudentProgress;
use App\Models\SubTopic;
use Filament\Widgets\ChartWidget;

class ProgressPerTopicChart extends ChartWidget
{
    protected static ?string $heading = 'Progress Siswa per Topik';
    
    protected static ?string $maxHeight = '600px'; // Lebih tinggi untuk horizontal
    
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        $subTopics = SubTopic::with('topic')->get();

        $labels = [];
        $values = [];

        foreach ($subTopics as $subTopic) {
            $labels[] = $subTopic->title;

            $completedCount = StudentProgress::where('sub_topic_id', $subTopic->id)
                ->where('is_completed', 1)
                ->count();

            $values[] = $completedCount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Siswa Selesai',
                    'data' => $values,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 2,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Tetap bar, tapi horizontal lewat options
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // 🔥 INI yang bikin horizontal!
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'x' => [ // X sekarang jadi angka
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                ],
                'y' => [ // Y sekarang jadi label
                    'ticks' => [
                        'autoSkip' => false, // Tampilkan semua label
                    ],
                ],
            ],
        ];
    }
}