@extends('layout.layout')
@section('content')
    <!-- Intro Section -->
    <section id="intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>FiveM Stats</h1>
                    <p>FiveM Stats collects usage data from the FiveM Master list and visualizes them.</p>
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
            [0,'rgb(5, 10, 172)'],[0.35,'rgb(40, 60, 190)'],
            [0.5,'rgb(70, 100, 245)'], [0.6,'rgb(90, 120, 245)'],
            [0.7,'rgb(106, 137, 247)'],[1,'rgb(220, 220, 220)']],
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
            autotic: false,
            title: 'Active FiveM Players'
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
            [0,'rgb(5, 10, 172)'],[0.35,'rgb(40, 60, 190)'],
            [0.5,'rgb(70, 100, 245)'], [0.6,'rgb(90, 120, 245)'],
            [0.7,'rgb(106, 137, 247)'],[1,'rgb(220, 220, 220)']],
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
            autotic: false,
            title: 'Active FiveM Players'
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
