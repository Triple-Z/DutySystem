<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DailyCheckStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i <= 100; $i++) {
            App\DailyCheckStatus::create([
                'employee_id' => $i,
                'date' => '2017-08-13',
                'am_check' => Carbon::now(),
                'am_away' => Carbon::now(),
                'pm_check' => Carbon::now(),
                'pm_away' => Carbon::now(),
                'status' => '正常',
            ]);

        }

    }
}
