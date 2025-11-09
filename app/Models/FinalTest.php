<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalTest extends Model
{
    protected $fillable = [
        'material_id',
        'questions',
        'duration_minutes',
    ];

    protected $casts = [
        'questions' => 'array',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // ✅ Relasi ke jawaban siswa
    public function studentAnswers()
    {
        return $this->hasManyThrough(
            FinalTestAnswer::class,
            Material::class,
            'id',
            'material_id',
            'material_id',
            'id'
        );
    }
}