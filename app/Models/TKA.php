<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TKA extends Model
{
    /** @use HasFactory<\Database\Factories\TKAFactory> */
    use HasFactory;

     protected $fillable = ['title','description','questions'];
    protected $casts = [
        'questions' => 'array',
    ];

    public function studentAnswers() {
        return $this->hasMany(TKAAnswer::class);
    }
}