@extends('layout.coreui')
@section('title')
    FiveM Servers by country
@endsection
@push('additionalHeadScripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css" />
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item">Geographical Statistics</li>
    <li class="breadcrumb-item active">Servers by country</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-server"></i>Servers by country<br>
                    </div>
                    <div class="card-block">
                        <div id="serverLocations" style="width: 100%; height: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('additionalScripts')
<script src="{{ url('/js/jquery-jvectormap-2.0.3.min.js') }}"></script>
<script src="{{ url('/js/jquery-jvectormap-world-mill.js') }}"></script>
@endpush
@push('additionalScripts')
<script>
    $.get('{{ url('/api/servers/byCountry') }}', function(apiData){
        jQuery('#serversLocations').vectorMap({
            map: 'world_mill',
            series: {
                regions: [{
                    scale: ['#ffff00', '#ff0000'],
                    values: apiData,
                    normalizeFunction: 'polynomial'
                }]
            }
        });
    });
</script>
@endpush