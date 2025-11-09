<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentProgressResource\Pages;
use App\Filament\Resources\StudentProgressResource\RelationManagers;
use App\Models\StudentProgress;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentProgressResource extends Resource
{
    protected static ?string $model = StudentProgress::class;

     protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Progress Siswa';
    protected static ?int $navigationSort = 5;
    protected static ?string $pluralModelLabel = 'Kumpulan Progress Siswa';
    public static function form(Form $form): Form
    {
        return $form    
            ->schema([
                Section::make()->schema([
                Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('Siswa')
                ->searchable(),
            Forms\Components\Select::make('subtopic_id')
                ->relationship('subtopic', 'title')
                ->label('Subtopik'),
            Forms\Components\Select::make('game_code_id')
                ->relationship('gameCode', 'code')
                ->label('Kode Game'),
            Forms\Components\Select::make('level')
                ->options([
                    'inferior' => 'Inferior',
                    'reguler' => 'Reguler',
                    'superior' => 'Superior',
                ])
                ->required(),
            Toggle::make('is_completed')
                ->label('Selesai'),
            Forms\Components\DateTimePicker::make('completed_at')
                ->label('Tanggal Selesai'),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('subtopic.title')->label('Subtopik'),
                Tables\Columns\TextColumn::make('gameCode.code')->label('Kode Game'),
                Tables\Columns\BadgeColumn::make('level')
                    ->colors([
                        'success' => 'inferior',
                        'warning' => 'reguler',
                        'danger' => 'superior',
                    ]),
                Tables\Columns\TextColumn::make('completed_at')->label('Tanggal Selesai')->dateTime(),
                Tables\Columns\BooleanColumn::make('is_completed')->label('Selesai'),
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
            'index' => Pages\ListStudentProgress::route('/'),
            'create' => Pages\CreateStudentProgress::route('/create'),
            'edit' => Pages\EditStudentProgress::route('/{record}/edit'),
        ];
    }
}