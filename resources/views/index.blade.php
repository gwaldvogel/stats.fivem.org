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

