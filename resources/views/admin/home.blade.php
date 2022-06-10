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
                        <div id="books_pi" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            // var data = google.visualization.arrayToDataTable([
            //     ['Task', 'Hours per Day'],
            //     ['Work', 11],
            //     ['Eat', 2],
            //     ['Commute', 2],
            //     ['Watch TV', 2],
            //     ['Sleep', 7]
            // ]);

            var data = [];
            @@foreach()
                @@endforeach

            var options = {
                title: 'Books'
            };

            var chart = new google.visualization.PieChart(document.getElementById('books_pi'));

            chart.draw(data, options);
        }
    </script>
@endsection
