<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinalTestResource\Pages;
use App\Models\FinalTest;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FinalTestResource extends Resource
{
    protected static ?string $model = FinalTest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Tes Akhir';
    protected static ?int $navigationSort = 6;
    protected static ?string $pluralModelLabel = 'Input Soal Tes Akhir';
    protected static ?string $modelLabel = 'Tes Akhir';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Pengaturan Tes Akhir')
                    ->description('Pilih materi dan atur durasi tes')
                    ->schema([
                        Select::make('material_id')
                            ->label('Materi')
                            ->options(Material::pluck('title', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->helperText('Pilih materi untuk tes akhir ini'),

                        TextInput::make('duration_minutes')
                            ->label('Durasi Tes (menit)')
                            ->numeric()
                            ->default(40)
                            ->required()
                            ->helperText('Total waktu yang diberikan untuk mengerjakan semua soal'),
                    ])
                    ->columns(2),

                Section::make('Daftar Soal')
                    ->schema([
                        Repeater::make('questions')
                            ->label('Daftar Soal Tes Akhir')
                            ->schema([
                                RichEditor::make('question')
                                    ->label('Soal')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('max_score')
                                    ->label('Bobot Nilai')
                                    ->numeric()
                                    ->default(25)
                                    ->required()
                                    ->minValue(1)
                                    ->helperText('Nilai maksimal untuk soal ini'),
                            ])
                            ->columns(1)
                            ->defaultItems(3)
                            ->addActionLabel('+ Tambah Soal')
                            ->reorderable()
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('material.title')
                    ->label('Materi')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('total_questions')
                    ->label('Soal')
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->state(function ($record) {
                        $questions = is_string($record->questions) 
                            ? json_decode($record->questions, true) 
                            : $record->questions;
                        return is_array($questions) ? count($questions) : 0;
                    }),

                Tables\Columns\TextColumn::make('total_score')
                    ->label('Total Bobot')
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->state(function ($record) {
                        $questions = is_string($record->questions) 
                            ? json_decode($record->questions, true) 
                            : $record->questions;
                        
                        if (!is_array($questions)) {
                            return 0;
                        }
                        
                        return array_sum(array_column($questions, 'max_score'));
                    }),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Durasi')
                    ->formatStateUsing(fn ($state) => $state . ' menit')
                    ->alignCenter()
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('material_id')
                    ->label('Filter Materi')
                    ->options(Material::pluck('title', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinalTests::route('/'),
            'create' => Pages\CreateFinalTest::route('/create'),
            'edit' => Pages\EditFinalTest::route('/{record}/edit'),
        ];
    }
}