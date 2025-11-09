<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCode extends Model
{
    /** @use HasFactory<\Database\Factories\GameCodeFactory> */
    use HasFactory;

     protected $fillable = ['sub_topic_id', 'code', 'level', 'description', 'game_url'];

    public function subtopic()
    {
        return $this->belongsTo(SubTopic::class, 'sub_topic_id');
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class);
    }
      public function materials()
    {
        return $this->hasMany(Material::class, 'game_code_id');
    }
}