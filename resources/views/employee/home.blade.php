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
        var url = "{{ url('employee/getChartData') }}";
        var meeting_date = new Array();
        const labels = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',

        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Users meeting count',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [1, 10, 5, 2, 20, 30, 45],
            }]
        };

        const config = {
            type: 'line',
            data,
            options: {
                scales: {

                }
            }
        };
        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

    </script>
@endpush
