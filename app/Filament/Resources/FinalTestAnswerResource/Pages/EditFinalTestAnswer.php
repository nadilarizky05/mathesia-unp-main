<?php

namespace App\Filament\Resources\FinalTestAnswerResource\Pages;

use App\Filament\Resources\FinalTestAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditFinalTestAnswer extends EditRecord
{
    protected static string $resource = FinalTestAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Nilai berhasil disimpan!')
            ->body('Penilaian telah tersimpan dan siswa dapat melihat nilainya.');
    }

    // ✅ PENTING: Override mutateFormDataBeforeSave untuk update total_score
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Hitung total score dari semua jawaban
        $totalScore = collect($data['answers'] ?? [])->sum('score');
        
        // Update total_score
        $data['total_score'] = $totalScore;

        return $data;
    }
}