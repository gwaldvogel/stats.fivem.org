@extends('layout.coreui')
@section('breadcrumbs')
    <li class="breadcrumb-item">Servers</li>
    <li class="breadcrumb-item active">Search servers</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">Search servers</h4>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" action="{{ url('/search/server') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-control-label" for="appendedInputButtons">Enter the IP address or the Server name</label>
                                    <div class="controls">
                                        <div class="input-group">
                                            <input id="appendedInputButtons" size="16" class="form-control" type="text" name="search">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default" type="button">Search</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.card-->
            @if(isset($servers))
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
                                        <th></th>
                                        <th>Name</th>
                                        <th>Steam64 ID</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($servers as $server)
                                        <tr>
                                            <td>
                                                @if($server->icon)<img src="{{ url('server_icons/'.$server->icon) }}" alt="{{ $server->name }}" style="width: 32px;" />
                                                @endif
                                            </td>
                                            <td><a href="{{ url('/server/'.\Vinkla\Hashids\Facades\Hashids::encode($server->id)) }}">{{ $server->name }}</a></td>
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