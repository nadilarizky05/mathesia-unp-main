<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'material_section_id',
        'field_name',
        'answer_text',
        'answer_file',
        'score',
        'feedback',
        'graded_at',
        'graded_by',
    ];

    protected $casts = [
        'graded_at' => 'datetime',
    ];

    public function section()
    {
        return $this->belongsTo(MaterialSection::class, 'material_section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gradedBy()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}