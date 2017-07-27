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
        for ($i = 0; $i < 10; $i++) {
            if ($i % 2 == 0) {
                App\CarRecord::create([
                    'car_number' => '苏A2344'.$i,
                    'direction' => '1',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CarRecord::create([
                    'car_number' => '苏A2344'.$i,
                    'direction' => '0',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }

        for ($i = 0; $i < 10; $i++) {
            if ($i % 2 == 0) {
                App\CarRecord::create([
                    'car_number' => '苏A2344'.$i,
                    'direction' => '0',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CarRecord::create([
                    'car_number' => '苏A2344'.$i,
                    'direction' => '1',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }
    }
}
