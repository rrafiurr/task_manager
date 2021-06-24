<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Rafiur\model\Sorting;

class SortingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sorting::create([
            'id' => '1',
            'sorting' => '[]'
        ]);
        
        
    }
}
