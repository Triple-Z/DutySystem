<?php

use Illuminate\Database\Seeder;

use App\ActionRecord;
use Carbon\Carbon;

class ActionRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            ActionRecord::create([
                'user_id' => '1',
                'action' => 'login',
                'timestamp' => Carbon::now(),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            ActionRecord::create([
                'user_id' => '2',
                'action' => 'logout',
                'timestamp' => Carbon::now(),
            ]);
        }
        
        for ($i = 0; $i < 5; $i++) {
            ActionRecord::create([
                'user_id' => '3',
                'action' => 'login',
                'timestamp' => Carbon::now(),
            ]);
        }
    }
}
