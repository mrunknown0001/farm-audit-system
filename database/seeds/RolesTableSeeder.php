<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	[
        		'name' => 'Super Admin'
        	],
        	[
        		'name' => 'Admin'
        	],
        	[
        		'name' => 'VP'
        	],
        	[
        		'name' => 'Division Head'
        	],
        	[
        		'name' => 'Manager'
        	],
        	[
        		'name' => 'Supervisor'
        	],
        	[
        		'name' => 'First Line' // Rank and File
        	]
        ]);
    }
}
