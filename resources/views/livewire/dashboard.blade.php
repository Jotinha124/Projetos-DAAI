@extends('layouts.master')
@section('titulo')
    Dashboard
@endsection
@section('css')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });

        google.charts.setOnLoadCallback(drawAllCharts);

        function drawAllCharts() {
            drawAreaChart();
            drawBarChart();
        }

        function drawAreaChart() {
            var data = google.visualization.arrayToDataTable(@json($dados));

            var options = {
                title: 'Orçamento dos Projetos por Mês',
                hAxis: {
                    title: 'Mês',
                    titleTextStyle: {
                        color: '#333'
                    }
                },
                vAxis: {
                    minValue: 0
                },
                areaOpacity: 0.4,
                colors: ['#1b9e77']
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        function drawBarChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {
                    role: "style"
                }],
                ["Copper", 8.94, "#b87333"],
                ["Silver", 10.49, "silver"],
                ["Gold", 19.30, "gold"],
                ["Platinum", 21.45, "color: #e5e4e2"]
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                title: "Density of Precious Metals, in g/cm^3",
                width: 600,
                height: 400,
                bar: {
                    groupWidth: "95%"
                },
                legend: {
                    position: "none"
                },
            };

            var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
            chart.draw(view, options);
        }
    </script>
@endsection
@section('content')
    <div>
        <h3>Olá {{ Session::get('s_nome') }}, {{ Session::get('s_tipo_utilizador') }}</h3>
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-2">Quantidade de Projetos</h6>
                            <h2 class="fw-bold mb-0 text-primary">
                                {{ $numProjetos }}
                            </h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-folder-fill text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-2">Outro Indicador</h6>
                            <h2 class="fw-bold mb-0 text-success">
                                0
                            </h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-graph-up text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
            <div class="row mb-4">
                <div class="col-6">
                    <div id="chart_div" style="width: 100%; height: 500px;"></div>
                </div>
                <div class="col-6">
                    <div id="barchart_values" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        @else
            <h3>Seus Projetos:</h3>
            @forelse($projetos as $item)
                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-semibold">{{ $item->projeto }}</h6>
                            <small class="text-muted">
                                Criado em {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </small>
                        </div>

                        <div>
                            <a href="{{ route('projetos.ver', ['id' => Crypt::encrypt($item->id)]) }}"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                Ver Projeto
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-light text-center rounded-4 shadow-sm">
                    <i class="bi bi-folder-x fs-4 d-block mb-2 text-muted"></i>
                    Nenhum projeto encontrado.
                </div>
            @endforelse
        @endif
    </div>
@endsection
