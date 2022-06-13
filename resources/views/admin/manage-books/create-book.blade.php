@extends('layouts.app')

@section('content')
    <form action="/save-created-book" method="POST">
        @csrf
        <div class="container">
            Book Title:
            <div><input required type="text" name="title"></div>
            Author's First Name:
            <div><input required type="text" name="author_fname"></div>
            Author's Last Name:
            <div><input required type="text" name="author_lname"></div>
            Category:
            <select required class="form-select" aria-label="Default select example" name="category">
                @foreach($categories as $category)
                    <option value={{$category->id}}>{{$category->category_name}}</option>
                @endforeach
            </select>
            Publication Date:
            <div><input required type="date" name="publication_date"></div>
            Copies Owned:
            <div><input required type="number" name="copies_owned"></div>
            <div>
                <button class="btn btn-primary btn-lg" onclick="">Save</button>
            </div>
        </div>
    </form>

@endsection
