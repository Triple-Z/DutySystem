<?php

use Illuminate\Database\Seeder;

class TimeNodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\TimeNode::create([
            'name' => 'am_start',
            'day' => '0',
            'hour' => '3',
            'minute' => '0',
            'second' => '0',
        ]);

        App\TimeNode::create([
            'name' => 'am_end',
            'day' => '0',
            'hour' => '14',
            'minute' => '0',
            'second' => '0',
        ]);

        App\TimeNode::create([
            'name' => 'pm_start',
            'day' => '0',
            'hour' => '11',
            'minute' => '59',
            'second' => '59',
        ]);

        App\TimeNode::create([
            'name' => 'pm_end',
            'day' => '1',
            'hour' => '3',
            'minute' => '0',
            'second' => '0',
        ]);

        App\TimeNode::create([
            'name' => 'am_ddl',
            'day' => '0',
            'hour' => '8',
            'minute' => '0',
            'second' => '0',
        ]);

        App\TimeNode::create([
            'name' => 'am_late_ddl',
            'day' => '0',
            'hour' => '10',
            'minute' => '0',
            'second' => '0',
        ]);

        App\TimeNode::create([
            'name' => 'pm_ddl',
            'day' => '0',
            'hour' => '14',
            'minute' => '0',
            'second' => '0',
        ]);

        App\TimeNode::create([
            'name' => 'pm_early_ddl',
            'day' => '0',
            'hour' => '16',
            'minute' => '0',
            'second' => '0',
        ]);

        App\TimeNode::create([
            'name' => 'pm_away',
            'day' => '0',
            'hour' => '17',
            'minute' => '59',
            'second' => '59',
        ]);
    }
}
