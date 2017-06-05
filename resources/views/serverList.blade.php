@extends('layout.layout')
@section('title')
    FiveM Server list
@endsection
@section('content')
    <div class="row" style="padding: 20px;">
        <div class="col-lg-12">
            <p>Please note: This list is cached, it is not always up to date, for an (almost) always up to date list go to: <a href="https://servers.fivem.net/" target="_blank">servers.fivem.net</a><br>This website is not an official FiveM project.</p>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Server Name</th>
                        <th>IP adress</th>
                        <th>Last updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servers as $server)
                        <tr>
                            <td>{{ $server['name'] }}</td>
                            <td>{{ $server['ipaddress'] }}</td>
                            <td>{{ $server['lastUpdated'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection