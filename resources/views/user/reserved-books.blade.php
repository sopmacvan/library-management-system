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

                    <button id="cancel_btn">Cancel Reservation</button>
                    <table id="reserved_books_table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>book id</th>
                            <th>title</th>
                            <th>reservation date</th>
                            <th>status</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reserved_books as $book)
                            <tr>
                                <td>{{$book->id}}</td>
                                <td>{{$book->book_id}}</td>
                                <td>{{$book->title}}</td>
                                <td>{{$book->reservation_date}}</td>
                                <td>{{$book->status_value}}</td>
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
            var table = $('#reserved_books_table').DataTable({
                "scrollY": "450px",

            });

            $('#reserved_books_table tbody').on('click', 'tr', function () {
                //mark or unmark as selected, highlights row
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
            });

            $('#cancel_btn').click(function () {
                //get row data, you can access it like an array
                const row_data = table.row( '.selected' ).data();
                //redirect to /cancel-book-reservation/{id}
                window.location.href = `/cancel-book-reservation/${row_data[0]}`;
            });
        });
    </script>
@endsection
