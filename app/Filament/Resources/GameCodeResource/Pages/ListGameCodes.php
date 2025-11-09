<?php

namespace App\Filament\Resources\GameCodeResource\Pages;

use App\Filament\Resources\GameCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGameCodes extends ListRecords
{
    protected static string $resource = GameCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
