<?php

namespace Database\Seeders;

use App\Models\Teams;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [ 'name' => 'Tim UNP', 'slug' => 'tim-unp', 'description' => ''],
            [ 'name' => 'Tim DCI', 'slug' => 'tim-dci', 'description' => ''],
            [ 'name' => 'Tim Mahasiswa', 'slug' => 'tim-mahasiswa', 'description' => ''],
            
        ];

        foreach ($teams as $team) {
            Teams::create($team);
        }
    }
}
