@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" id="BT">Transaction History</div>

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


                    <table id="transaction-history-table">
                        <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Loan Date</th>
                            <th>Expected Return Date</th>
                            <th>Return Date</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->book_id}}</td>
                                <td>{{$transaction->title}}</td>
                                <td>{{$transaction->user_id}}</td>
                                <td>{{$transaction->name}}</td>
                                <td>{{$transaction->email}}</td>
                                <td>{{$transaction->loan_date}}</td>
                                <td>{{$transaction->expected_return_date}}</td>
                                <td>{{$transaction->returned_date}}</td>
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
            var table = $('#transaction-history-table').DataTable({
                "scrollY": "450px",

            });
            $('#transaction-history-table tbody').on('click', 'tr', function () {
                //mark or unmark as selected, highlights row
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');

                }
            });

            $('#add-borrower-btn').click(function () {
                const id = book_id;
                window.location.href=`/add-borrower/{id}`;
                // //get row data, you can access it like an array
                // const row_data = table.row( '.selected' ).data();
                // window.location.href = `/cancel-book-reservation/${row_data[0]}`;
            });


            // $('#reserved_books_table tbody').on('click', 'tr', function () {
            //     //mark or unmark as selected, highlights row
            //     if ($(this).hasClass('selected')) {
            //         $(this).removeClass('selected');
            //     } else {
            //         table.$('tr.selected').removeClass('selected');
            //         $(this).addClass('selected');

            //     }
            // });


        });
    </script>
@endsection
