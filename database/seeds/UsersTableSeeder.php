<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
        		'first_name' => 'Michael Adam',
        		'last_name' => 'Trinidad',
        		'email' => 'm.trinidad@bfcgroup.org',
        		'role_id' => 2, // Administrator
        		'password' => bcrypt('password')
        	],
            [
                'first_name' => 'Tetta',
                'last_name' => 'Dizon',
                'email' => 'tettadizon@bfcgroup.org',
                'role_id' => 3, // VP
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'Div',
                'last_name' => 'Head',
                'email' => 'divhead@bfcgroup.org',
                'role_id' => 4, // VP
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'Jeff',
                'last_name' => 'Montiano',
                'email' => 'jmontiano@bfcgroup.org',
                'role_id' => 5, // Manager
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'Adam',
                'last_name' => 'Trinidad',
                'email' => 'adam@adam.com',
                'role_id' => 6,
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'Kim',
                'last_name' => 'Bacani',
                'email' => 'k.bacani@bfcgroup.org',
                'role_id' => 7,
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'Dave',
                'last_name' => 'Toribio',
                'email' => 'd.toribio@bfcgroup.org',
                'role_id' => 7, 
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'j.doe@bfcgroup.org',
                'role_id' => 8, 
                'password' => bcrypt('password')
            ]
        ]);
    }
}
