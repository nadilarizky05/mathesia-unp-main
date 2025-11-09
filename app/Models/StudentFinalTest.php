<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFinalTest extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFinalTestFactory> */
    use HasFactory;

   protected $fillable = [
        'user_id',
        'material_id',
        'started_at',
        'expires_at',
        'finished_at',
        'is_submitted',
        'total_score'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'finished_at' => 'datetime',
        'is_submitted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentFinalTestAnswer::class, 'student_final_test_id');
    }
}