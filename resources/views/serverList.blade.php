@extends('layout.coreui')
@section('title')
    FiveM Server list
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active">Server list</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-server"></i>Server list<br>
                        <small>This list is cached, it is not always up to date!</small>
                    </div>
                    <div class="card-block">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Server Name</th>
                                <th>Players online</th>
                                <th>IP adress</th>
                                <th>Last updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($servers as $server)
                                <tr>
                                    <td>@if(!empty($server['icon']))
                                            <img src="{{ url($server['icon']) }}" alt="" style="width: 48px; height: 48px;" />
                                        @endif</td>
                                    <td><a href="{{ url('/server/' . $server['id']) }}">{!!  $server['name'] !!}</a></td>
                                    <td>{{ $server['clients'] }}</td>
                                    <td><img src="{{ url('img/countries/'.$server['countryCode'].'.png') }}" alt="{{ $server['country'] }}" /> {{ $server['ipaddress'] }}</td>
                                    <td>{{ $server['lastUpdated'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $servers->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection