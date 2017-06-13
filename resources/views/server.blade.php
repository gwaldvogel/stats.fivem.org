@extends('layout.coreui')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ url('/serverlist') }}">Server list</a></li>
    <li class="breadcrumb-item active">{{ strlen($server->name) > 50 ? substr($server->name, 0, 47).'...' : $server->name }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card card-inverse card-primary">
                        <div class="card-block pb-0">
                            <div class="row">
                                <div>
                                    <div class="card float-left" style="margin: 0 10px;">
                                        <img src="{{ url('/server_icons/'.$server->icon) }}" alt="" style="height: 48px; margin: 10px;" />
                                    </div>
                                    <h4>{{ $server->name }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="chart-wrapper px-3" style="height:110px;">
                            <canvas id="card-player-chart" class="chart" height="70"></canvas>
                        </div>
                        <div class="card-footer p-x-1 p-y-h">
                            <span>Last updated: {{ $server->updated_at }}</span>
                            <span class="pull-right">Current players: {{ $server->clients }}/{{ $server->max_clients }}</span>
                        </div>
                    </div>
                </div>
                <!--/.col-->
            </div>
            <!--/.row-->
        </div>
    </div>
@endsection

@push('additionalScripts')
<script>
    $.get('{{ url('/api/server/history/' . \Vinkla\Hashids\Facades\Hashids::encode($server->id)) }}', function(data){
        $('#currentPlayerCount').html(data.playerCount[data.playerCount.length - 1]);
        let datetime = [];
        for(i = 0; i < data.datetime.length; ++i)
        {
            datetime.push(new Date(data.datetime[i]).toLocaleString());
        }
        chartData = {
            labels: datetime,
            datasets: [
                {
                    label: 'Players online',
                    backgroundColor: $.brandPrimary,
                    borderColor: 'rgba(255,255,255,.55)',
                    data: data.playerCount
                }
            ]
        };
        var options = {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent',
                    }

                }],
                yAxes: [{
                    display: false,
                    ticks: {
                        display: false,
                        min: Math.min.apply(Math, chartData.datasets[0].data) - 5,
                        max: Math.max.apply(Math, chartData.datasets[0].data) + 5,
                    }
                }],
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4,
                },
            }
        };
        var ctx = $('#card-player-chart');
        var cardPlayerChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: options
        });
    });
</script>
@endpush