<?php

use Illuminate\Database\Seeder;

class FarmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('farms')->insert([
            [
                'name' => 'Brooskide Farms Corporation',
                'code' => 'BFC'
            ],
            [
                'name' => 'Poultrypure Farms Corporation',
                'code' => 'PFC'
            ],
            [
                'name' => 'Brookdale Farms Corporation',
                'code' => 'BDL'
            ],
            [
                'name' => 'RH Farms Corporation',
                'code' => 'RH'
            ],
            [
                'name' => 'Fonte Fresca',
                'code' => 'FONTE'
            ]
        ]);
    }
}
