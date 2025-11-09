<?php

namespace App\Filament\Resources\MaterialSectionsResource\Pages;

use App\Filament\Resources\MaterialSectionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaterialSections extends ListRecords
{
    protected static string $resource = MaterialSectionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
