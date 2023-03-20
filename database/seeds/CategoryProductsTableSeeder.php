<?php

use Illuminate\Database\Seeder;

class CategoryProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            for($j = 1; $j <= 20; $j++){
                $data = [];
                $data = [
                    'category_id' => $i,
                    'product_id'=> $j
                ];
                DB::table('category_products')->insert($data);
            }
        }
    }
}
