<?php

namespace App\Filament\Resources\FinalTestAnswerResource\Pages;

use App\Filament\Resources\FinalTestAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinalTestAnswers extends ListRecords
{
    protected static string $resource = FinalTestAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada create action karena jawaban dibuat otomatis oleh siswa
        ];
    }
}