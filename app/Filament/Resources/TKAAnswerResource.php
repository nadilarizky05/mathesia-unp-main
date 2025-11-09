<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TKAAnswerResource\Pages;
use App\Models\TKAAnswer;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class TKAAnswerResource extends Resource
{
    protected static ?string $model = TKAAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'TKA (Tes Kemampuan Akademik)';
    protected static ?int $navigationSort = 9;
    protected static ?string $label = 'Hasil TKA';
    protected static ?string $pluralLabel = 'Hasil TKA Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Jawaban Siswa')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->disabled()
                                ->label('Nama Siswa'),
                            Select::make('t_k_a_id')
                                ->relationship('test', 'title')
                                ->disabled()
                                ->label('Tes'),
                        ]),
                        
                        Grid::make(4)->schema([
                            TextInput::make('score')
                                ->disabled()
                                ->numeric()
                                ->suffix('%')
                                ->label('Skor'),
                            TextInput::make('correct_count')
                                ->disabled()
                                ->numeric()
                                ->label('Benar'),
                            TextInput::make('wrong_count')
                                ->disabled()
                                ->numeric()
                                ->label('Salah'),
                            TextInput::make('total_questions')
                                ->disabled()
                                ->numeric()
                                ->label('Total Soal'),
                        ]),
                        
                        TextInput::make('submitted_at')
                            ->disabled()
                            ->label('Waktu Submit')
                            ->formatStateUsing(function ($state) {
                                if (!$state) return '-';
                                try {
                                    $date = new \DateTime($state);
                                    $date->setTimezone(new \DateTimeZone('Asia/Jakarta'));
                                    return $date->format('d M Y, H:i');
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }),
                    ]),

                // Tambahkan section untuk detail jawaban
                Section::make('Detail Jawaban')
                    ->schema([
                        Placeholder::make('answers_detail')
                            ->label('')
                            ->content(function ($record) {
                                if (!$record) return '';

                                try {
                                    $answers = is_array($record->answers) ? $record->answers : json_decode($record->answers, true);
                                    
                                    if (!is_array($answers)) {
                                        return 'Format jawaban tidak valid';
                                    }

                                    if (!$record->test) {
                                        return 'Data tes tidak ditemukan';
                                    }

                                    $questions = $record->test->questions;
                                    if (is_string($questions)) {
                                        $questions = json_decode($questions, true);
                                    }

                                    if (!is_array($questions) || empty($questions)) {
                                        return 'Data soal tidak valid atau kosong';
                                    }

                                    $html = '<div style="display: flex; flex-direction: column; gap: 1rem;">';
                                    
                                    foreach ($questions as $index => $question) {
                                        if (!isset($question['id']) || !isset($question['text'])) {
                                            continue;
                                        }

                                        $questionId = $question['id'];
                                        $userAnswer = collect($answers)->firstWhere('question_id', $questionId);
                                        
                                        $options = $question['options'] ?? [];
                                        $correctOption = collect($options)->firstWhere('is_correct', true);
                                        $selectedOption = null;
                                        
                                        if ($userAnswer && isset($userAnswer['selected_option_id'])) {
                                            $selectedOption = collect($options)
                                                ->firstWhere('id', $userAnswer['selected_option_id']);
                                        }
                                        
                                        $isCorrect = $selectedOption && ($selectedOption['is_correct'] ?? false);
                                        
                                        // Gunakan inline styles untuk memastikan warna tampil
                                        if ($isCorrect) {
                                            $boxStyle = 'border: 3px solid #10b981; background-color: #d1fae5; padding: 1rem; border-radius: 0.5rem;';
                                            $badgeStyle = 'background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600; display: inline-block;';
                                            $badgeText = '✓ BENAR';
                                            $answerStyle = 'color: #047857; font-weight: 600; font-size: 1rem;';
                                        } else {
                                            $boxStyle = 'border: 3px solid #ef4444; background-color: #fee2e2; padding: 1rem; border-radius: 0.5rem;';
                                            $badgeStyle = 'background-color: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600; display: inline-block;';
                                            $badgeText = '✗ SALAH';
                                            $answerStyle = 'color: #dc2626; font-weight: 600; font-size: 1rem;';
                                        }
                                        
                                        $html .= '<div style="' . $boxStyle . '">';
                                        $html .= '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">';
                                        $html .= '<span style="font-weight: 700; font-size: 1.125rem; color: #374151;">Soal ' . ($index + 1) . '</span>';
                                        $html .= '<span style="' . $badgeStyle . '">' . $badgeText . '</span>';
                                        $html .= '</div>';
                                        
                                        $html .= '<p style="color: #1f2937; margin-bottom: 1rem; line-height: 1.5;">' . htmlspecialchars($question['text']) . '</p>';
                                        
                                        if ($selectedOption) {
                                            $html .= '<div style="margin-left: 1rem;">';
                                            $html .= '<div style="padding: 0.75rem; background-color: white; border-radius: 0.5rem; margin-bottom: 0.75rem;">';
                                            $html .= '<p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem; font-weight: 500;">Jawaban Siswa:</p>';
                                            $html .= '<p style="' . $answerStyle . '">' 
                                                . htmlspecialchars($selectedOption['text'] ?? '') . '</p>';
                                            $html .= '</div>';
                                            
                                            if (!$isCorrect && $correctOption) {
                                                $html .= '<div style="padding: 0.75rem; background-color: #d1fae5; border: 2px solid #10b981; border-radius: 0.5rem;">';
                                                $html .= '<p style="font-size: 0.875rem; color: #047857; margin-bottom: 0.25rem; font-weight: 500;">Jawaban Benar:</p>';
                                                $html .= '<p style="color: #047857; font-weight: 600; font-size: 1rem;">' 
                                                    . htmlspecialchars($correctOption['text'] ?? '') . '</p>';
                                                $html .= '</div>';
                                            }
                                            $html .= '</div>';
                                        } else {
                                            $html .= '<div style="margin-left: 1rem; padding: 0.75rem; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 0.5rem;">';
                                            $html .= '<p style="color: #dc2626; font-weight: 500;">❌ Tidak dijawab</p>';
                                            $html .= '</div>';
                                        }
                                        
                                        $html .= '</div>';
                                    }
                                    
                                    $html .= '</div>';
                                    return new \Illuminate\Support\HtmlString($html);

                                } catch (\Exception $e) {
                                    Log::error('Error rendering TKA answers', [
                                        'error' => $e->getMessage(),
                                        'record_id' => $record->id ?? 'unknown'
                                    ]);
                                    
                                    return 'Terjadi kesalahan: ' . $e->getMessage();
                                }
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
                    ->sortable()
                    ->icon('heroicon-o-user'),
                
                TextColumn::make('test.title')
                    ->label('Tes')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-document-text')
                    ->limit(30),
                
                TextColumn::make('score')
                    ->label('Skor')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state >= 80 ? 'success' : ($state >= 60 ? 'warning' : 'danger'))
                    ->formatStateUsing(fn ($state) => round($state, 2) . '%'),
                
                TextColumn::make('correct_count')
                    ->label('Benar')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                
                TextColumn::make('wrong_count')
                    ->label('Salah')
                    ->sortable()
                    ->badge()
                    ->color('danger'),
                
                TextColumn::make('total_questions')
                    ->label('Total')
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('submitted_at')
                    ->label('Tanggal Submit')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-o-clock')
                    ->timezone('Asia/Jakarta'),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Siswa')
                    ->searchable(),
                
                Tables\Filters\SelectFilter::make('t_k_a_id')
                    ->relationship('test', 'title')
                    ->label('Tes')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Lihat Detail'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTKAAnswers::route('/'),
            'edit' => Pages\EditTKAAnswer::route('/{record}/edit'),
        ];
    }
}