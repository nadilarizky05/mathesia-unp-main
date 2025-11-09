<?php

namespace App\Filament\Resources\StudentFinalTestResource\Pages;

use App\Filament\Resources\StudentFinalTestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentFinalTests extends ListRecords
{
    protected static string $resource = StudentFinalTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
