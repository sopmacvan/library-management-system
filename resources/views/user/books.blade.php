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

                    <button id="reserve_btn">Reserve Book</button>
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
            var table = $('#books_table').DataTable();

            $('#books_table tbody').on('click', 'tr', function () {
                //mark or unmark as selected, highlights row
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
            });

            $('#reserve_btn').click(function () {
                //get row data, you can access it like an array
                const row_data = table.row( '.selected' ).data();
                //redirect to /reserve-book/book_id
                window.location.href = `/reserve-book/${row_data[0]}`;
            });
        });
    </script>
@endsection
