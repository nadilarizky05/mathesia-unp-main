<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentFinalTestResource\Pages;
use App\Models\StudentFinalTest;
use App\Models\StudentFinalTestAnswer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\RepeatableEntry;

class StudentFinalTestResource extends Resource
{
    protected static ?string $model = StudentFinalTest::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Tes Akhir';
    protected static ?int $navigationSort = 7;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $pluralModelLabel = 'Hasil Tes Akhirr';
    protected static ?string $modelLabel = 'Hasil Tes Akhirr';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Tes')
                    ->schema([
                        Placeholder::make('student_name')
                            ->label('Nama Siswa')
                            ->content(fn ($record) => $record->user->name ?? '-'),

                        Placeholder::make('material_title')
                            ->label('Materi')
                            ->content(fn ($record) => $record->material->title ?? '-'),

                        Placeholder::make('started_at')
                            ->label('Waktu Mulai')
                            ->content(fn ($record) => $record->started_at ? $record->started_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : '-'),

                        Placeholder::make('finished_at')
                            ->label('Waktu Selesai')
                            ->content(fn ($record) => $record->finished_at ? $record->finished_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : 'Belum selesai'),

                        Placeholder::make('duration')
                            ->label('Durasi Pengerjaan')
                            ->content(function ($record) {
                                if (!$record->started_at || !$record->finished_at) return '-';
                                $diff = $record->started_at->diff($record->finished_at);
                                return sprintf('%d menit %d detik', $diff->i, $diff->s);
                            }),

                        Placeholder::make('is_submitted')
                            ->label('Status')
                            ->content(fn ($record) => $record->is_submitted 
                                ? '✅ Sudah Dikumpulkan' 
                                : '⏳ Belum Dikumpulkan'),
                    ])
                    ->columns(2),

                Section::make('Jawaban & Penilaian')
                    ->schema([
                        Forms\Components\Repeater::make('answers')
                            ->label('Daftar Jawaban')
                            ->relationship('answers')
                            ->schema([
                                Forms\Components\Placeholder::make('question_preview')
                                    ->label('Pertanyaan')
                                    ->content(fn ($record) => strip_tags($record->finalTest->question ?? '-')),

                                Forms\Components\Textarea::make('answer_text')
                                    ->label('Jawaban Teks')
                                    ->rows(4)
                                    ->disabled()
                                    ->columnSpanFull(),

                                Forms\Components\Placeholder::make('answer_file_preview')
                                    ->label('File Jawaban')
                                    ->content(function ($record) {
                                        if (!$record->answer_file) return '-';
                                        return view('filament.components.file-preview', [
                                            'path' => $record->answer_file
                                        ]);
                                    })
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('score')
                                    ->label('Nilai')
                                    ->numeric()
                                    ->suffix('/ ' . ($record->finalTest->max_score ?? 100))
                                    ->maxValue(fn ($record) => $record->finalTest->max_score ?? 100),
                            ])
                            ->defaultItems(0)
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->collapsed()
                            ->itemLabel(fn ($state, $record) => 
                                'Soal #' . ($record->finalTest->id ?? '?') . 
                                ($record->score ? " - Nilai: {$record->score}" : ' - Belum dinilai')
                            )
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('total_score')
                            ->label('Total Nilai')
                            ->content(function ($record) {
                                $total = $record->answers->sum('score');
                                $max = $record->answers->sum(fn($a) => $a->finalTest->max_score ?? 0);
                                return "{$total} / {$max}";
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.title')
                    ->label('Materi')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('started_at')
                    ->label('Mulai')
                    ->dateTime('d M Y, H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),

                TextColumn::make('finished_at')
                    ->label('Selesai')
                    ->dateTime('d M Y, H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable()
                    ->placeholder('Belum selesai'),

                TextColumn::make('duration')
                    ->label('Durasi')
                    ->getStateUsing(function ($record) {
                        if (!$record->started_at || !$record->finished_at) return '-';
                        $diff = $record->started_at->diff($record->finished_at);
                        return sprintf('%dm %ds', $diff->i, $diff->s);
                    }),

                TextColumn::make('total_score')
                    ->label('Nilai')
                    ->getStateUsing(function ($record) {
                        $total = $record->answers->sum('score');
                        $max = $record->answers->sum(fn($a) => $a->finalTest->max_score ?? 0);
                        return $total > 0 ? "{$total}/{$max}" : 'Belum dinilai';
                    })
                    ->badge()
                    ->color(fn ($state) => str_contains($state, 'Belum') ? 'gray' : 'success'),

                TextColumn::make('is_submitted')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Dikumpulkan' : 'Belum')
                    ->color(fn ($state) => $state ? 'success' : 'warning'),
            ])
            ->defaultSort('started_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('is_submitted')
                    ->label('Status')
                    ->options([
                        '1' => 'Sudah Dikumpulkan',
                        '0' => 'Belum Dikumpulkan',
                    ]),

                Tables\Filters\SelectFilter::make('material_id')
                    ->label('Materi')
                    ->relationship('material', 'title'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->label('Nilai'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoSection::make('Informasi Tes')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Nama Siswa'),
                        
                        TextEntry::make('material.title')
                            ->label('Materi'),

                        TextEntry::make('started_at')
                            ->label('Waktu Mulai')
                            ->dateTime('d M Y, H:i')
                            ->timezone('Asia/Jakarta'),

                        TextEntry::make('finished_at')
                            ->label('Waktu Selesai')
                            ->dateTime('d M Y, H:i')
                            ->timezone('Asia/Jakarta')
                            ->placeholder('Belum selesai'),

                        TextEntry::make('is_submitted')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Dikumpulkan' : 'Belum')
                            ->color(fn ($state) => $state ? 'success' : 'warning'),
                    ])
                    ->columns(2),

                InfoSection::make('Jawaban')
                    ->schema([
                        RepeatableEntry::make('answers')
                            ->label('')
                            ->schema([
                                TextEntry::make('finalTest.question')
                                    ->label('Pertanyaan')
                                    ->html(),

                                TextEntry::make('answer_text')
                                    ->label('Jawaban')
                                    ->placeholder('Tidak ada jawaban teks'),

                                TextEntry::make('answer_file')
                                    ->label('File')
                                    ->formatStateUsing(fn ($state) => $state 
                                        ? "<a href='/storage/{$state}' target='_blank' class='text-blue-600 underline'>Lihat File</a>" 
                                        : 'Tidak ada file')
                                    ->html(),

                                TextEntry::make('score')
                                    ->label('Nilai')
                                    ->badge()
                                    ->color('success')
                                    ->placeholder('Belum dinilai'),
                            ])
                            ->columns(1),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentFinalTests::route('/'),
            // 'view' => Pages\ViewStudentFinalTest::route('/{record}'),
            'edit' => Pages\EditStudentFinalTest::route('/{record}/edit'),
        ];
    }
}