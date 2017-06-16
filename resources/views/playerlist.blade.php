@extends('layout.coreui')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Credits</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            @if(isset($users))
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-5">
                                <h4 class="card-title mb-0">Search results</h4>
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
                                        <th>Steam64 ID</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td><img src="{{ $user->avatar }}" alt="{{ $user->nickname }}" /></td>
                                            <td><a href="{{ url('/player/'.$user->steam_id) }}">{{ $user->nickname }}</a></td>
                                            <td><a href="{{ url('/player/'.$user->steam_id) }}">{{ $user->steam_id }}</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links('vendor.pagination.simple-bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.card-->
            @endif
        </div>
    </div>
@endsection