<?php

use Illuminate\Database\Seeder;

class WarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->insert([
            [
                'name' => 'RBooks',
                'address' => '208 Nguyễn Hữu Cảnh',
                'phone' => '0909 111 222',
                'fee_percent' => 1,
                'profit_percent' => 21,
                'updated_user_id' => 1
            ],
        ]);
        DB::table('warehouses')->insert([
            [
                'name' => 'Tiki',
                'address' => '123 Tân Bình',
                'phone' => '0909 999 888',
                'fee_percent' => 1,
                'profit_percent' => 21,
                'updated_user_id' => 1
            ],
        ]);
    }
}
