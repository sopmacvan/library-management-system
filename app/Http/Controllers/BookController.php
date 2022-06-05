<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function showBooks()
    {
        $books = DB::table('book_authors')
            ->join('books', 'book_authors.book_id', '=', 'books.id')
            ->join('authors', 'book_authors.author_id', '=', 'authors.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select(
                'books.id', 'books.title', 'books.publication_date', 'books.copies_owned', 'books.remaining_copies',
                'authors.first_name', 'authors.last_name',
                'categories.category_name')
            ->get();
//        dd($books);
        return view('user.books', compact('books'));
    }
}
