<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BooksSeeder extends Seeder
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
        $category_count = Category::count();
        $author_count = Author::count();
        for ($book_id=1; $book_id<70; $book_id++) {
            $category_id = rand(1,$category_count);
            $author_id = rand(1,$author_count);

            Book::create([
                'title' => $faker->sentence,
                'description' => $faker->text,
                'publication_date' => $faker->dateTimeBetween('-30 years','now'),
                'copies_owned' => 3,
                'remaining_copies' => 3,
                'category_id' => $category_id
            ]);

            BookAuthor::create([
                'book_id' => $book_id,
                'author_id' => $author_id
            ]);

        }
    }
}
