<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'nis' => '1234567890',
            'name' => 'Administrator',
            'email' => 'admin@mathesia.com',
            'password' => Hash::make('1234567890'),
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);

        // Teacher User
        User::create([
            'nis' => 'TCH001',
            'name' => 'Budi Santoso',
            'email' => 'teacher@lms.com',
            'password' => Hash::make('TCH001'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        // Student User
        User::create([
            'nis' => 'STD001',
            'name' => 'Ani Wijaya',
            'email' => 'student@lms.com',
            'password' => Hash::make('STD001'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        // ====== 10 Teacher Users (ROLE_TEACHER) ======
        User::create([
            'nis' => '100001',
            'name' => 'guru01',
            'email' => 'guru01@lms.com',
            'password' => Hash::make('100001'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100002',
            'name' => 'guru02',
            'email' => 'guru02@lms.com',
            'password' => Hash::make('100002'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100003',
            'name' => 'guru03',
            'email' => 'guru03@lms.com',
            'password' => Hash::make('100003'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100004',
            'name' => 'guru04',
            'email' => 'guru04@lms.com',
            'password' => Hash::make('100004'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100005',
            'name' => 'guru05',
            'email' => 'guru05@lms.com',
            'password' => Hash::make('100005'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100006',
            'name' => 'guru06',
            'email' => 'guru06@lms.com',
            'password' => Hash::make('100006'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100007',
            'name' => 'guru07',
            'email' => 'guru07@lms.com',
            'password' => Hash::make('100007'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100008',
            'name' => 'guru08',
            'email' => 'guru08@lms.com',
            'password' => Hash::make('100008'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100009',
            'name' => 'guru09',
            'email' => 'guru09@lms.com',
            'password' => Hash::make('100009'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '100010',
            'name' => 'guru10',
            'email' => 'guru10@lms.com',
            'password' => Hash::make('100010'),
            'role' => User::ROLE_TEACHER,
            'email_verified_at' => now(),
        ]);

        // ====== 10 Student Users (ROLE_STUDENT) ======
        User::create([
            'nis' => '200001',
            'name' => 'mahasiswa01',
            'email' => 'mahasiswa01@lms.com',
            'password' => Hash::make('200001'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200002',
            'name' => 'mahasiswa02',
            'email' => 'mahasiswa02@lms.com',
            'password' => Hash::make('200002'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200003',
            'name' => 'mahasiswa03',
            'email' => 'mahasiswa03@lms.com',
            'password' => Hash::make('200003'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200004',
            'name' => 'mahasiswa04',
            'email' => 'mahasiswa04@lms.com',
            'password' => Hash::make('200004'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200005',
            'name' => 'mahasiswa05',
            'email' => 'mahasiswa05@lms.com',
            'password' => Hash::make('200005'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200006',
            'name' => 'mahasiswa06',
            'email' => 'mahasiswa06@lms.com',
            'password' => Hash::make('200006'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200007',
            'name' => 'mahasiswa07',
            'email' => 'mahasiswa07@lms.com',
            'password' => Hash::make('200007'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200008',
            'name' => 'mahasiswa08',
            'email' => 'mahasiswa08@lms.com',
            'password' => Hash::make('200008'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200009',
            'name' => 'mahasiswa09',
            'email' => 'mahasiswa09@lms.com',
            'password' => Hash::make('200009'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nis' => '200010',
            'name' => 'mahasiswa10',
            'email' => 'mahasiswa10@lms.com',
            'password' => Hash::make('200010'),
            'role' => User::ROLE_STUDENT,
            'email_verified_at' => now(),
        ]);
    }
}