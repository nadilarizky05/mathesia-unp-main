<?php

namespace App\Filament\Resources\TKAAnswerResource\Pages;

use App\Filament\Resources\TKAAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTKAAnswer extends EditRecord
{
    protected static string $resource = TKAAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
