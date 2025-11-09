<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamsMember extends Model
{
    /** @use HasFactory<\Database\Factories\TeamsMemberFactory> */
    use HasFactory;

     protected $fillable = ['team_id', 'name', 'role', 'avatar_url',  'order'];

    public function team()
    {
        return $this->belongsTo(Teams::class, 'teams_id');
    }
}