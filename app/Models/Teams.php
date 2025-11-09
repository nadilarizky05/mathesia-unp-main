<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    /** @use HasFactory<\Database\Factories\TeamsFactory> */
    use HasFactory;
     protected $fillable = ['name', 'slug', 'description'];

    public function members()
    {
        return $this->hasMany(TeamsMember::class, 'teams_id')->orderBy('order');
    }
}