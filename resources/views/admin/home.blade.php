@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Admin Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        This is Admin Dashboard. Welcome !
                        <div id="book_copies_pi" style="width: 900px; height: 500px;"></div>
                        <div id="user_accounts_pi" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawBookCopiesChart);
        google.charts.setOnLoadCallback(drawUserAccountsChart);

        function drawBookCopiesChart() {

            // var data = google.visualization.arrayToDataTable([
            //     ['Task', 'Hours per Day'],
            //     ['Work', 11],
            //     ['Eat', 2],
            //     ['Commute', 2],
            //     ['Watch TV', 2],
            //     ['Sleep', 7]
            // ]);
            var data = google.visualization.arrayToDataTable([
                ['Book Copies', 'Total'],
                ["Borrowed", {{$borrowed_copies}}],
                ["Reserved", {{$reserved_copies}}],
                ["Remaining", {{$remaining_copies}}],
            ]);

            var options = {
                title: 'Book Copies',
                // 'width': 400,
                // 'height': 300,

            };

            var chart = new google.visualization.PieChart(document.getElementById('book_copies_pi'));

            chart.draw(data, options);
        }

        function drawUserAccountsChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Status');
            data.addColumn('number', 'Total');
            data.addRows([
                    @foreach($user_accounts as $account)
                ["{{ $account->status_value }}", {{ $account->total }}],
                @endforeach
            ]);

            // Set chart options
            var options = {
                'title': 'User Accounts',
                // 'width': 400,
                // 'height': 300
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('user_accounts_pi'));
            chart.draw(data, options);
        }
    </script>
@endsection
