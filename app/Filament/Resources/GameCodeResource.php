<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameCodeResource\Pages;
use App\Filament\Resources\GameCodeResource\RelationManagers;
use App\Models\GameCode;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GameCodeResource extends Resource
{
    protected static ?string $model = GameCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Gamifikasi';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    Forms\Components\Select::make('sub_topic_id')
                        ->relationship('subtopic', 'title')
                        ->required()
                        ->searchable()
                        ->label('Subtopik'),
                    Forms\Components\TextInput::make('code')->required(),
                    Forms\Components\Select::make('level')
                        ->options([
                            'inferior' => 'Inferior',
                            'reguler' => 'Reguler',
                            'superior' => 'Superior',
                        ])
                        ->required(),
                    TextInput::make('game_url')->url()->required(),
                    Forms\Components\RichEditor::make('description')->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subtopic.title')->label('Subtopik')->searchable(),
                Tables\Columns\TextColumn::make('code')->searchable(),
                Tables\Columns\BadgeColumn::make('level')
                    ->colors([
                        'success' => 'inferior',
                        'warning' => 'reguler',
                        'danger' => 'superior',
                    ])->searchable()->sortable(),                
                Tables\Columns\TextColumn::make('description')->limit(50),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGameCodes::route('/'),
            'create' => Pages\CreateGameCode::route('/create'),
            'edit' => Pages\EditGameCode::route('/{record}/edit'),
        ];
    }
}