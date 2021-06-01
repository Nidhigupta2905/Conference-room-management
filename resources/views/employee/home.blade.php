@extends('layouts.employee.app')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <canvas id="myChart"></canvas>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',

        ];


        // const data = {
        //     labels: labels,
        //     datasets: [{
        //         label: 'Users meeting count',
        //         backgroundColor: 'rgb(255, 99, 132)',
        //         borderColor: 'rgb(255, 99, 132)',
        //         data: [0, 10, 5, 2, 20, 30, 45],
        //     }]
        // };

        // const config = {
        //     type: 'line',
        //     data,
        //     options: {}
        // };
        // var myChart = new Chart(
        //     document.getElementById('myChart'),
        //     config
        // );

        $(document).ready(function() {
            var url = "{{ url('getChartData') }}";
            var meeting_date = new Array();

            $.get(url, function(response) {
                    response.forEach(function(data) {
                        meeting_date.push(data.chartData)
                    });

                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: [{
                                label: 'Users meeting count',
                                data: meeting_date,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }

                    });
            });
        });

    </script>
@endpush
