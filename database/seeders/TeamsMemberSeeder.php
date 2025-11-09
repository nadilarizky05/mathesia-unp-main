<?php

namespace Database\Seeders;

use App\Models\TeamsMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamMembers = [
            [ 'teams_id' => 1, 'name' => 'Dr. Yulyanti Harisman, S.Si., M.Pd', 'role' => '', 'avatar_url' => '', 'order'=>1],
            [ 'teams_id' => 1, 'name' => 'Hafizatunnisa, M.Pd', 'role' => '', 'avatar_url' => '', 'order'=>2],
            [ 'teams_id' => 1, 'name' => 'Aqilul Asra, S. Pd., Gr', 'role' => '', 'avatar_url' => '', 'order'=>3],
            [ 'teams_id' => 1, 'name' => 'Dr.  Ika Parma Dewi, M.Pd.T', 'role' => '', 'avatar_url' => '', 'order'=>4],
            [ 'teams_id' => 1, 'name' => 'Dr. Anny Sovia, S.Si., M.Pd', 'role' => '', 'avatar_url' => '', 'order'=>5],
            [ 'teams_id' => 1, 'name' => 'Dr. Muchamad Subali Noto, S.Si., M.Pd., MOS., MCE., CIRR.', 'role' => '', 'avatar_url' => '', 'order'=>6],
            [ 'teams_id' => 1, 'name' => 'Dr. Resmi Darni, M. Kom', 'role' => '', 'avatar_url' => '', 'order'=>7],
            [ 'teams_id' => 1, 'name' => 'Dra. Fitrani Dwina, M.Ed', 'role' => '', 'avatar_url' => '', 'order'=>8],

            [ 'teams_id' => 2, 'name' => 'Amin Rois Sinung Nugroho, SST, MS, MRes', 'role' => '', 'avatar_url' => '', 'order'=>1],
            [ 'teams_id' => 2, 'name' => 'Dewi Andriyanti, SST, MT', 'role' => '', 'avatar_url' => '', 'order'=>2],
            [ 'teams_id' => 2, 'name' => 'Nadila Rizky Amelia', 'role' => '', 'avatar_url' => '', 'order'=>3],

            [ 'teams_id' => 3, 'name' => 'Afiif Arrahman', 'role' => '', 'avatar_url' => '', 'order'=>1],
            [ 'teams_id' => 3, 'name' => 'Alya Arkan Nurvia, S.Pd', 'role' => '', 'avatar_url' => '', 'order'=>2],
            [ 'teams_id' => 3, 'name' => 'Kariza MZ', 'role' => '', 'avatar_url' => '', 'order'=>3],
            [ 'teams_id' => 3, 'name' => 'Latifah', 'role' => '', 'avatar_url' => '', 'order'=>4],
            [ 'teams_id' => 3, 'name' => 'Rahmawati, S.Pd', 'role' => '', 'avatar_url' => '', 'order'=>5],
            [ 'teams_id' => 3, 'name' => 'Ulfa Hidayatul Hasanah, S.Pd', 'role' => '', 'avatar_url' => '', 'order'=>6],
            [ 'teams_id' => 3, 'name' => 'Silvinia Eliza Putri, S.Pd', 'role' => '', 'avatar_url' => '', 'order'=>7],
            [ 'teams_id' => 3, 'name' => 'Riza Hartika Suri', 'role' => '', 'avatar_url' => '', 'order'=>8],
            [ 'teams_id' => 3, 'name' => 'Utary Agustia Dwiputri. F', 'role' => '', 'avatar_url' => '', 'order'=>9],
            
        ];

        foreach ($teamMembers as $teamMember) {
            TeamsMember::create($teamMember);
        }
    }
}
