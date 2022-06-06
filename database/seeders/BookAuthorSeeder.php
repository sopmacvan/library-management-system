<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_authors')->truncate();

        $books_count = Book::count();
        $author_count = Author::count();

        $i = 1;
        while ($i <= $author_count) {
//            assign book to every author
            BookAuthor::create([
                'book_id' => $i,
                'author_id' => $i
            ]);
            $i++;
        }
        while ($i <= $books_count) {
//            assign remaining book to random author
            BookAuthor::create([
                'book_id' => $i,
                'author_id' => rand(1, $author_count)
            ]);
            $i++;
        }
    }
}

