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
        $this->call(RolesTableSeeder::class);
        $this->call(FarmsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        DB::table('configurations')->insert([
        	'system_name' => 'Farm Audit System',
            'system_short_name' => 'FAS',
        	'system_description' => 'Farm Audit System on Brookside Group of Companies',
        	'system_title_suffix' => ' - Farm Audit System'
        ]);
    }
}
