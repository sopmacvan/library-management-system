@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <div class="panel-heading">User Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        This is User Dashboard. Welcome !
                        <div id="most_borrowed_bar" style="width: 900px; height: 500px;"></div>
                        <div id="book_categories_pi" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.load('current', {'packages': ['bar']});
        google.charts.setOnLoadCallback(drawCategoriesChart);
        google.charts.setOnLoadCallback(drawMostBorrowedChart);

        function drawCategoriesChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Categories');
            data.addColumn('number', 'Total');
            data.addRows([
                    @foreach($categories as $category)
                ["{{ $category->category_name }}", {{ $category->total }}],
                @endforeach
            ]);


            // Set chart options
            var options = {
                'title': 'Book Categories',
                // 'width': 400,
                // 'height': 300
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('book_categories_pi'));
            chart.draw(data, options);
        }

        function drawMostBorrowedChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Book Title');
            data.addColumn('number', 'Borrow Count');
            data.addRows([
                    @foreach($borrowed_books as $book)
                ["{{ $book->id . ' : ' . $book->title }}", {{ $book->total }}],
                @endforeach
            ]);

            // var data = google.visualization.arrayToDataTable([
            //     ['Book', 'Borrow Count'],
            //     ['Copper', 8.94],            // RGB value
            //     ['Silver', 10.49],            // English color name
            //     ['Gold', 19.30],
            //
            //     ['Platinum', 21.45], // CSS-style declaration
            // ]);

            var options = {
                chart: {
                    title: 'Most Borrowed Books',
                    // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                    vAxis: {
                        format: '#,###',
                        minValue: 0
                    }
                }
            };

            var chart = new google.charts.Bar(document.getElementById('most_borrowed_bar'));

            chart.draw(data, google.charts.Bar.convertOptions(options));

        }
    </script>
@endsection
