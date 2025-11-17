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


    public function sections(): HasMany
    {
        return $this->hasMany(MaterialSection::class, 'material_id', 'id')
            ->orderBy('order', 'asc');
    }

    public function templateSections()
    {
        $mapping = [
            1 => [
                'inferior' => [1, 12],
                'reguler' => [13, 24],
                'superior' => [25, 36],
            ],
            2 => [
                'inferior' => [37,46],
                'reguler' => [47,56],
                'superior' =>[57,66],
            ],
            3 => [
                'inferior' => [67,76],
                'reguler' => [77,86],
                'superior' =>[87,96],
            ],
            4 => [
                'inferior' => [97,108],
                'reguler' => [109,120],
                'superior' =>[121,132],
            ],
            5 => [
                'inferior' => [133,143],
                'reguler' => [144,154],
                'superior' =>[155,165],
            ],
            6 => [
                'inferior' => [166,176],
                'reguler' => [177,187],
                'superior' =>[188,198],
            ],
            7 => [
                'inferior' => [199,208],
                'reguler' => [209,218],
                'superior' =>[219,228],
            ],
            8 => [
                'inferior' => [229,241],
                'reguler' => [242,254],
                'superior' =>[255,267],
            ],
            9 => [
                'inferior' => [268,277],
                'reguler' => [278,287],
                'superior' =>[288,297],
            ],
            
        ];

        $subtopicId = $this->sub_topic_id;
        $level = strtolower($this->level);

        if (!isset($mapping[$subtopicId][$level])) {
            return collect([]);
        }

        [$start, $end] = $mapping[$subtopicId][$level];

        return MaterialSection::whereBetween('id', [$start, $end])
            ->orderBy('order')
            ->get();
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