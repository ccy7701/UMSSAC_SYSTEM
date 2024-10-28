<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertSeederData(1, 'Chiew Cheng Yi', 'chiewccy2@gmail.com', '$2y$12$UdMUCW1k18O525T2CpFc8O8hJKZKdKwOLfxmAzkpx2MR2SODYb9Ka', 1, 'BI21110236');
        $this->insertSeederData(2, 'Faculty Chiew', 'faculty@email.com', '$2y$12$G/6PPGNan7KL1YNvYagqTO5h/y2cbCeOKhOznDC9d.WAouZ0BtuQy', 2, null);
        $this->insertSeederData(3, 'Admin Chiew', 'admin@email.com', '$2y$12$4Kasaxyl/3X2OlNmjwl2LO0xBdrQz/AUMeSWAEkmNvlL63gAg/SJq', 3, null);
        $this->insertSeederData(4, 'Li Mei Tan', 'limei.tan.fpp23@ums.edu.my', '$2y$12$ZEZ8u.mQ6f8GJ4CTKqfBquIAxNVdlpoqoa5nXzPUd2bHTWB86Sts.', 1, 'BP23210001');
        $this->insertSeederData(5, 'Ahmad Faiz', 'ahmad.faiz21@students.ums.edu.my', '$2y$12$LnhEoQHAGBl2es0dnV4DTOzMA7z.0l7FGyaNhIKWtS3SGKJBD4EKq', 1, 'BI21210001');
        $this->insertSeederData(6, 'Ariff Zulkifli', 'ariff.zulfikri.fki21@edu.ums.my', '$2y$12$n80VGGW270kN87tEwD/55.KmC06g4Y2Rt4MVENsUHPhk/FYks8O3y', 1, 'BI21210002');
        $this->insertSeederData(7, 'Devan Nair', 'devan.nair21@edu.ums.my', '$2y$12$PAeix0VdIkDwSS5bjMNZ2OKWjVkIrpOE9UjgtCoTTUYxWRry/CRpe', 1, 'BI21210003');
        $this->insertSeederData(8, 'James Lim', 'james.lim.fki21@edu.ums.my', '$2y$12$bMW2iLhZSGY9HJzpedMzguMzYm4R8q1rlDKLkxk35ZTkmuq8ZlvJO', 1, 'BI21210004');
        $this->insertSeederData(9, 'Siti Nurhaliza', 'sitinurhaliza.23@fki.ums.edu.my', '$2y$12$9zS6MAZLVVw8Qot5DthB.OMGws8h7LZxnMZELhUSBVpWdaMZFcnH2', 1, 'BP23210002');
        $this->insertSeederData(10, 'Jessie Lim', 'jessie.lim23@ums.ac.my', '$2y$12$QIVt6qWm2GDPoyBo5U6uhusPbRun86zzCDCx9XxxblaAVN11l7NVu', 1, 'BP23210003');
        $this->insertSeederData(11, 'Chong Wei Ling', 'weiling.23@students.ums.edu.my', '$2y$12$ar1Lxa3RPheK6md7Emk0auZS0ugyEf1nirkJIlKDgmGTqF14ARLTC', 1, 'BP23210004');
        $this->insertSeederData(12, 'Indira Kumar', 'indira.kumar.bs23@ums.edu.my', '$2y$12$XH//QOaDmjxR8sqlp8qb1.USXAu8jjVIife8P5P4h1uucwShs4ZV6', 1, 'BS23210001');
        $this->insertSeederData(13, 'Nurul Izzah', 'nurul.izzah23@fpp.ums.edu.my', '$2y$12$eFPXz8U2gzF0JtFbzM.IWeTKlXeWZOegbhX9vIzMF.XjmvcY6ain6', 1, 'BP23210005');
        $this->insertSeederData(14, 'Ainul Farhana', 'ainul.farhana23@ums.ac.my', '$2y$12$a50VHp6N.CIqgAw7qBHm1Okgh7IOazxpQbxTXsg5ykvp5flVegIMm', 1, 'BP23210006');
        $this->insertSeederData(15, 'Zulhilmi Ramli', 'zulhilmi.ramli21@student.ums.my', '$2y$12$RQEltKANQumlUeJ/u.hflO6yEOMVH7g7J4fHWUj/tzPU2djyIfAWq', 1, 'BI21210008');
        $this->insertSeederData(16, 'Chen Wei Jian', 'chen.weijian21@fki.ums.edu.my', '$2y$12$B36QGm6j75mVW9twSAt6seom0AwvVK1XeUoBhQL9i3bgUTM4lGt6.', 1, 'BI21210009');
        $this->insertSeederData(17, 'Tan Boon Keat', 'boonkeat.22@students.ums.edu.my', '$2y$12$EAXECdLSWxhCOskmEAdI5ufO7hAuMqm6Dr8NzqVdAddGWWu8BbnN2', 1, 'BI22210001');
        $this->insertSeederData(18, 'Lee Jian Hao', 'jianhao.lee21@ums.ac.my', '$2y$12$28aRpKg/apOIqUEaBkokye9w1w9VX4RaEiGaafps5JBzwgGiGJ3Ny', 1, 'BI21210010');
    }

    private function insertSeederData($accountId, $accountFullName, $accountEmailAddress, $accountPassword, $accountRole, $accountMatricNumber): void
    {
        $data = [
            'account_id' => $accountId,
            'account_full_name' => $accountFullName,
            'account_email_address' => $accountEmailAddress,
            'account_password' => $accountPassword,
            'account_role' => $accountRole,
            'account_matric_number' => $accountMatricNumber,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('account')->insert($data);
    }
}
