<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->truncate();

        $faker = \Faker\Factory::create();
        for ($i=0; $i<100; $i++) {
            Book::create([
                'title' => $faker->sentence,
                'description' => $faker->text,
                'publication_date' => $faker->dateTimeBetween('-30 years','now'),
                'copies_owned' => 3,
                'category_id' => 1
            ]);
        }
    }
}
