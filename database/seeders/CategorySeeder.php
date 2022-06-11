<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        $categories = array('Other','Education', 'Business and Economics', 'Mathematics', 'Medical', ' Psychology', 'Science');
        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category
            ]);
        }
    }
}
