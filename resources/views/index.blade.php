@extends('layout.layout')
@section('content')
    <!-- Intro Section -->
    <section id="intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>FiveM Stats</h1>
                    <p>FiveM Stats collects usage data from the FiveM Master list and visualizes them. This website is not an official FiveM project.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="playerCountLastHour" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Player and server count in the last hour</h2>
                    <div id="playerCountLastH"></div>
                </div>
            </div>
        </div>
    </section>
    <section id="serverLocationsSection" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Servers by country</h2>
                    <div id="serverLocations" style="width: 100%; height: 80%;"></div>
                </div>
            </div>
        </div>
    </section>
    <section id="playerLocationsSection" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Players by country</h2>
                    <div id="playerLocations" style="width: 100%; height: 80%;"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('additionalScripts')
<script>
    var serverCountLastHour = {
        x: [
            @foreach($FiveMLastHour as $item)
            '{{ $item->updated_at }}',
            @endforeach
        ],
        y: [
            @foreach($FiveMLastHour as $item)
            '{{ $item->serverCount }}',
            @endforeach
        ],
        name: 'Servers',
        type: 'bar'
    };

    var playerCountLastHour = {
        x: [
            @foreach($FiveMLastHour as $item)
            '{{ $item->updated_at }}',
            @endforeach
        ],
        y: [
            @foreach($FiveMLastHour as $item)
            '{{ $item->playerCount }}',
            @endforeach
        ],
        name: 'Players',
        type: 'bar'
    };

    Plotly.plot(document.getElementById('playerCountLastH'), [serverCountLastHour, playerCountLastHour], {barmode: 'group'});
</script>
@endpush

@push('additionalScripts')
<script>
    var data = [{
        type: 'choropleth',
        locations:
            [@foreach($CountryStatsServer as $country)
                '{{ $country->countryCode }}',
                @endforeach],
        z: [@foreach($CountryStatsServer as $country)
            '{{ $country->value }}',
            @endforeach],
        text: [@foreach($CountryStatsServer as $country)
            '{{ $country->country }}',
            @endforeach],
        colorscale: [
            [0,'rgb(31, 119, 180)'],[0.5,'rgb(88,143,182)'],[0.95, 'rgb(156,182,200)'],[1,'rgb(255, 255, 255)'],],
        autocolorscale: false,
        reversescale: true,
        marker: {
            line: {
                color: 'rgb(180,180,180)',
                width: 0.5
            }
        },
        zmin: 0,
        colorbar: {
            autotic: true,
            title: 'Active FiveM servers'
        }
    }];

    var layout = {
        width: 1000,
        height: 1000,
        geo:{
            showframe: false,
            showcoastlines: true,
            projection:{
                type: 'mercator'
            }
        }
    };
    Plotly.plot(document.getElementById('serverLocations'), data, layout, {showLink: false});
</script>
@endpush

@push('additionalScripts')
<script>
    var data = [{
        type: 'choropleth',
        locations:
            [@foreach($CountryStatsPlayers as $country)
                '{{ $country->countryCode }}',
                @endforeach],
        z: [@foreach($CountryStatsPlayers as $country)
            '{{ $country->value }}',
            @endforeach],
        text: [@foreach($CountryStatsPlayers as $country)
            '{{ $country->country }}',
            @endforeach],
        colorscale: [
            [0,'rgb(255, 127, 14)'],[0.5,'rgb(255,185,124)'],[0.99, 'rgb(255,218,185)'],[1,'rgb(255, 255, 255)']],
        autocolorscale: false,
        reversescale: true,
        marker: {
            line: {
                color: 'rgb(180,180,180)',
                width: 0.5
            }
        },
        tick0: 0,
        zmin: 0,
        dtick: 1000,
        colorbar: {
            autotic: true,
            title: 'Active FiveM players'
        }
    }];

    var layout = {
        width: 1000,
        height: 1000,
        geo:{
            showframe: false,
            showcoastlines: true,
            projection:{
                type: 'mercator'
            }
        }
    };
    Plotly.plot(document.getElementById('playerLocations'), data, layout, {showLink: false});
</script>
@endpush
