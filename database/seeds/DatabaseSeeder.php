<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        DB::table('schedules')->insert([
        	'timein' => '7:00 AM',
        	'timeout' => '6:00 PM'
        ]);
    }
}
