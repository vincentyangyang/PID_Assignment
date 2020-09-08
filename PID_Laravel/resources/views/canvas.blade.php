@extends('layouts.master_canvas')

@section('title','銷售數據')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    
    <div class="col-10" style="margin-top: 30px;">
        <canvas id="myChart"></canvas>
    </div>
@endsection

@section('script')
    $('.canvas').addClass("active");

    var labels = [];
    var data = [];
    @forelse($data as $row)
        labels.push("{{  $row['name'] }}");
        data.push("{{  ($row['quantity'] == '') ? 0:$row['quantity'] }}");
    @empty
    @endforelse

    var ctx = $('#myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,

            datasets: [
            {    
                type: 'bar',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 1,
                label: '銷售量',
                data: data
            }]
    
        }
    });
@endsection