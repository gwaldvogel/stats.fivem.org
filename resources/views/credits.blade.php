@extends('layout.coreui')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Credits</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">Credits</h4>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">
                                    <h6>CoreUI</h6>
                                </div>
                                <div class="col-sm-10">
                                    stats.fivem.org uses <a href="http://coreui.io/">CoreUI</a> as the basic template. CoreUI is available under the MIT license.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <h6>Logo</h6>
                                </div>
                                <div class="col-sm-10">
                                    <div>Logo made by <a href="http://www.flaticon.com/authors/vectors-market" title="Vectors Market">Vectors Market</a>, licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.card-->
        </div>
    </div>
@endsection