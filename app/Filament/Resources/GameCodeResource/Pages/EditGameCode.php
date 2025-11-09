<?php

namespace App\Filament\Resources\GameCodeResource\Pages;

use App\Filament\Resources\GameCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGameCode extends EditRecord
{
    protected static string $resource = GameCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
