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


        DB::table('configurations')->insert([
        	'system_name' => 'Farm Audit System',
        	'system_description' => 'Farm Audit System on Brookside Group of Companies',
        	'system_title_prefix' => ' - Farm Audit System'
        ]);
    }
}
