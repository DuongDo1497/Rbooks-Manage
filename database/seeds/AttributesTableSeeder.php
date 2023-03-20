<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributes')->insert([
            [
                'name' => 'Số trang',
                'type' => 'number',
                'option' => null,
                'updated_user_id' => 1
            ],
            [
                'name' => 'Loại bìa',
                'type' => 'select',
                'option' => json_encode(['Bìa mềm', 'Bìa cứng']),
                'updated_user_id' => 1
            ],
        ]);
    }
}
