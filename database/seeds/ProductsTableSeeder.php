<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(RBooks\Models\Product::class, 30)->create();
        $faker = Faker\Factory::create();

        $names = array('Chăn hè thu xuất khẩu', 'Bộ lau nhà 360 độ mẫu mới có trục giặt xả bông', 'Phích giữ nhiệt Inox', 'Ly sứ có quai', 'Lò vi sóng đa năng', 'Máy Xay Sinh Tố Điện Tử 2 Cối Asanzo', 'Nồi Cơm Điện Nắp Gài Asanzo', 'Thớt mặt gấu', 'Vĩ nướng tráng men', 'Bộ vợt muỗi đa năng', 'Lót ly hình vỏ xò', 'Đồng hồ treo tường', 'Bình giữ nhiệt lock & lock', 'Bộ 6 dĩa nhỏ thủy tinh', 'Bộ hộp cơm thủy tinh', 'Bộ 2 nồi Inox', 'Combo 2 ruột gối', 'Đèn bàn bảo vệ thị lực', 'Gối tựa cổ hình con chó', 'Kệ đựng đồ gia dụng');
        $data =[];
        foreach($names as $name)
        {
            $data = [
                'name' => $name,
                'slug'=> str_slug($name),
                'cover_price' => rand(50000, 180000),
                'sale_price' => rand(30000, 150000),
                'description' => $faker->paragraph(1),
                'quantity' => rand(3, 30),
                'updated_user_id' => rand(1, 2)
            ];

            DB::table('products')->insert($data);
        }
    }
}
