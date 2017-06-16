@extends('layout.coreui')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Credits</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-inverse card-primary">
                        <div class="card-block p-b-0">
                            <div class="row">
                                <div class="col-sm-1">
                                    <img src="{{ str_replace('.jpg', '_full.jpg', $user->avatar) }}" alt="{{ $user->nickname }}" style="width: 100%;" />
                                </div>
                                <div class="col-sm-10">
                                    <h3>{{ $user->nickname }}</h3>
                                    <p>Last seen: <span class="iso6081-datetime">{{ isset($latest->updated_at) ? $latest->updated_at->toIso8601String() : $user->updated_at->toIso8601String() }}</span></p>
                                    <p>Average Ping: {{ $avgPing }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user() && $user->id == Auth::user()->id)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-5">
                                <h4 class="card-title mb-0">Options</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Profile visiblity:
                                    </td>
                                    <td>{{ $user->hidden ? 'Hidden' : 'Visible' }}</td>
                                    <td><a href="{{ url('/player/'.$user->steam_id.'/toggle') }}">Toggle visibility</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            @endif
            @if(isset($servers))
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">Servers</h4>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 32px;"></th>
                                    <th>Name</th>
                                    <th>Average Ping</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($servers as $server)
                                    <tr>
                                        <td>
                                            @if($server['icon'])<img src="{{ url('server_icons/'.$server['icon']) }}" alt="{{ $server['name'] }}" style="height: 32px" />
                                            @endif
                                        </td>
                                        <td>{{ $server['name'] }}</td>
                                        <td>{{ $server['avgPing'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!--/.card-->
            @endif
        </div>
    </div>
@endsection