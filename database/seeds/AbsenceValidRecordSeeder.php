<?php

use Illuminate\Database\Seeder;

class AbsenceValidRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 10; $i++) {
            App\AbsenceValidRecord::create([
                'employee_id' => $i,
                'year' => 2017,
                'month' => 8,
                'day' => 1,
                'type' => '病假',
            ]);
        }

        for ($i = 1; $i < 10; $i++) {
            App\AbsenceValidRecord::create([
                'employee_id' => $i,
                'year' => 2017,
                'month' => 8,
                'day' => 2,
                'type' => '事假',
            ]);
        }
    }
}
