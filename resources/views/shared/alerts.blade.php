@if(Session::has('alert-success'))
    <div class="container-fluid">
        <div class="alert alert-success" role="alert">
            {{ Session::get('alert-success') }}
        </div>
    </div>
@endif
@if(Session::has('alert-info'))
    <div class="container-fluid">
        <div class="alert alert-info" role="alert">
            {{ Session::get('alert-info') }}
        </div>
    </div>
@endif
@if(Session::has('alert-warning'))
    <div class="container-fluid">
        <div class="alert alert-warning" role="alert">
            {{ Session::get('alert-warning') }}
        </div>
    </div>
@endif
@if(Session::has('alert-danger'))
    <div class="container-fluid">
        <div class="alert alert-danger" role="alert">
            {{ Session::get('alert-danger') }}
        </div>
    </div>
@endif