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
        		'email' => 'adam@adam.com',
        		'role_id' => 2, // Administrator
                'manager_id' => null,
        		'password' => bcrypt('password')
        	],
        	[
                'first_name' => 'Jeff',
                'last_name' => 'Montiano',
                'email' => 'jmontiano@bfcgroup.org',
        		'role_id' => 3, // Manager
                'manager_id' => null,
        		'password' => bcrypt('password')
        	],
            [
                'first_name' => 'Kim',
                'last_name' => 'Bacani',
                'email' => 'k.bacani@bfcgroup.org',
                'role_id' => 4, // Employee
                'manager_id' => 2,
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'Dave',
                'last_name' => 'Toribio',
                'email' => 'd.toribio@bfcgroup.org',
                'role_id' => 4, // Employee
                'manager_id' => 2,
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'Adam',
                'last_name' => 'Trinidad',
                'email' => 'm.trinidad@bfcgroup.org',
                'role_id' => 4, // Employee
                'manager_id' => 2,
                'password' => bcrypt('password')
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'j.doe@bfcgroup.org',
                'role_id' => 4, // Employee
                'manager_id' => 2,
                'password' => bcrypt('password')
            ]
        ]);
    }
}
