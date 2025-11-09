<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSection extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialSectionsFactory> */
    use HasFactory;

     protected $fillable = [
        'material_id',
        'order',
        'title',
        'wacana',
        'masalah',
        'berpikir_soal_1',
        'berpikir_soal_2',
        'rencanakan',
        'selesaikan',
        'periksa',
        'kerjakan_1',
        'kerjakan_2',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class, 'material_section_id');
    }
}