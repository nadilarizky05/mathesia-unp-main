<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TKAAnswer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        't_k_a_id', 
        'user_id', 
        'answers', 
        'score', 
        'correct_count',
        'wrong_count',
        'total_questions',
        'submitted_at'
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
        'score' => 'decimal:2',
        'correct_count' => 'integer',
        'wrong_count' => 'integer',
        'total_questions' => 'integer',
    ];

    public function test()
    {
        return $this->belongsTo(TKA::class, 't_k_a_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}