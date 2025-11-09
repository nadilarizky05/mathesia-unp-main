<?php

namespace App\Filament\Resources\FinalTestResource\Pages;

use App\Filament\Resources\FinalTestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinalTests extends ListRecords
{
    protected static string $resource = FinalTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
