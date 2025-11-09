<?php

namespace Database\Seeders;

use App\Models\GameCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [ 'sub_topic_id' => 1, 'code' => 'PB1017', 'game_url' => 'https://courageous-flan-acb755.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 1, 'code' => 'PB2029', 'game_url' => 'https://courageous-flan-acb755.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 1, 'code' => 'PB3034', 'game_url' => 'https://courageous-flan-acb755.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 2, 'code' => 'KK1042', 'game_url' => 'https://lovely-jelly-9b38ce.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 2, 'code' => 'KK2056', 'game_url' => 'https://lovely-jelly-9b38ce.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 2, 'code' => 'KK3063', 'game_url' => 'https://lovely-jelly-9b38ce.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 3, 'code' => 'RF1071', 'game_url' => 'https://clever-pudding-8d69a4.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 3, 'code' => 'RF2085', 'game_url' => 'https://clever-pudding-8d69a4.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 3, 'code' => 'RF3092', 'game_url' => 'https://clever-pudding-8d69a4.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 4, 'code' => 'PG1048', 'game_url' => 'https://math-eksplorasi-sea-mathesia.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 4, 'code' => 'PG2053', 'game_url' => 'https://math-eksplorasi-sea-mathesia.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 4, 'code' => 'PG3069', 'game_url' => 'https://math-eksplorasi-sea-mathesia.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 5, 'code' => 'SP1074', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 5, 'code' => 'SP2086', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 5, 'code' => 'SP3091', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 6, 'code' => 'PY1065', 'game_url' => 'https://relaxed-tanuki-9c8c16.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 6, 'code' => 'PY2051', 'game_url' => 'https://relaxed-tanuki-9c8c16.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 6, 'code' => 'PY3083', 'game_url' => 'https://relaxed-tanuki-9c8c16.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 7, 'code' => 'LI1097', 'game_url' => 'https://coruscating-starlight-8a61fe.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 7, 'code' => 'LI2082', 'game_url' => 'https://coruscating-starlight-8a61fe.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 7, 'code' => 'LI3078', 'game_url' => 'https://coruscating-starlight-8a61fe.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 8, 'code' => 'GS1084', 'game_url' => 'https://math-labyrinth-mathesia.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 8, 'code' => 'GS2073', 'game_url' => 'https://math-labyrinth-mathesia.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 8, 'code' => 'GS3061', 'game_url' => 'https://math-labyrinth-mathesia.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 9, 'code' => 'BD1099', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 9, 'code' => 'BD2072', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 9, 'code' => 'BD3080', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'superior', 'description' => ''],

            [ 'sub_topic_id' => 10, 'code' => 'BL1087', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'inferior', 'description' => ''],
            [ 'sub_topic_id' => 10, 'code' => 'BL2096', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'reguler', 'description' => ''],
            [ 'sub_topic_id' => 10, 'code' => 'BL3076', 'game_url' => 'https://radar-kapal-perang-mathesia.netlify.app/', 'level' => 'superior', 'description' => ''],
        ];

        foreach ($games as $game) {
            GameCode::create($game);
        }
    }
}
