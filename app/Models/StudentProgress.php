<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    /** @use HasFactory<\Database\Factories\StudentProgressFactory> */
    use HasFactory;

     protected $fillable = [
        'user_id', 'sub_topic_id', 'game_code_id','material_id' ,'level', 'completed_at', 'is_completed', 'active_section', 'completed_section', 'progress_percent',
        
            
    ];

     protected $casts = [
        'completed_at' => 'datetime',
        'is_completed' => 'boolean',
          'completed_section' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subtopic()
    {
        return $this->belongsTo(SubTopic::class ,'sub_topic_id');
    }

    public function gameCode()
    {
        return $this->belongsTo(GameCode::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}