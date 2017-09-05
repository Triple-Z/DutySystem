<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CardRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 50; $i < 10; $i--) {
            // i is from 50 to 10
            if ($i % 2 == 0) {
                App\CardRecord::create([
                    'card_uid' => '#543'.$i,
                    'card_gate' => 'SN01',
                    'direction' => '1',// IN
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CardRecord::create([
                    'card_uid' => '#543'.$i,
                    'card_gate' => 'SN02',
                    'direction' => '0',// OUT
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }

        for ($i = 50; $i < 10; $i--) {
            if ($i % 2 == 0) {
                App\CardRecord::create([
                    'card_uid' => '#543'.$i,
                    'card_gate' => 'SN03',
                    'direction' => '0',// OUT
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CardRecord::create([
                    'card_uid' => '#543'.$i,
                    'card_gate' => 'SN01',
                    'direction' => '1',// IN
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }
    }
}
