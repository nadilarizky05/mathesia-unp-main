<?php

namespace Database\Seeders;

use App\Models\SubTopic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subtopics = [
            [ 'topic_id' => 1, 'title' => 'Pola Bilangan', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Koordinat Kartesius', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Relasi Fungsi', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Persamaan Garis', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'SPLDV', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Pythagoras', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Lingkaran', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Garis Singgung Lingkaran', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Bangun Ruang Sisi Datar', 'description' => '', 'thumbnail_url' => ''],
            [ 'topic_id' => 1, 'title' => 'Bangun Ruang Sisi Lengkung', 'description' => '', 'thumbnail_url' => ''],
        ];

        foreach ($subtopics as $subtopic) {
            SubTopic::create($subtopic);
        }
    }
}
