<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$data = [];
		
		$data[] = [
			'code' => 'ALPHA',
			'name' => 'Công ty cổ phần Sách Alpha',
			'slug' => 'cong-ty-co-phan-sach-alpha',
			'address' => '176 Thái Hà, Đống Đa, Hà Nội',
			'phone' => '0932329959',
			'email' => 'info@alphabooks.vn',
			'discount' => '0',
			'updated_user_id' => '1'
		];

		$data[] = [
			'code' => 'BACHVIET',
			'name' => 'CÔNG TY CỔ PHẦN SÁCH BÁCH VIỆT - BACHVIETBOOKS JSC',
			'slug' => 'cong-ty-co-phan-sach-bachviet-bachvietbooks-jsc',
			'address' => '146 Hoa Lan, P.2, Q. Phú Nhuận, Tp. Hồ Chí Minh',
			'phone' => '0835171788',
			'email' => 'info@bachvietbooks.vn',
			'discount' => '0',
			'updated_user_id' => '2'
		];

		$data[] = [
			'code' => 'THAIHA',
			'name' => 'Công ty Cổ phần Sách Thái Hà (Thai Ha Books JSC)',
			'slug' => 'cong-ty-co-phan-sach-thai-ha',
			'address' => 'Đường sách Nguyễn Văn Bình, Bến Nghé, Q.1, TP HCM',
			'phone' => '0838223340',
			'email' => 'info@thaihabooks.com',
			'discount' => '0',
			'updated_user_id' => '1'
		];

		$data[] = [
			'code' => 'QUANG VAN',
			'name' => 'Công ty Cổ phần Sách Quảng Văn(Quang Van Books JSC)',
			'slug' => 'cong-ty-co-phan-sach-quang-van',
			'address' => 'Đường sách Nguyễn Văn Bình, Bến Nghé, Q.1, TP HCM',
			'phone' => '0838223340',
			'email' => 'info@quangvanbooks.com',
			'discount' => '0',
			'updated_user_id' => '2'
		];

		DB::table('suppliers')->insert($data);
	}
}
