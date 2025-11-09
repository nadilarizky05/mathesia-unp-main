<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentFinalTest;

class StudentFinalTestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_final_test_id',
        'final_test_id',
        'question_index', 
        'answer_text',
        'answer_file',
        'score',
        'feedback', 
    ];

    protected static function booted()
    {
        static::creating(function ($answer) {
            if (empty($answer->student_final_test_id) && $answer->final_test_id) {
                $user = Auth::user();

                if ($user) {
                    $finalTest = \App\Models\FinalTest::find($answer->final_test_id);

                    if ($finalTest) {
                        $attempt = StudentFinalTest::firstOrCreate([
                            'user_id' => $user->id,
                            'material_id' => $finalTest->material_id,
                        ], [
                            'started_at' => now(),
                        ]);

                        $answer->student_final_test_id = $attempt->id;
                    }
                }
            }
        });
    }

    public function attempt()
    {
        return $this->belongsTo(StudentFinalTest::class, 'student_final_test_id');
    }

    public function finalTest()
    {
        return $this->belongsTo(FinalTest::class, 'final_test_id');
    }
}