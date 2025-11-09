<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Users')
                ->badge(fn () => \App\Models\User::count()),
            
            'admin' => Tab::make('Admins')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'admin'))
                ->badge(fn () => \App\Models\User::where('role', 'admin')->count())
                ->badgeColor('danger'),
            
            'teacher' => Tab::make('Teachers')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'teacher'))
                ->badge(fn () => \App\Models\User::where('role', 'teacher')->count())
                ->badgeColor('warning'),
            
            'student' => Tab::make('Students')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'student'))
                ->badge(fn () => \App\Models\User::where('role', 'student')->count())
                ->badgeColor('success'),
        ];
    }
}