@extends('layout.coreui')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-inverse card-primary">
                        <div class="card-block pb-0">
                            <h4 class="mb-0">{{ $userCount }}</h4>
                            <p>Unique players in the database</p>
                        </div>
                    </div>
                </div>
                <!--/.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-inverse card-primary">
                        <div class="card-block pb-0">
                            <h4 class="mb-0">{{ $playerRecords }}</h4>
                            <p>Player records in the database</p>
                        </div>
                    </div>
                </div>
                <!--/.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-inverse card-info">
                        <div class="card-block pb-0">
                            <h4 class="mb-0">{{ $serverCount }}</h4>
                            <p>Unique servers in the database</p>
                        </div>
                    </div>
                </div>
                <!--/.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-inverse card-info">
                        <div class="card-block pb-0">
                            <h4 class="mb-0">{{ $serverHistoryRecords }}</h4>
                            <p>Server history records in the database</p>
                        </div>
                    </div>
                </div>
                <!--/.col-->
            </div>
            <!--/.row-->
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="card card-inverse card-primary">
                        <div class="card-block pb-0">
                            <h4 class="mb-0" id="currentPlayerCount"></h4>
                            <p>Players online in the last hour</p>
                        </div>
                        <div class="chart-wrapper px-3" style="height:90px;">
                            <canvas id="card-player-chart" class="chart" height="90"></canvas>
                        </div>
                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-6 col-lg-6">
                    <div class="card card-inverse card-info">
                        <div class="card-block pb-0">
                            <h4 class="mb-0" id="currentServerCount"></h4>
                            <p>Servers online in the last hour</p>
                        </div>
                        <div class="chart-wrapper px-3" style="height:90px;">
                            <canvas id="card-server-chart" class="chart" height="90"></canvas>
                        </div>
                    </div>
                </div>
                <!--/.col-->
            </div>
            <!--/.row-->

            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">Activity</h4>
                            <div class="small text-muted">In the last 24 hours</div>
                        </div>
                    </div>
                    <!--/.row-->
                    <div class="chart-wrapper" style="height:300px;margin-top:40px;">
                        <canvas id="24h-chart" class="chart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <!--/.card-->
        </div>
    </div>
@endsection

@push('additionalScripts')
<script>
    function convertHex(hex,opacity){
        hex = hex.replace('#','');
        var r = parseInt(hex.substring(0,2), 16);
        var g = parseInt(hex.substring(2,4), 16);
        var b = parseInt(hex.substring(4,6), 16);

        var result = 'rgba('+r+','+g+','+b+','+opacity/100+')';
        return result;
    }
</script>
@endpush

@push('additionalScripts')
<script>
    $.get('{{ url('/api/players/since/60') }}', function(data){
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
            tooltip: {
                caretSize: 0
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

@push('additionalScripts')
<script>
    $.get('{{ url('/api/servers/since/60') }}', function(data){
        $('#currentServerCount').html(data.serverCount[data.serverCount.length - 1]);
        let datetime = [];
        for(i = 0; i < data.datetime.length; ++i)
        {
            datetime.push(new Date(data.datetime[i]).toLocaleString());
        }
        chartData = {
            labels: datetime,
            datasets: [
                {
                    label: 'Servers online',
                    backgroundColor: $.brandInfo,
                    borderColor: 'rgba(255,255,255,.55)',
                    data: data.serverCount
                }
            ]
        };
        var options = {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltip: {
                caretSize: 0
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
        var ctx = $('#card-server-chart');
        var cardPlayerChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: options
        });
    });
</script>
@endpush


@push('additionalScripts')
<script>
    $.get('{{ url('/api/serversAndPlayers/since/24') }}', function(data){
        let datetime = [];
        for(i = 0; i < data.datetime.length; ++i)
        {
            datetime.push(new Date(data.datetime[i]).toLocaleString());
        }
        chartData = {
            labels: datetime,
            datasets: [
                {
                    label: 'Servers online',
                    backgroundColor: 'transparent',
                    borderColor: $.brandPrimary,
                    data: data.serverCount
                },
                {
                    label: 'Players online',
                    backgroundColor: 'transparent',
                    borderColor: $.brandSuccess,
                    data: data.playerCount
                }
            ]
        };
        var options = {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltip: {
                caretSize: 0
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        drawOnChartArea: false,
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        maxTicksLimit: 5
                    }
                }]
            },
            elements: {
                point: {
                    radius: 2,
                    hitRadius: 10,
                    hoverRadius: 4,
                    hoverBorderWidth: 3,
                },
            }
        };
        var ctx = $('#24h-chart');
        var cardPlayerChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: options
        });
    });
</script>
@endpush