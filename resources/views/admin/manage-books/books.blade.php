@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    {{--                    <div class="panel-heading">Books Page</div>--}}

                    {{--                <div class="panel-body">--}}
                    {{--                    This is Books Page--}}
                    {{--                </div>--}}
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

                    <button id="create_btn">Create New</button>
                    <button id="edit_btn">Edit</button>
                    <button id="delete_btn">Delete</button>
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
            //apply datatables stuffs (search engine, pages, limit)
            var table = $('#books_table').DataTable({
                "scrollY": "450px",

            });

            $('#books_table tbody').on('click', 'tr', function () {
                //mark or unmark as selected, highlights row
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
            });

            $('#create_btn').click(function () {
                window.location.href = `/create-book`;
            });
            $('#edit_btn').click(function () {
                //get row data, you can access it like an array
                const row_data = table.row('.selected').data();
                window.location.href = `/edit-book/${row_data[0]}`;
            });
            $('#delete_btn').click(function () {
                //get row data, you can access it like an array
                const row_data = table.row('.selected').data();
                window.location.href = `/create-book-reservation/${row_data[0]}`;
            });
        });
    </script>
@endsection
