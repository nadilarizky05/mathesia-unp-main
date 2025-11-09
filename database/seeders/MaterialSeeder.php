<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            ['sub_topic_id' => 1, 'title' => 'Pola Bilangan Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/SIM-LFgrQus?si=OGyECtwdu8reiip5', 'order' => 1, 'game_code_id'=>1],
            ['sub_topic_id' => 1, 'title' => 'Pola Bilangan Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/SIM-LFgrQus?si=OGyECtwdu8reiip5', 'order' => 2, 'game_code_id'=>2],
            ['sub_topic_id' => 1, 'title' => 'Pola Bilangan Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/SIM-LFgrQus?si=OGyECtwdu8reiip5', 'order' => 3, 'game_code_id'=>3],

            ['sub_topic_id' => 2, 'title' => 'Koordinat Kartesius Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/E2f95LsDSio?si=JWj7RaKKZMN_rTaF', 'order' => 1, 'game_code_id'=>4],
            ['sub_topic_id' => 2, 'title' => 'Koordinat Kartesius Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/E2f95LsDSio?si=JWj7RaKKZMN_rTaF', 'order' => 2, 'game_code_id'=>5],
            ['sub_topic_id' => 2, 'title' => 'Koordinat Kartesius Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/E2f95LsDSio?si=JWj7RaKKZMN_rTaF', 'order' => 3, 'game_code_id'=>6],

            ['sub_topic_id' => 3, 'title' => 'Relasi Fungsi Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/fsZj7CsZPRI?si=QuvKUeCgHjNK136f', 'order' => 1, 'game_code_id'=>7],
            ['sub_topic_id' => 3, 'title' => 'Relasi Fungsi Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/fsZj7CsZPRI?si=QuvKUeCgHjNK136f', 'order' => 2, 'game_code_id'=>8],
            ['sub_topic_id' => 3, 'title' => 'Relasi Fungsi Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/fsZj7CsZPRI?si=QuvKUeCgHjNK136f', 'order' => 3, 'game_code_id'=>9],

            ['sub_topic_id' => 4, 'title' => 'Persamaan Garis Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/G9kp4yq92Xc?si=URzlgyNVm8M32emO', 'order' => 1, 'game_code_id'=>10],
            ['sub_topic_id' => 4, 'title' => 'Persamaan Garis Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/G9kp4yq92Xc?si=URzlgyNVm8M32emO', 'order' => 2, 'game_code_id'=>11],
            ['sub_topic_id' => 4, 'title' => 'Persamaan Garis Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/G9kp4yq92Xc?si=URzlgyNVm8M32emO', 'order' => 3, 'game_code_id'=>12],

            ['sub_topic_id' => 5, 'title' => 'SPLDV Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/B5PaFOJ8Png?si=dNXGUqPbkQy9yUuV', 'order' => 1, 'game_code_id'=>14],
            ['sub_topic_id' => 5, 'title' => 'SPLDV Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/B5PaFOJ8Png?si=dNXGUqPbkQy9yUuV', 'order' => 2, 'game_code_id'=>15],
            ['sub_topic_id' => 5, 'title' => 'SPLDV Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/B5PaFOJ8Png?si=dNXGUqPbkQy9yUuV', 'order' => 3, 'game_code_id'=>16],

            ['sub_topic_id' => 6, 'title' => 'Theorema Pythagoras Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/NoLsDwkNbVs?si=ZaQWphQK7GY2D-6q', 'order' => 1, 'game_code_id'=>17],
            ['sub_topic_id' => 6, 'title' => 'Theorema Pythagoras Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/NoLsDwkNbVs?si=ZaQWphQK7GY2D-6q', 'order' => 2, 'game_code_id'=>18],
            ['sub_topic_id' => 6, 'title' => 'Theorema Pythagoras Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/NoLsDwkNbVs?si=ZaQWphQK7GY2D-6q', 'order' => 3, 'game_code_id'=>19],

            ['sub_topic_id' => 7, 'title' => 'Lingkaran Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/_wjOho8khio?si=SmHk9CLBH27bRJL9', 'order' => 1, 'game_code_id'=>20],
            ['sub_topic_id' => 7, 'title' => 'Lingkaran Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/_wjOho8khio?si=SmHk9CLBH27bRJL9', 'order' => 2, 'game_code_id'=>21],
            ['sub_topic_id' => 7, 'title' => 'Lingkaran Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/_wjOho8khio?si=SmHk9CLBH27bRJL9', 'order' => 3, 'game_code_id'=>22],

            ['sub_topic_id' => 8, 'title' => 'Garis Singgung Lingkaran Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/mbqs4O538P8?si=qvFpvnQ_HQZXaeie', 'order' => 1, 'game_code_id'=>23],
            ['sub_topic_id' => 8, 'title' => 'Garis Singgung Lingkaran Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/mbqs4O538P8?si=qvFpvnQ_HQZXaeie', 'order' => 2, 'game_code_id'=>24],
            ['sub_topic_id' => 8, 'title' => 'Garis Singgung Lingkaran Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/mbqs4O538P8?si=qvFpvnQ_HQZXaeie', 'order' => 3],

            ['sub_topic_id' => 9, 'title' => 'Bangun Ruang Sisi Datar Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/IIB9rAOGmhY?si=rSoSz3QNFSsC5FLn', 'order' => 1, 'game_code_id'=>25],
            ['sub_topic_id' => 9, 'title' => 'Bangun Ruang Sisi Datar Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/IIB9rAOGmhY?si=rSoSz3QNFSsC5FLn', 'order' => 2, 'game_code_id'=>26],
            ['sub_topic_id' => 9, 'title' => 'Bangun Ruang Sisi Datar Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/IIB9rAOGmhY?si=rSoSz3QNFSsC5FLn', 'order' => 3, 'game_code_id'=>27],

            ['sub_topic_id' => 10, 'title' => 'Bangun Ruang Sisi Lengkung Inferior', 'level' => 'inferior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/VjvzF9gEgww?si=p4KiSh6vswSJI7IW', 'order' => 1, 'game_code_id'=>28],
            ['sub_topic_id' => 10, 'title' => 'Bangun Ruang Sisi Lengkung Reguler', 'level' => 'reguler', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/VjvzF9gEgww?si=p4KiSh6vswSJI7IW', 'order' => 2, 'game_code_id'=>29],
            ['sub_topic_id' => 10, 'title' => 'Bangun Ruang Sisi Lengkung Superior', 'level' => 'superior', 'content' => '', 'file_url' => '', 'video_url' => 'https://www.youtube.com/embed/VjvzF9gEgww?si=p4KiSh6vswSJI7IW', 'order' => 3, 'game_code_id'=>30],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}