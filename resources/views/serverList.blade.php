@extends('layout.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
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