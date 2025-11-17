<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationLabel(): string
    {
        return Auth::user()?->role === 'admin' ? 'Users' : 'Daftar Siswa';
    }

    public static function getPluralLabel(): ?string
    {
        return Auth::user()?->role === 'admin' ? 'Users' : 'Daftar Siswa';
    }

    // ✅ TAMBAHKAN: Filter data berdasarkan role user yang login
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        // Jika teacher, hanya tampilkan student dari sekolah yang sama
        if ($user->role === 'teacher') {
            $query->where('school', $user->school)
                  ->where('role', 'student');
        }

        // Admin bisa lihat semua user
        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Information')->schema([
                    Forms\Components\TextInput::make('nis')
                        ->label('NIS/NIP')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->label('Email')
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->label('Password')
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->revealable(),

                    Forms\Components\Select::make('role')
                        ->options([
                            'student' => 'Student',
                            'teacher' => 'Teacher',
                            'admin' => 'Admin',
                        ])
                        ->label('Role')
                        ->required()
                        ->live()
                        ->default('student')
                        // ✅ Teacher tidak bisa ubah role
                        ->disabled(fn () => Auth::user()->role === 'teacher'),

                    Forms\Components\TextInput::make('school')
                            ->label('Sekolah')
                            ->placeholder('Contoh: SMPN 1 Padang')
                            ->required(fn (Get $get): bool => $get('role') === 'student')
                            ->maxLength(255)
                            ->nullable()
                            // ✅ Teacher tidak bisa ubah sekolah (otomatis sama dengan sekolahnya)
                            ->disabled(fn () => Auth::user()->role === 'teacher')
                            ->default(fn () => Auth::user()->role === 'teacher' ? Auth::user()->school : null),
                ])->columns(2),

                Section::make('Student Information')
                    ->schema([
                        Forms\Components\TextInput::make('class')
                            ->label('Kelas')
                            ->placeholder('Contoh: 7A, 8B, 9C')
                            ->required(fn (Get $get): bool => $get('role') === 'student')
                            ->maxLength(50)
                            ->nullable(),

                        
                    ])
                    ->columns(2)
                    ->visible(fn (Get $get): bool => $get('role') === 'student')
                    ->description('Informasi khusus untuk siswa'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'teacher' => 'warning',
                        'student' => 'success',
                    })
                    ->sortable()
                    // ✅ Sembunyikan kolom role untuk teacher (karena pasti student semua)
                    ->visible(fn () => Auth::user()->role !== 'teacher'),
                Tables\Columns\TextColumn::make('class')
                    ->label('Kelas')
                    ->sortable()
                    ->default('-')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('school')
                    ->label('Sekolah')
                    ->sortable()
                    ->limit(30)
                    ->toggleable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'student' => 'Student',
                        'teacher' => 'Teacher',
                        'admin' => 'Admin',
                    ])
                    // ✅ Sembunyikan filter role untuk teacher
                    ->visible(fn () => Auth::user()->role !== 'teacher'),
                
                // ✅ Filter kelas untuk teacher
                Tables\Filters\SelectFilter::make('class')
                    ->label('Kelas')
                    ->options(function () {
                        $user = Auth::user();
                        $query = User::whereNotNull('class')
                            ->where('class', '!=', '');
                        
                        if ($user->role === 'teacher') {
                            $query->where('school', $user->school)
                                  ->where('role', 'student');
                        }
                        
                        return $query->distinct()
                            ->orderBy('class')
                            ->pluck('class', 'class')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->visible(fn () => Auth::user()->role !== 'teacher'),
                    Tables\Actions\EditAction::make()
                        ->visible(fn () => Auth::user()->role !== 'teacher'),
                    Tables\Actions\DeleteAction::make()
                        // ✅ Teacher tidak bisa hapus user
                        ->visible(fn () => Auth::user()->role !== 'teacher'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        // ✅ Teacher tidak bisa bulk delete
                        ->visible(fn () => Auth::user()->role !== 'teacher'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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

    // ✅ TAMBAHKAN: Sembunyikan tombol "New User" untuk teacher
    public static function canCreate(): bool
    {
        return Auth::user()->role !== 'teacher';
    }

    // ✅ TAMBAHKAN: Teacher tidak bisa delete user
    public static function canDelete($record): bool
    {
        return Auth::user()->role !== 'teacher';
    }

    // ✅ TAMBAHKAN: Teacher hanya bisa edit student dari sekolahnya
    public static function canEdit($record): bool
    {
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            return $record->school === $user->school && $record->role === 'student';
        }
        
        return true;
    }

    // ✅ TAMBAHKAN: Teacher hanya bisa view student dari sekolahnya
    public static function canView($record): bool
    {
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            return $record->school === $user->school && $record->role === 'student';
        }
        
        return true;
    }
}