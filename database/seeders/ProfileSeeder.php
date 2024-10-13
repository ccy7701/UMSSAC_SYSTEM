<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertSeederData(1, 'ccy7701', 'TEST', '2021/2022', 'FKIKK', 'UH6481001', 'profile-pictures/8MXKh2qIMqiOa0hV9BAKv815xTmtRlqUgehKwiFE.png');
        $this->insertSeederData(2, 'SeeleOfBelobog', '', null, 'FKIKK', 'UH6481005', 'profile-pictures/jBfzQnwQjc80jr66lGwDpJCxXdjoGy1SXzKqpi3G.png');
        $this->insertSeederData(3, '', '', null, 'FKIKK', 'UH6481001', '');
        $this->insertSeederData(4, '', '', '', 'FPPS', '', 'profile-pictures/iD44oMYJ0g2xPOyY55s0DTpEYKsLGDblq1z34VED.png');
        $this->insertSeederData(5, '', '', '', 'FKIKK', '', 'profile-pictures/s6GoLyKZie2QzN8LHgLuf74i8SstzeluZu3Gj0eo.png');
        $this->insertSeederData(6, '', '', '', 'FKIKK', '', 'profile-pictures/mtn3LKUBdT44hFM8HYsJ45gnKhU8tyKJQiHyAqvC.png');
        $this->insertSeederData(7, '', '', '', 'FKIKK', '', 'profile-pictures/eJgwJnOj7y0CYqShoNmBAGrzxxkG8XEkuF7sEI3M.png');
        $this->insertSeederData(8, '', '', '', 'FKIKK', '', 'profile-pictures/1ayZVLkowZDfyqUoeDs9HRNOp1tuHhTW4dzJCEU4.png');
        $this->insertSeederData(9, '', '', '', 'FPPS', '', 'profile-pictures/zakZo1brRb52JPGLrAHLz32K2aAKJCQpFJuz4VIZ.png');
        $this->insertSeederData(10, '', '', '', 'FPPS', '', 'profile-pictures/2tGyjOjbVNTa4WLd6dRDQESoaMsVnsg9YumCATZT.png');
        $this->insertSeederData(11, '', '', '', 'FSSA', '', 'profile-pictures/ToTeQKEpdBIbGTpL1HyzgFnm1uf8lj5jtqlZePLd.png');
        $this->insertSeederData(12, '', '', '', 'FPPS', '', 'profile-pictures/CD66wWkNG1twZinbD4FhRObDAnIfA13YQoQx4Ws9.png');
        $this->insertSeederData(13, '', '', '', 'FPPS', '', 'profile-pictures/KLL2PY7sFW5hf56zI8sEIp5ddgwcSP3R8DkMBcy2.png');
        $this->insertSeederData(14, '', '', '', 'FPPS', '', 'profile-pictures/o4JO26uQqKDUhxa6Tnqzi0pXTesneAeGEXeI8Z7L.png');
        $this->insertSeederData(15, '', '', '', 'FKIKK', '', 'profile-pictures/X6ISq7LZdQ6Cxkxc7HLTA8M6XKZ7AALBpyX2ipU9.png');
        $this->insertSeederData(16, '', '', '', 'FKIKK', '', 'profile-pictures/u5BpwV29k90E6t032jx7RVYLE3C5HudVqWXpInfO.png');
        $this->insertSeederData(17, '', '', '', 'FKIKK', '', 'profile-pictures/ae6O9YJU32d1W9tpz2qE6AYvkwyY5NwlSktmlU9D.png');
        $this->insertSeederData(18, '', '', '', 'FKIKK', '', 'profile-pictures/qHx9icJ18lKVKZ9lLKX8DzSRHJ7DzwICXuUU5BPC.png');
    }

    private function insertSeederData($accountId, $profileNickname, $profilePersonalDesc, $profileEnrolmentSession, $profileFaculty, $profileCourse, $profilePictureFilepath) {
        $data = [
            'profile_id' => $accountId, // For the seeder, the assumption is the value of profileID and accountID are the same
            'account_id' => $accountId,
            'profile_nickname' => $profileNickname,
            'profile_personal_desc' => $profilePersonalDesc,
            'profile_enrolment_session' => $profileEnrolmentSession,
            'profile_faculty' => $profileFaculty,
            'profile_course' => $profileCourse,
            'profile_picture_filepath' => $profilePictureFilepath,
        ];

        DB::table('profile')->insert($data);
    }
}
