<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            \App\Employee::create([
                'name' => 'Employee' . $i,
                'gender' => 'man',
                'email' => $i . '@triplez.cn',
                'phone_number' => '1524024105' . $i,
                'work_title' => 'worker',
                'department' => 'Production',
                'car_number' => '苏A2344' . $i,
                'card_uid' => '12345'. $i,
            ]);
        }
    }
}
