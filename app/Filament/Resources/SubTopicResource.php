<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubTopicResource\Pages;
use App\Filament\Resources\SubTopicResource\RelationManagers;
use App\Models\SubTopic;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubTopicResource extends Resource
{
    protected static ?string $model = SubTopic::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static ?string $navigationGroup = 'Kurikulum';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    Select::make('topic_id')
                        ->relationship('topic', 'title')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label('Topic'),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                    FileUpload::make('thumbnail_url')
                        ->label('Thumbnail URL')
                        ->image()
                        ->required()
                        ->directory('thumbnails')
                        ->maxSize(1024)
                        ->columnSpanFull(),                  
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('topic.title')->label('Topik')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                ImageColumn::make('thumbnail_url')->label('Thumbnail'),
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
            'index' => Pages\ListSubTopics::route('/'),
            'create' => Pages\CreateSubTopic::route('/create'),
            'edit' => Pages\EditSubTopic::route('/{record}/edit'),
        ];
    }
}