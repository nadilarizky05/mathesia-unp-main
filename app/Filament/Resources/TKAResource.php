<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TKAResource\Pages;
use App\Filament\Resources\TKAResource\RelationManagers;
use App\Models\TKA;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TKAResource extends Resource
{
    protected static ?string $model = TKA::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'TKA (Tes Kemampuan Akademik)';
    protected static ?int $navigationSort = 8;

     protected static ?string $label = 'Input Soal TKA';
    protected static ?string $pluralLabel = 'Input Soal TKA';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Informasi Tes')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Tes')
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('description')
                                    ->label('Deskripsi Tes'),
                            ])
                            ->collapsible(),

                        Section::make('Daftar Soal')
                            ->description('Tambahkan soal dan pilihan jawaban di bawah ini')
                            ->schema([
                                Repeater::make('questions')
                                    ->label('Soal')
                                    ->collapsed()
                                    ->orderable()
                                    ->schema([
                                        TextInput::make('id')
                                            ->default(fn() => (string) Str::uuid())
                                            ->hidden(),
                                        Textarea::make('text')
                                            ->label('Teks Soal')
                                            ->required()
                                            ->rows(2),
                                        Repeater::make('options')
                                            ->label('Pilihan Jawaban')
                                            ->schema([
                                                TextInput::make('id')
                                                    ->default(fn() => (string) Str::uuid())
                                                    ->hidden(),
                                                Grid::make(3)
                                                    ->schema([
                                                        TextInput::make('text')
                                                            ->label('Teks Opsi')
                                                            ->required()
                                                            ->columnSpan(2),
                                                        Toggle::make('is_correct')
                                                            ->label('Benar')
                                                            ->onColor('success')
                                                            ->offColor('danger')
                                                            ->inline(false),
                                                    ]),
                                            ])
                                            ->columns(1)
                                            ->minItems(2)
                                            ->createItemButtonLabel('Tambah Opsi Jawaban')
                                            ->collapsible()
                                            ->defaultItems(2),
                                    ])
                                    ->createItemButtonLabel('Tambah Soal Baru')
                                    ->columns(1),
                            ])
                            ->collapsible(),
                    ])->columnSpanFull()  ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Judul Tes')->searchable()->sortable(),
                TextColumn::make('questions')
                    ->label('Jumlah Soal')
                    ->getStateUsing(function ($record) {
                        // Ambil langsung dari record
                        $questions = $record->questions;
                        
                        // Hitung jumlah soal
                        return is_array($questions) ? count($questions) : 0;
                    })
                    ->sortable(false),
                TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTKAS::route('/'),
            'create' => Pages\CreateTKA::route('/create'),
            'edit' => Pages\EditTKA::route('/{record}/edit'),
        ];
    }
}