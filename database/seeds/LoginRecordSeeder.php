<?php

use Illuminate\Database\Seeder;

use App\LoginRecord;
use Carbon\Carbon;

class LoginRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            LoginRecord::create([
                'user_id' => '1',
                'login_time' => Carbon::now(),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            LoginRecord::create([
                'user_id' => '2',
                'login_time' => Carbon::now(),
            ]);
        }
        
        for ($i = 0; $i < 5; $i++) {
            LoginRecord::create([
                'user_id' => '3',
                'login_time' => Carbon::now(),
            ]);
        }
    }
}
