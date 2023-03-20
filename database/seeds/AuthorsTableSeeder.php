<?php

use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(RBooks\Models\Author::class, 20)->create();
    }
}
