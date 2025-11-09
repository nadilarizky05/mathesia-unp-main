<?php

namespace Database\Seeders;

use App\Models\FinalTest;
use App\Models\GameCode;
use App\Models\Material;
use App\Models\MaterialSections;
use App\Models\StudentAnswer;
use App\Models\StudentFinalTest;
use App\Models\StudentFinalTestAnswer;
use App\Models\StudentProgress;
use App\Models\SubTopic;
use App\Models\Teams;
use App\Models\TeamsMember;
use App\Models\TKA;
use App\Models\TKAAnswer;
use App\Models\Topic;
use App\Models\User;
use Database\Factories\FinalTestFactory;
use Database\Factories\StudentFinalTestFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TopicSeeder::class,
            SubTopicSeeder::class,
            GameCodeSeeder::class,
            MaterialSeeder::class,
            MaterialSectionSeeder::class,
            TKASeeder::class,
            TeamsSeeder::class,
            TeamsMemberSeeder::class,
            FinalTestSeeder::class
        ]);
    }
}