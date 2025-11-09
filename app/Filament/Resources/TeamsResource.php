<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamsResource\Pages;
use App\Filament\Resources\TeamsResource\RelationManagers;
use App\Models\Teams;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamsResource extends Resource
{
    protected static ?string $model = Teams::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Our Team';
    protected static ?string $navigationGroup = 'Team';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('slug')->required()->unique(Teams::class, 'slug'),
                    RichEditor::make('description'),
                    Repeater::make('members')
                        ->relationship('members') // uses hasMany TeamMember
                        ->orderable('order')
                        ->schema([
                            TextInput::make('name')->required(),
                            TextInput::make('role')->nullable(),
                            FileUpload::make('avatar_url')->label('Avatar URL')->nullable(),                           
                            TextInput::make('order')->numeric()->default(0),
                        ])
                        ->label('Members')
                        ->collapsible()
                        ->minItems(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('members_count')->counts('members')->label('Members'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
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

     public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('members');
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeams::route('/create'),
            'edit' => Pages\EditTeams::route('/{record}/edit'),
        ];
    }
}