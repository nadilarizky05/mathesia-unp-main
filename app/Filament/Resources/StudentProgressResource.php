<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentProgressResource\Pages;
use App\Filament\Resources\StudentProgressResource\RelationManagers;
use App\Models\StudentProgress;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class StudentProgressResource extends Resource
{
    protected static ?string $model = StudentProgress::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Progress Siswa';
    protected static ?int $navigationSort = 5;
    protected static ?string $pluralModelLabel = 'Kumpulan Progress Siswa';
    
    // ✅ TAMBAHKAN: Filter data berdasarkan role user
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        // Jika teacher, filter hanya siswa dari sekolah yang sama
        if ($user->role === 'teacher') {
            $query->whereHas('user', function (Builder $q) use ($user) {
                $q->where('school', $user->school);
            });
        }

        // Admin bisa lihat semua data (tidak perlu filter)
        return $query;
    }
    
    public static function form(Form $form): Form
    {
        return $form    
            ->schema([
                Section::make()->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name', function (Builder $query) {
                            // ✅ Filter siswa di form sesuai role
                            $user = Auth::user();
                            if ($user->role === 'teacher') {
                                $query->where('school', $user->school)
                                      ->where('role', 'student');
                            } else {
                                $query->where('role', 'student');
                            }
                        })
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.class')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtopic.title')
                    ->label('Subtopik')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('level')
                    ->colors([
                        'success' => 'inferior',
                        'warning' => 'reguler',
                        'danger' => 'superior',
                    ]),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_completed')
                    ->label('Selesai')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('school')
                    ->label('Sekolah')
                    ->options(function () {
                        $user = Auth::user();
                        $query = User::whereNotNull('school')
                            ->where('school', '!=', '');
                        
                        // ✅ Filter sekolah untuk teacher
                        if ($user->role === 'teacher') {
                            $query->where('school', $user->school);
                        }
                        
                        return $query->distinct()
                            ->orderBy('school')
                            ->pluck('school', 'school')
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['values'])) {
                            return $query->whereHas('user', function (Builder $q) use ($data) {
                                $q->whereIn('school', $data['values']);
                            });
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload()
                    ->multiple(),
                
                Tables\Filters\SelectFilter::make('class')
                    ->label('Kelas')
                    ->options(function () {
                        $user = Auth::user();
                        $query = User::whereNotNull('class')
                            ->where('class', '!=', '');
                        
                        // ✅ Filter kelas dari sekolah teacher
                        if ($user->role === 'teacher') {
                            $query->where('school', $user->school);
                        }
                        
                        return $query->distinct()
                            ->orderBy('class')
                            ->pluck('class', 'class')
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['values'])) {
                            return $query->whereHas('user', function (Builder $q) use ($data) {
                                $q->whereIn('class', $data['values']);
                            });
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload()
                    ->multiple(),
                
                Tables\Filters\SelectFilter::make('level')
                    ->label('Level')
                    ->options([
                        'inferior' => 'Inferior',
                        'reguler' => 'Reguler',
                        'superior' => 'Superior',
                    ])
                    ->multiple(),
                
                Tables\Filters\TernaryFilter::make('is_completed')
                    ->label('Status Selesai')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah Selesai')
                    ->falseLabel('Belum Selesai'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('download_excel')
                    ->label('Download Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn () => route('student-progress.export'))
                    ->openUrlInNewTab(false),
            ])
            ->defaultSort('completed_at', 'desc');
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
            'edit' => Pages\EditStudentProgress::route('/{record}/edit'),
        ];
    }
    
    // Disable create button
    public static function canCreate(): bool
    {
        // Hanya admin yang bisa create (tambah jawaban baru)
        return Auth::user()->role === 'admin';
    }
}