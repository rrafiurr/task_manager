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
        for($i=1;$i<=3;$i++)
        {
            if(DB::table('sortings')->count() == 0){

                DB::table('sortings')->insert([
    
                    [
                        'id' => 1,
                        'sorting' => '[]'
                    ],
                    [
                        'id' => 2,
                        'sorting' => '[]'
                    ],
                    [
                        'id' => 3,
                        'sorting' => '[]'
                    ]
    
                ]);
                
            } else { echo "\e[31mTable is not empty, therefore NOT "; }
        }
        
        
    }
}
