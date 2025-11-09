<?php

namespace App\Traits;

use App\Models\StudentProgress;

trait HandlesStudentProgress
{
    /**
     * Simpan atau update progress siswa berdasarkan user_id + sub_topic_id.
     *
     * Jika sudah ada data untuk user + subtopic yang sama, maka akan diupdate,
     * bukan membuat baris baru — ini mencegah duplikasi antar controller.
     */
    public function updateProgressOrCreate(array $data)
    {
        // Pastikan minimal ada 'user_id' dan 'sub_topic_id'
        if (!isset($data['user_id']) || !isset($data['sub_topic_id'])) {
            throw new \InvalidArgumentException('user_id dan sub_topic_id wajib ada.');
        }

        // Ambil data lama (jika ada)
        $existing = StudentProgress::where('user_id', $data['user_id'])
            ->where('sub_topic_id', $data['sub_topic_id'])
            ->first();

        // Jika sudah ada, update (hindari duplikasi)
        if ($existing) {
            $existing->fill($data);
            $existing->save();
            return $existing;
        }

        // Jika belum ada, buat baru
        return StudentProgress::create($data);
    }
}