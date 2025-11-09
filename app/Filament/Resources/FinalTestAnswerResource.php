<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinalTestAnswerResource\Pages;
use App\Models\FinalTestAnswer;
use App\Models\FinalTest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\HtmlString;

class FinalTestAnswerResource extends Resource
{
    protected static ?string $model = FinalTestAnswer::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Tes Akhir';
    protected static ?string $pluralModelLabel = 'Hasil Tes Akhir';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tes')
                    ->schema([
                        Forms\Components\Placeholder::make('user_name')
                            ->label('Siswa')
                            ->content(fn ($record) => new HtmlString('<strong>' . ($record->user->name ?? '-') . '</strong>')),

                        Forms\Components\Placeholder::make('material_title')
                            ->label('Materi')
                            ->content(fn ($record) => new HtmlString('<strong>' . ($record->material->title ?? '-') . '</strong>')),

                        Forms\Components\Placeholder::make('started_at')
                            ->label('Mulai')
                            ->content(fn ($record) => $record->started_at?->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' ?? '-'),

                        Forms\Components\Placeholder::make('finished_at')
                            ->label('Selesai')
                            ->content(fn ($record) => $record->finished_at 
                                ? $record->finished_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
                                : 'Belum selesai'),

                        Forms\Components\Placeholder::make('duration')
                            ->label('Durasi Pengerjaan')
                            ->content(function ($record) {
                                if (!$record->started_at || !$record->finished_at) return '-';
                                $diff = $record->started_at->diff($record->finished_at);
                                return sprintf('%d menit %d detik', $diff->i, $diff->s);
                            }),

                        Forms\Components\Placeholder::make('status')
                            ->label('Status')
                            ->content(fn ($record) => new HtmlString(
                                $record->is_submitted 
                                    ? '<span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-green-100 text-green-700 text-sm font-medium">✅ Sudah Dikumpulkan</span>' 
                                    : '<span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-yellow-100 text-yellow-700 text-sm font-medium">⏳ Belum Dikumpulkan</span>'
                            )),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Penilaian')
                    ->description('Nilai setiap jawaban siswa dan berikan feedback')
                    ->schema([
                        Forms\Components\Repeater::make('answers')
                            ->label('Daftar Jawaban')
                            ->schema([
                                // ✅ Tampilkan Soal
                                Forms\Components\Placeholder::make('question_display')
                                    ->label('Pertanyaan')
                                    ->content(function ($state, Forms\Get $get) {
                                        $record = $get('../../');
                                        
                                        if (!$record instanceof FinalTestAnswer) {
                                            return '-';
                                        }

                                        $questionIndex = $state['question_index'] ?? 0;
                                        
                                        // Ambil soal dari FinalTest
                                        $finalTest = FinalTest::where('material_id', $record->material_id)->first();
                                        
                                        if (!$finalTest || empty($finalTest->questions)) {
                                            return '-';
                                        }

                                        $questions = $finalTest->questions;
                                        $question = $questions[$questionIndex] ?? null;
                                        
                                        if (!$question) {
                                            return '-';
                                        }

                                        $questionText = strip_tags($question['question'] ?? '-');
                                        $maxScore = $question['max_score'] ?? 10;
                                        
                                        return new HtmlString("
                                            <div class='rounded-lg bg-blue-50 p-3 border border-blue-200'>
                                                <div class='text-sm font-semibold text-blue-900 mb-2'>
                                                    Soal #" . ($questionIndex + 1) . " (Bobot: {$maxScore} poin)
                                                </div>
                                                <div class='text-sm text-gray-700'>
                                                    " . nl2br(e(substr($questionText, 0, 200))) . (strlen($questionText) > 200 ? '...' : '') . "
                                                </div>
                                            </div>
                                        ");
                                    })
                                    ->columnSpanFull(),

                                // ✅ File Jawaban dengan Preview
                                ViewField::make('answer_file')
                                    ->label('File Jawaban')
                                    ->view('filament.forms.components.file-preview')
                                    ->columnSpanFull(),

                                // ✅ Input Nilai
                                Forms\Components\TextInput::make('score')
                                    ->label('Nilai')
                                    ->numeric()
                                    ->minValue(0)
                                    ->placeholder('Masukkan nilai')
                                    ->suffix(function ($state, Forms\Get $get) {
                                        $record = $get('../../');
                                        
                                        if (!$record instanceof FinalTestAnswer) {
                                            return '/ 10';
                                        }

                                        $questionIndex = $state['question_index'] ?? 0;
                                        $finalTest = FinalTest::where('material_id', $record->material_id)->first();
                                        $questions = $finalTest?->questions ?? [];
                                        $maxScore = $questions[$questionIndex]['max_score'] ?? 10;
                                        
                                        return "/ {$maxScore}";
                                    })
                                    ->reactive()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                'Soal #' . (($state['question_index'] ?? 0) + 1) . 
                                (isset($state['score']) && $state['score'] !== null ? " - Nilai: {$state['score']}" : ' - Belum dinilai')
                            )
                            ->columnSpanFull(),

                        // ✅ Total Nilai (Auto-calculate)
                        Forms\Components\Placeholder::make('total_score_display')
                            ->label('Total Nilai')
                            ->content(function ($record) {
                                if (!$record) return '-';
                                
                                $answers = $record->answers ?? [];
                                $totalScore = collect($answers)->sum('score');
                                
                                $finalTest = FinalTest::where('material_id', $record->material_id)->first();
                                $maxTotalScore = collect($finalTest?->questions ?? [])->sum('max_score');
                                
                                return new HtmlString("
                                    <div class='text-lg font-bold text-green-600'>
                                        {$totalScore} / {$maxTotalScore}
                                    </div>
                                ");
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('material.title')
                    ->label('Materi')
                    ->searchable()
                    ->wrap()
                    ->limit(40),

                Tables\Columns\TextColumn::make('started_at')
                    ->label('Mulai')
                    ->dateTime('d M Y, H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),

                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Selesai')
                    ->dateTime('d M Y, H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable()
                    ->placeholder('Belum selesai'),

                Tables\Columns\TextColumn::make('total_score')
                    ->label('Nilai')
                    ->getStateUsing(function ($record) {
                        $total = collect($record->answers ?? [])->sum('score');
                        
                        if ($total === 0 && collect($record->answers ?? [])->every(fn($a) => !isset($a['score']) || $a['score'] === null)) {
                            return 'Belum dinilai';
                        }
                        
                        $finalTest = FinalTest::where('material_id', $record->material_id)->first();
                        $max = collect($finalTest?->questions ?? [])->sum('max_score');
                        
                        return "{$total}/{$max}";
                    })
                    ->badge()
                    ->color(fn ($state) => str_contains($state, 'Belum') ? 'gray' : 'success'),

                Tables\Columns\IconColumn::make('is_submitted')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
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
                    ->relationship('material', 'title')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Beri Nilai')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinalTestAnswers::route('/'),
            'edit' => Pages\EditFinalTestAnswer::route('/{record}/edit'),
        ];
    }
}