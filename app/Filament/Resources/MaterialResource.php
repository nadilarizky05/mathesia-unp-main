<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Kurikulum';
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    Forms\Components\Select::make('sub_topic_id')
                        ->relationship('subtopic', 'title')
                        ->required()
                        ->label('Subtopik'),
                    Forms\Components\TextInput::make('title')->required(),
                    Forms\Components\Select::make('level')
                        ->options([
                            'inferior' => 'Inferior',
                            'reguler' => 'Reguler',
                            'superior' => 'Superior',
                        ])
                        ->required(),
                    Select::make('game_code_id')
                        ->relationship('gameCode', 'code')
                        ->label('Kode Game')
                        ->nullable(),
                    // Forms\Components\RichEditor::make('content')->label('Isi Materi')->required(),
                    TextInput::make('video_url')->label('URL Video')->url()->nullable(),
                    Repeater::make('sections')
                        ->relationship('sections')
                        ->orderable('order')
                        ->schema([
                            TextInput::make('title')->label('Judul Section'),
                            RichEditor::make('wacana')->label('Wacana'),
                            RichEditor::make('masalah')->label('Masalah'),
                            RichEditor::make('berpikir_soal_1')->label('Berpikir Soal 1'),
                            RichEditor::make('berpikir_soal_2')->label('Berpikir Soal 2'),
                            RichEditor::make('rencanakan')->label('Rencanakan'),
                            RichEditor::make('selesaikan')->label('Selesaikan'),
                            RichEditor::make('periksa')->label('Periksa'),
                            RichEditor::make('kerjakan_1')->label('Kerjakan 1'),
                            RichEditor::make('kerjakan_2')->label('Kerjakan 2'),
                        ])
                        ->collapsed() // biar tampil rapi
                        ->label('Sections')
                        ->minItems(1)
                        ->cloneable()


                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subtopic.title')->label('Subtopik')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\BadgeColumn::make('level')
                    ->colors([
                        'success' => 'inferior',
                        'warning' => 'reguler',
                        'danger' => 'superior',
                    ]),
                Tables\Columns\TextColumn::make('order')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'inferior' => 'Inferior',
                        'reguler' => 'Reguler',
                        'superior' => 'Superior',
                    ])
                    ->label('Filter Level'),
            ])->filters([
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}