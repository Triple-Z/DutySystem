<?php

use Illuminate\Database\Seeder;
use App\Record;
use Carbon\Carbon;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($j = 1; $j <= 102; $j += 3) {

            for( $i = 0; $i < 4; $i++) {
                if ($i % 2 == 0){
                    Record::create([
                        'employee_id' => $j,
                        'check_direction' => '0',
                        'check_method' => 'car',
                        'check_time' => Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s'),
                    ]);
                } else {
                    Record::create([
                        'employee_id' => $j,
                        'check_direction' => '1',
                        'check_method' => 'car',
                        'check_time' => Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s'),
                    ]);
                }
            }

            for( $i = 0; $i < 4; $i++) {
                if ($i % 2 == 0){
                    Record::create([
                        'employee_id' => $j + 1,
                        'check_direction' => '0',
                        'check_method' => 'card',
                        'card_gate' => 'SN01',
                        'check_time' => Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s'),
                    ]);
                } else {
                    Record::create([
                        'employee_id' => $j + 1,
                        'check_direction' => '1',
                        'check_method' => 'card',
                        'card_gate' => 'SN02',
                        'check_time' => Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s'),
                    ]);
                }
            }

            for( $i = 0; $i < 4; $i++) {
                if ($i % 2 == 0){
                    Record::create([
                        'employee_id' => $j + 2,
                        'check_direction' => '0',
                        'check_method' => 'card',
                        'card_gate' => 'SN03',
                        'check_time' => Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s'),
                    ]);
                } else {
                    Record::create([
                        'employee_id' => $j + 2,
                        'check_direction' => '1',
                        'check_method' => 'card',
                        'card_gate' => 'SN02',
                        'check_time' => Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s'),
                    ]);
                }
            }

        }
    }
}
