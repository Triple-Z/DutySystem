<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'TripleZ',
            'email' => 'me@triplez.cn',
            'password' => bcrypt('triplez_cn'),
            'admin' => '1',
            'phone_number' => '15240241051',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        App\User::create([
            'name' => 'test',
            'email' => 'test@triplez.cn',
            'password' => bcrypt('testtest'),
            'admin' => '0',
            'phone_number' => '15240241052',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
