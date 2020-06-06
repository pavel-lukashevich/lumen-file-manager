<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = \Carbon\Carbon::now();

        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'name' => 'category' . $i,
                'created_at' => $date,
                'updated_at' => $date
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
