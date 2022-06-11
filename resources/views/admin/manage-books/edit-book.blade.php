@extends('layouts.app')

@section('content')
    <form action="/save-edited-book" method="POST">
        @csrf
        <div class="container">
            <input type="hidden" value="{{$book->id}}" name="id">
            Book Title:
            <div><input required type="text" value="{{$book->title}}" name="title"></div>
            Author's First Name:
            <div><input required type="text" value="{{$book->first_name}}" name="author_fname"></div>
            Author's Last Name:
            <div><input required type="text" value="{{$book->last_name}}" name="author_lname"></div>
            Category:
            <select required class="form-select" aria-label="Default select example" name="category">
                @foreach($categories as $category)
                    <option value={{$category->id}}>{{$category->category_name}}</option>
                @endforeach
            </select>
            Publication Date:
            <div><input required type="date" value="{{$book->publication_date}}" name="publication_date"></div>
            Copies Owned:
            <div><input required type="number" value="{{$book->copies_owned}}" name="copies_owned"></div>
            <div>
                <button class="btn btn-primary btn-lg" onclick="">Save</button>
            </div>
        </div>
    </form>

@endsection
