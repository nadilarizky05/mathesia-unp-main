<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')->schema([
                    Forms\Components\TextInput::make('nis')
                        ->label('NIS')
                        ->required(),

                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->label('Email'),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->label('Password')
                        ->required()
                        ->dehydrateStateUsing(fn($state) => bcrypt($state)),

                    Forms\Components\Select::make('role')
                        ->options([
                            'student' => 'Student',
                            'teacher' => 'Teacher',
                            'admin' => 'Admin',
                        ])
                        ->label('Role')
                        ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nis')
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('role')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'admin' => 'danger',
                    'teacher' => 'warning',
                    'student' => 'success',
                }),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('role')
                ->options([
                    'student' => 'Student',
                    'teacher' => 'Teacher',
                    'admin' => 'Admin',
                ]),
        ])
        ->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ]),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
