@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="mb-0 titulo">Dashboard</h1>
            @if ($gains - $spends > 0)
            <h5 style="color: #43a047;">{{ Auth::user()->name }}, seu saldo atual é R$ {{ number_format($gains - $spends, 2, ',', '.') }}</h5>
            @elseif ($gains - $spends < 0)
                <h5 style="color: #e53935;">{{ Auth::user()->name }}, seu saldo atual é R$ {{ number_format($gains - $spends, 2, ',', '.') }}</h5>
            @endif
        </div>
        <div class="divisor-underline mb-4"></div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="bg-card p-4">
                    <div class="d-flex justify-content align-items-center">
                        <h2>Ganhos</h2>
                        <small class="text-white"> (do Mês Atual)</small>
                    </div>
                    <p>Total: R$ {{ number_format($gains, 2, ',', '.') }}</p>
                    <a href="{{ route('gains.index') }}" class="btn btn-success">Ver Ganhos</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="bg-card p-4">
                    <div class="d-flex justify-content align-items-center">
                        <h2>Gastos</h2>
                        <small class="text-white"> (do Mês Atual)</small>
                    </div>                    
                    <p>Total: R$ {{ number_format($spends, 2, ',', '.') }}</p>
                    <a href="{{ route('spends.index') }}" class="btn btn-danger">Ver Gastos</a>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="bg-card p-4">
                    <h2 style="margin-bottom: 50px;">Relatórios de gastos por categoria</h2>
                    <div id="pie_chart" style="width: 100%; height: 600px; margin-top: -70px;"></div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawCategoriesChart);

        function drawCategoriesChart() {
            var data = google.visualization.arrayToDataTable(@json($categoriesChart));

            var options = {
                backgroundColor: 'transparent',
                pieHole: 0.4,
                    colors: @json($colors),
                legend: {
                    position: 'right',
                    textStyle: {
                        fontSize: 14,
                        color: '#fff',
                        fontName: 'Arial'
                    },
                    alignment: 'center'
                },
                chartArea: {
                    left: '5%',
                    top: '10%',
                    width: '95%',
                    height: '85%'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
            chart.draw(data, options);
        }
    </script>
@endsection

