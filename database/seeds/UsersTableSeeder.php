<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
		DB::table('users')->truncate();

		DB::table('users')->insert([
			'name' => 'Duy Nguyen',
			'email' => 'duy@rbooks.vn',
			'password' => bcrypt('123456'),
		]);

		DB::table('users')->insert([
			'name' => 'Van Nhat',
			'email' => 'nhat@rbooks.vn',
			'password' => bcrypt('123456'),
		]);

		DB::table('users')->insert([
			'name' => 'Chau Pham',
			'email' => 'chauptn@rbooks.vn',
			'password' => bcrypt('123456'),
		]);
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}
}
