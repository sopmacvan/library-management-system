@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" id="BT">Borrowed Books</div>

                    {{--                    <div class="panel-heading">Borrowed Books Page</div>--}}

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

                    <table id="borrowed_books_table">
                        <thead>
                        <tr>
                            <th>Book Id</th>
                            <th>Title</th>
                            <th>Loan Date</th>
                            <th>Expected Return Date</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($borrowed_books as $book)
                            <tr>
                                <td>{{$book->book_id}}</td>
                                <td>{{$book->title}}</td>
                                <td>{{$book->loan_date}}</td>
                                <td>{{$book->expected_return_date}}</td>
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
            var table = $('#borrowed_books_table').DataTable({
                "scrollY": "450px",

            });

            $('#borrowed_books_table tbody').on('click', 'tr', function () {
                //mark or unmark as selected, highlights row
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
            });

        });
    </script>
@endsection
