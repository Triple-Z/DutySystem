<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(RecordSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(EmployeeSeeder::class);
        // $this->call(ActionRecordSeeder::class);
        // $this->call(CarRecordSeeder::class);
        // $this->call(CardRecordSeeder::class);
        // $this->call(TimeNodeSeeder::class);
        $this->call(DailyCheckStatusSeeder::class);
        // $this->call(HolidayDateSeeder::class);
    }
}
