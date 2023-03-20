<?php

use Illuminate\Database\Seeder;
use RBooks\Models\Category;

class CategoriesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // factory(App\Models\Category::class, 20)->create();
        $faker = Faker\Factory::create();
        
        $datas = [];

        // 1 category = 1 cuc nay
        $datas[] = [
            'name' => 'Nội thất nhà cửa',
            'slug' => 'noi-that-nha-cua',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];
        // copy paste ra
        // 1 category = 1 cuc nay
        $datas[] = [
            'name' => 'Vật dụng gia đình',
            'slug' => 'vat-dung-gia-dinh',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];
        // copy paste ra
        // 1 category = 1 cuc nay
        $datas[] = [
            'name' => 'Vật dụng nhà bếp',
            'slug' => 'vat-dung-nha-bep',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];
        // copy paste ra
        // 1 category = 1 cuc nay
        $datas[] = [
            'name' => 'Sách và văn phòng phẩm',
            'slug' => 'sach-va-van-phong-pham',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];
        // copy paste ra
        // 
        // // 1 category = 1 cuc nay
        $datas[] = [
            'name' => 'Thời trang',
            'slug' => 'thoi-trang',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];
        // copy paste ra
        $datas[] = [
            'name' => 'Mẹ và bé',
            'slug' => 'me-va-be',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];
        $datas[] = [
            'name' => 'Balo & Vali',
            'slug' => 'balo-va-vali',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];
        $datas[] = [
            'name' => 'Thiết bị công nghệ',
            'slug' => 'thiet-bi-cong-nghe',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];

        $datas[] = [
            'name' => 'Chăm sóc thú cưng',
            'slug' => 'cham-soc-thu-cung',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];

        $datas[] = [
            'name' => 'Khuyến mãi HOT',
            'slug' => 'khuyen-mai-hot',
            'description' => $faker->paragraph(1),
            'status' => 1,
        ];

        foreach($datas as $data) {
            $node = new Category($data);
            $node->save(); // Saved as root // nó phải có cái này, để nó tính lt và rgt. mấy cái kia thì khỏi cần
        }

        // Danh mục con
        $parent = Category::find(3);
        $datas = [
            'Nồi cơm điện', 
            'Bếp hồng ngoại',
            'Nồi chiên không dầu',
            'Nồi áp suất',
            'Máy xay máy ép',
            'Nồi cơm điện 2',
            'Bình đun siêu tốc',
            'Máy làm sữa đậu nành',
            'Máy làm tỏi đen',
            'Lò nướng',
            'Lò vi sóng',
            'Bình đun siêu tốc 2',
        ];

        foreach($datas as $data) {
            $parent->children()->create([
                'name' => $data,
                'slug' => str_slug($data),
                'description' => $faker->paragraph(1),
                'status' => 1,
            ]);
        }
    }
}
