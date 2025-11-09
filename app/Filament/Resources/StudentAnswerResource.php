<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentAnswerResource\Pages;
use App\Models\StudentAnswer;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StudentAnswerResource extends Resource
{
    protected static ?string $model = StudentAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square-stack';

    protected static ?string $navigationGroup = 'Progress Siswa';
    
    protected static ?int $navigationSort = 4;
    protected static ?string $pluralModelLabel = 'Kumpulan Jawaban Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Jawaban')->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Siswa')
                        ->disabled(),
                    
                    Select::make('material_section_id')
                        ->relationship('section', 'title')
                        ->label('Section Materi')
                        ->disabled(),
                    
                    TextInput::make('field_name')
                        ->label('Field Name')
                        ->required()
                        ->disabled(),
                    
                    FileUpload::make('answer_file')
                        ->label('File Jawaban (Gambar)')
                        ->disk('public')
                        ->directory('student_answers')
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('400')
                        ->downloadable()
                        ->openable()
                        ->disabled()
                        ->columnSpanFull(),
                ])
                ->columns(2),

                Section::make('Penilaian')
                    ->schema([
                        TextInput::make('score')
                            ->label('Nilai')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('/ 100')
                            ->required()
                            ->columnSpanFull(),
                        
                        Textarea::make('feedback')
                            ->label('Feedback untuk Siswa')
                            ->rows(5)
                            ->placeholder('Berikan feedback konstruktif untuk siswa...')
                            ->columnSpanFull(),
                        
                        Select::make('graded_by')
                            ->label('Dinilai oleh')
                            ->relationship('gradedBy', 'name')
                            ->default(Auth::id())
                            ->disabled()
                            ->dehydrated()
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->visible(fn ($livewire) => $livewire instanceof Pages\EditStudentAnswer)
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
                
                Tables\Columns\TextColumn::make('section.title')
                    ->label('Section Materi')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('field_name')
                    ->label('Field Nama')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        $state === null => 'gray',
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => $state !== null ? $state . '/100' : 'Belum dinilai')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Submit')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('graded_at')
                    ->label('Tanggal Dinilai')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Filter Siswa')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\SelectFilter::make('section')
                    ->relationship('section', 'title')
                    ->label('Filter Section')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\Filter::make('graded')
                    ->label('Sudah Dinilai')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('score')),
                
                Tables\Filters\Filter::make('ungraded')
                    ->label('Belum Dinilai')
                    ->query(fn (Builder $query): Builder => $query->whereNull('score')),
            ])
            ->actions([
                Tables\Actions\Action::make('grade')
                    ->label('Beri Nilai')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->button()
                    ->modalHeading('Beri Nilai - Preview File Jawaban')
                    ->modalContent(fn (StudentAnswer $record) => view('filament.modals.grade-answer', [
                        'record' => $record,
                        'imageUrl' => $record->answer_file ? asset('storage/' . $record->answer_file) : null,
                        'studentName' => $record->user->name ?? 'Unknown',
                        'sectionTitle' => $record->section->title ?? 'Unknown',
                        'fieldName' => $record->field_name,
                        'questionText' => self::getQuestionText($record),
                        'questionImageUrl' => self::getQuestionImageUrl($record),
                    ]))
                    ->modalWidth('5xl')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('score')
                                    ->label('Nilai')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->suffix('/ 100')
                                    ->required()
                                    ->default(fn ($record) => $record->score),
                                
                                TextInput::make('graded_by')
                                    ->label('Dinilai oleh')
                                    ->default(Auth::user()->name)
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),
                        
                        Textarea::make('feedback')
                            ->label('Feedback untuk Siswa')
                            ->rows(4)
                            ->placeholder('Berikan feedback konstruktif untuk siswa...')
                            ->default(fn ($record) => $record->feedback)
                            ->columnSpanFull(),
                    ])
                    ->action(function (StudentAnswer $record, array $data): void {
                        $record->update([
                            'score' => $data['score'],
                            'feedback' => $data['feedback'] ?? null,
                            'graded_by' => Auth::id(),
                            'graded_at' => now(),
                        ]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Berhasil Memberi Nilai')
                            ->success()
                            ->send();
                    })
                    ->modalSubmitActionLabel('Simpan Nilai')
                    ->modalCancelActionLabel('Batal'),
                
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->modalWidth('5xl'),
                    
                    Tables\Actions\Action::make('download')
                        ->label('Download File')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->visible(fn (StudentAnswer $record) => $record->answer_file !== null)
                        ->url(fn (StudentAnswer $record) => asset('storage/' . $record->answer_file))
                        ->openUrlInNewTab(),
                    
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Ambil teks pertanyaan dari section berdasarkan field_name
     */
    protected static function getQuestionText(StudentAnswer $record): ?string
    {
        try {
            if (!$record->section) {
                return 'Section tidak ditemukan';
            }

            $section = $record->section;
            $fieldName = $record->field_name;

            // Mapping field_name ke kolom di material_sections
            $fieldMapping = [
                'masalah' => 'masalah',
                'berpikir_soal_1' => 'berpikir_soal_1',
                'berpikir_soal_2' => 'berpikir_soal_2',
                'rencanakan' => 'rencanakan',
                'selesaikan' => 'selesaikan',
                'periksa' => 'periksa',
                'kerjakan_1' => 'kerjakan_1',
                'kerjakan_2' => 'kerjakan_2',
            ];

            // Cek apakah field_name ada di mapping
            if (!isset($fieldMapping[$fieldName])) {
                return 'Tipe soal "' . $fieldName . '" tidak dikenali';
            }

            $columnName = $fieldMapping[$fieldName];
            $questionValue = $section->{$columnName};

            if (!$questionValue) {
                return 'Pertanyaan untuk field "' . $fieldName . '" kosong';
            }

            // Cek apakah ini adalah path gambar simple
            if (self::isSimpleImagePath($questionValue)) {
                return null; // Jika gambar simple, return null untuk text
            }

            // Jika ada HTML, bersihkan image tags tapi keep text
            if (self::containsHtml($questionValue)) {
                // Remove figure/img tags dari Trix editor
                $cleanText = preg_replace('/<figure[^>]*>.*?<\/figure>/is', '', $questionValue);
                $cleanText = strip_tags($cleanText);
                $cleanText = trim($cleanText);
                
                return $cleanText ?: null;
            }

            // Bersihkan HTML tags jika ada
            $questionText = strip_tags($questionValue);
            return trim($questionText) ?: null;

        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Ambil URL gambar pertanyaan dari field_name
     */
    protected static function getQuestionImageUrl(StudentAnswer $record): ?string
    {
        try {
            if (!$record->section) {
                return null;
            }

            $section = $record->section;
            $fieldName = $record->field_name;

            // Mapping field_name ke kolom
            $fieldMapping = [
                'masalah' => 'masalah',
                'berpikir_soal_1' => 'berpikir_soal_1',
                'berpikir_soal_2' => 'berpikir_soal_2',
                'rencanakan' => 'rencanakan',
                'selesaikan' => 'selesaikan',
                'periksa' => 'periksa',
                'kerjakan_1' => 'kerjakan_1',
                'kerjakan_2' => 'kerjakan_2',
            ];

            if (!isset($fieldMapping[$fieldName])) {
                return null;
            }

            $columnName = $fieldMapping[$fieldName];
            $questionValue = $section->{$columnName};

            if (!$questionValue) {
                return null;
            }

            // 1. Cek apakah ini HTML dari Trix Editor (ada data-trix-attachment)
            if (str_contains($questionValue, 'data-trix-attachment')) {
                return self::extractTrixImageUrl($questionValue);
            }

            // 2. Cek apakah ini adalah path gambar simple
            if (self::isSimpleImagePath($questionValue)) {
                return self::buildImageUrl($questionValue);
            }

            return null;

        } catch (\Exception $e) {
            \Log::error('Error getting question image URL: ' . $e->getMessage(), [
                'record_id' => $record->id,
                'field_name' => $record->field_name
            ]);
            return null;
        }
    }

    /**
     * Extract image URL from Trix editor HTML
     */
    protected static function extractTrixImageUrl(string $html): ?string
    {
        // Extract JSON dari data-trix-attachment attribute
        if (preg_match('/data-trix-attachment="([^"]+)"/', $html, $matches)) {
            $jsonString = html_entity_decode($matches[1]);
            $data = json_decode($jsonString, true);
            
            if (isset($data['url'])) {
                $url = $data['url'];
                
                // Convert localhost URL to relative path jika perlu
                if (str_contains($url, 'gm-lms-main.test') || str_contains($url, 'localhost')) {
                    // Extract path after /storage/
                    if (preg_match('/\/storage\/(.+)$/', $url, $pathMatches)) {
                        return asset('storage/' . $pathMatches[1]);
                    }
                }
                
                return $url;
            }
        }
        
        // Fallback: cari img src
        if (preg_match('/<img[^>]+src="([^"]+)"/', $html, $matches)) {
            $url = $matches[1];
            
            if (str_contains($url, 'gm-lms-main.test') || str_contains($url, 'localhost')) {
                if (preg_match('/\/storage\/(.+)$/', $url, $pathMatches)) {
                    return asset('storage/' . $pathMatches[1]);
                }
            }
            
            return $url;
        }
        
        return null;
    }

    /**
     * Build image URL from path
     */
    protected static function buildImageUrl(string $path): string
    {
        // Cek apakah sudah full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        
        // Jika sudah ada 'storage/' di awal
        if (str_starts_with($path, 'storage/') || str_starts_with($path, 'public/')) {
            return asset($path);
        }
        
        // Jika ada folder/subfolder
        if (str_contains($path, '/')) {
            return asset('storage/' . $path);
        }
        
        // Jika hanya nama file, coba beberapa path
        $possiblePaths = [
            'materials/sections/' . $path,
            'materials/' . $path,
            'sections/' . $path,
            $path,
        ];
        
        foreach ($possiblePaths as $testPath) {
            $fullPath = public_path('storage/' . $testPath);
            if (file_exists($fullPath)) {
                return asset('storage/' . $testPath);
            }
        }
        
        return asset('storage/' . $possiblePaths[0]);
    }

    /**
     * Cek apakah string adalah path gambar simple (bukan HTML)
     */
    protected static function isSimpleImagePath(string $value): bool
    {
        // Jika mengandung HTML tags, bukan simple path
        if (self::containsHtml($value)) {
            return false;
        }

        // Cek ekstensi file gambar
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
        $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
        
        if (in_array($extension, $imageExtensions)) {
            return true;
        }

        // Cek pattern ekstensi
        if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg|bmp)$/i', $value)) {
            return true;
        }

        // Jika text pendek dan ada path separator
        if (strlen($value) < 200 && (str_contains($value, '/') || str_contains($value, '\\'))) {
            return true;
        }

        return false;
    }

    /**
     * Cek apakah string mengandung HTML
     */
    protected static function containsHtml(string $value): bool
    {
        return preg_match('/<[^>]+>/', $value) === 1;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentAnswers::route('/'),
            'create' => Pages\CreateStudentAnswer::route('/create'),
            'edit' => Pages\EditStudentAnswer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // Hitung jawaban yang belum dinilai
        return static::getModel()::whereNull('score')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $ungraded = static::getModel()::whereNull('score')->count();
        return $ungraded > 0 ? 'warning' : 'success';
    }
}