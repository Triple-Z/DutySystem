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
        for ($i = 0; $i < 10; $i++) {
            if ($i % 2 == 0) {
                App\CardRecord::create([
                    'card_uid' => '12345'.$i,
                    'card_gate' => 'SN01',
                    'direction' => '1',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CardRecord::create([
                    'card_uid' => '12345'.$i,
                    'card_gate' => 'SN02',
                    'direction' => '0',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }

        for ($i = 0; $i < 10; $i++) {
            if ($i % 2 == 0) {
                App\CardRecord::create([
                    'card_uid' => '12345'.$i,
                    'card_gate' => 'SN03',
                    'direction' => '0',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                App\CardRecord::create([
                    'card_uid' => '12345'.$i,
                    'card_gate' => 'SN01',
                    'direction' => '1',
                    'timestamp' => Carbon::now('Asia/Shanghai'),
                ]);
            }
        }
    }
}
