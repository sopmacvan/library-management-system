@extends('layouts.app')

@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif
    <form action="/save-added-borrower" method="POST">
        @csrf
        <div class="container">
            Book Id:
            <div><input required type="number" name="book_id"></div>
            User Id
            <div><input required type="number" name="user_id"></div>
                <button class="btn btn-primary btn-lg" onclick="">Save</button>
            </div>
        </div>
    </form>

@endsection
