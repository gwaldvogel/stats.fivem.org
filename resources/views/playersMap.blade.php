@extends('layout.coreui')
@section('title')
    FiveM Servers by country
@endsection
@push('additionalHeadScripts')
<link rel="stylesheet" href="{{ url('/css/jqvmap.min.css') }}" />
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item">Geographical Statistics</li>
    <li class="breadcrumb-item active">Players by country</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-server"></i>Players by country<br>
                    </div>
                    <div class="card-block">
                        <div id="playerLocations" style="width: 100%; height: 800px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('additionalScripts')
<script src="{{ url('/js/jquery.vmap.js') }}"></script>
<script src="{{ url('/js/jquery.vmap.world.js') }}"></script>
@endpush
@push('additionalScripts')
<script>
    var g_apiData = {};
    $.get('{{ url('/api/players/byCountry') }}', function(apiData){
        g_apiData = apiData;
        jQuery('#playerLocations').vectorMap({
            map: 'world_en',
            scaleColors: ['#ffffff', '#20a8d8'],
            values: apiData,
            normalizeFunction: 'polynomial',
            showTooltip: true,
            backgroundColor: null,
            hoverColor: false,
            onLabelShow: function(event, label, code)
            {
                if(g_apiData[code] === undefined)
                    event.preventDefault();
                else
                    label.text(label.text() + ": " + g_apiData[code] + " Player(s)");
            },
            onRegionClick: function(event, code, region)
            {
                event.preventDefault();
            }
        });
    });
</script>
@endpush