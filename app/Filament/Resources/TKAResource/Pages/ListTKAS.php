<?php

namespace App\Filament\Resources\TKAResource\Pages;

use App\Filament\Resources\TKAResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTKAS extends ListRecords
{
    protected static string $resource = TKAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
