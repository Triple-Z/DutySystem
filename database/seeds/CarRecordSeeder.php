<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CarRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 51; $i < 61; $i++) {
            // i is from 51 to 60
            if ($i % 2 == 0) {
                App\CarRecord::create([
                    'car_number' => '苏A234'.$i,
                    'direction' => '1',// IN
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CarRecord::create([
                    'car_number' => '苏A234'.$i,
                    'direction' => '0',//OUT
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }

        for ($i = 51; $i < 61; $i++) {
            if ($i % 2 == 0) {
                App\CarRecord::create([
                    'car_number' => '苏A234'.$i,
                    'direction' => '0',// OUT
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CarRecord::create([
                    'car_number' => '苏A234'.$i,
                    'direction' => '1',// IN
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }
    }
}
