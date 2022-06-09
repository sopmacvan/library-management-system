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
                    @if (Session::has('activated'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('activated') }}
                        </div>
                    @endif

                    @if (Session::has('deactivated'))
                        <div class="alert alert-primary" role="alert">
                            {{ Session::get('deactivated') }}
                        </div>
                    @endif

                    <button id="activate_btn">Activate/Deactivate</button>
                    <table id="reserved_books_table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>email</th>
                            <th>created at</th>
                            <th>updated at</th>
                            <th>status</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>{{$user->updated_at}}</td>
                                <td>{{$user->status_value}}</td>
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

            $('#activate_btn').click(function () {
                //get row data, you can access it like an array
                const row_data = table.row( '.selected' ).data();
                window.location.href = `/change-user-status/${row_data[0]}`;
            });
        });
    </script>
@endsection
