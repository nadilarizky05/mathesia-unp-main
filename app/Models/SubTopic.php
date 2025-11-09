<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTopic extends Model
{
    /** @use HasFactory<\Database\Factories\SubTopicFactory> */
    use HasFactory;

    protected $fillable = ['topic_id', 'title', 'description', 'thumbnail_url'];

     public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'sub_topic_id');
    }

    public function gameCodes()
    {
        return $this->hasMany(GameCode::class);
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class);
    }
}