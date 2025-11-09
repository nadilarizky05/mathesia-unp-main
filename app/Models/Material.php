<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $fillable = [
        'sub_topic_id',
        'title',
        'level',
        'content',
        'file_url',
        'video_url',
        'order',
        'game_code_id',
    ];

    public function subtopic()
    {
        return $this->belongsTo(SubTopic::class, 'sub_topic_id');
    }

    public function gameCode()
    {
        return $this->belongsTo(GameCode::class, 'game_code_id');
    }

//     public function sections()
// {
//     return $this->hasMany(MaterialSection::class, 'material_id', 'id')->orderBy('order');
// }

public function sections(): HasMany
    {
        return $this->hasMany(MaterialSection::class, 'material_id', 'id')
                    ->orderBy('order', 'asc');
    }
     public function finalTests()
    {
        return $this->hasMany(FinalTest::class);
    }

    public function studentFinalTests()
    {
        return $this->hasMany(StudentFinalTest::class);
    }
    
}