<?php

namespace App\Filament\Resources\TKAAnswerResource\Pages;

use App\Filament\Resources\TKAAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTKAAnswers extends ListRecords
{
    protected static string $resource = TKAAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
