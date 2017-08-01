<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HolidayDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            App\HolidayDate::create([
                'year' => 2017,
                'month' => 8,
                'day' => $i,
                'created_at' => Carbon::now('Asia/Shanghai'),
                'updated_at' => Carbon::now('Asia/Shanghai'),
            ]);
        }
    }
}
