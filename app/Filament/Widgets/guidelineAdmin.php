<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class guidelineAdmin extends Widget
{
    protected static string $view = 'filament.widgets.guideline-admin';
    
    protected static ?int $sort = 1; // Tambahkan ini agar muncul pertama
    
    // Opsional: Atur lebar widget menjadi full
    protected int | string | array $columnSpan = 'full';
}