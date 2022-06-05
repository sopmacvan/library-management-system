@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Books Page</div>

                    {{--                <div class="panel-body">--}}
                    {{--                    This is Books Page--}}
                    {{--                </div>--}}
                    <table id="books_table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>title</th>
                            <th>author</th>
                            <th>category</th>
                            <th>publication date</th>
                            <th>copies owned</th>
                            <th>remaining copies</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td>{{$book->id}}</td>
                                <td>{{$book->title}}</td>
                                <td>{{$book->first_name.' '.$book->last_name}}</td>
                                <td>{{$book->category_name}}</td>
                                <td>{{$book->publication_date}}</td>
                                <td>{{$book->copies_owned}}</td>
                                <td>{{$book->remaining_copies}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#books_table').DataTable();
        });
    </script>
@endsection
