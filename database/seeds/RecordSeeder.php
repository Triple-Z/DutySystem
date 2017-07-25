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
        for( $i = 0; $i < 30; $i++) {
            if ($i % 2 == 0){
                Record::create([
                    'employee_id' => '1',
                    'check_direction' => '0',
                    'check_method' => 'car',
                    'check_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            } else {
                Record::create([
                    'employee_id' => '1',
                    'check_direction' => '1',
                    'check_method' => 'car',
                    'check_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }

        for( $i = 0; $i < 30; $i++) {
            if ($i % 2 == 0){
                Record::create([
                    'employee_id' => '3',
                    'check_direction' => '0',
                    'check_method' => 'card',
                    'check_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            } else {
                Record::create([
                    'employee_id' => '3',
                    'check_direction' => '1',
                    'check_method' => 'card',
                    'check_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }

        for( $i = 0; $i < 30; $i++) {
            if ($i % 2 == 0){
                Record::create([
                    'employee_id' => '2',
                    'check_direction' => '0',
                    'check_method' => 'card',
                    'check_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            } else {
                Record::create([
                    'employee_id' => '2',
                    'check_direction' => '1',
                    'check_method' => 'card',
                    'check_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }

    }
}
