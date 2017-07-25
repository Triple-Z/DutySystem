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
        for ($i = 100; $i > 0; $i--) {
            \App\Employee::create([
                'name' => 'Employee' . $i,// 名字
                'gender' => 'man',// 性别
                'email' => $i . '@triplez.cn',// 电子邮件
                'phone_number' => '1524024105' . $i,// 电话号码
                'work_number' => '00'.$i,// 工号
                'work_title' => 'worker',// 头衔
                'department' => 'Production',// 部门
                'car_number' => '苏A2344' . $i,// 车牌号
                'card_uid' => '12345'. $i,// 职员卡UID
            ]);
        }
    }
}
