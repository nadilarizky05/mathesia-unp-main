<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalTestAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'material_id',
        'started_at',
        'expires_at',
        'finished_at',
        'is_submitted',
        'answers', // JSON array
        'total_score',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'finished_at' => 'datetime',
        'is_submitted' => 'boolean',
        'answers' => 'array', // Auto decode JSON
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function finalTest()
    {
        return $this->hasOneThrough(
            FinalTest::class,
            Material::class,
            'id',
            'material_id',
            'material_id',
            'id'
        );
    }

    // Helper: Get answer untuk soal tertentu
    public function getAnswerForQuestion(int $questionIndex)
    {
        $answers = $this->answers ?? [];
        return collect($answers)->firstWhere('question_index', $questionIndex);
    }

    // Helper: Update jawaban untuk 1 soal
    public function updateAnswer(int $questionIndex, ?string $answerText, ?string $answerFile)
    {
        $answers = $this->answers ?? [];
        
        $found = false;
        foreach ($answers as $key => $answer) {
            if ($answer['question_index'] === $questionIndex) {
                if ($answerText !== null) {
                    $answers[$key]['answer_text'] = $answerText;
                }
                if ($answerFile !== null) {
                    $answers[$key]['answer_file'] = $answerFile;
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            $answers[] = [
                'question_index' => $questionIndex,
                'answer_text' => $answerText,
                'answer_file' => $answerFile,
                'score' => null,
                'feedback' => null,
            ];
        }

        $this->answers = $answers;
        $this->save();
    }
}