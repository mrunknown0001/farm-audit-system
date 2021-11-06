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
        	'system_name' => 'Online Audit System',
            'system_short_name' => 'OAS',
        	'system_description' => 'Online Audit System on Brookside Group of Companies',
        	'system_title_suffix' => ' - Online Audit System'
        ]);
    }
}
