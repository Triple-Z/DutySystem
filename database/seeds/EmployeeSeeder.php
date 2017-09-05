<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Employees only have card
        for ($i = 50; $i > 10; $i--) {
            // $i is from 50 to 10
            \App\Employee::create([
                'name' => 'Employee' . $i,// 名字
                'gender' => 'man',// 性别
                'email' => $i . '@triplez.cn',// 电子邮件
                'phone_number' => '152402410' . $i,// 电话号码
                'work_number' => '00'.$i,// 工号
                'work_title' => 'worker',// 头衔
                'department' => 'Production',// 部门
                // 'car_number' => '苏A2344' . $i,// 车牌号
                'card_uid' => '#543'. $i,// 职员卡UID
                'created_at' => Carbon::now('Asia/Shanghai'),
                'updated_at' => Carbon::now('Asia/Shanghai'),
            ]);
        }

        // Employees have card and car
        for ($i = 60; $i > 50; $i--) {
            // $i is from 60 to 51
            \App\Employee::create([
                'name' => 'Employee' . $i,// 名字
                'gender' => 'man',// 性别
                'email' => $i . '@triplez.cn',// 电子邮件
                'phone_number' => '152402410' . $i,// 电话号码
                'work_number' => '00'.$i,// 工号
                'work_title' => 'worker',// 头衔
                'department' => 'Production',// 部门
                'car_number' => '苏A234' . $i,// 车牌号
                'card_uid' => '#543'. $i,// 职员卡UID
                'created_at' => Carbon::now('Asia/Shanghai'),
                'updated_at' => Carbon::now('Asia/Shanghai'),
            ]);
        }
    }
}
