<?php

namespace App\Filament\Resources\MaterialSectionsResource\Pages;

use App\Filament\Resources\MaterialSectionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaterialSections extends EditRecord
{
    protected static string $resource = MaterialSectionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
