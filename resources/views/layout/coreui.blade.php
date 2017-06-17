<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.6
 * @link http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="FiveM Stats collects usage data from the FiveM Master list and visualizes them">
    <meta name="keyword" content="GTA5,FiveM,Stats,Statistics,Servers,GTA5Multiplayer">
    <link rel="shortcut icon" href="{{ url('/img/favicon.png') }}">

    <title>@section('title')FiveM stats
    @show</title>

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />

    <!-- Icons -->
    <link href="{{ url('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/simple-line-icons.css') }}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    @section('jquery')
    <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
    @show

    @stack('additionalHeadScripts')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">☰</button>
    <a class="navbar-brand" href="#"></a>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item">
            <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
        </li>

        <li class="nav-item px-3">
            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ url('/serverlist') }}">Servers</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ url('/credits') }}">Credits</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <!--<li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"onclick="window.location.reload()"><i class="icon-refresh"></i></a>
        </li>-->
        @if(Auth::check())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ Auth::user()->avatar }}" class="img-avatar" alt="">
                    <span class="hidden-md-down">{{ Auth::user()->nickname }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ url('player/'.Auth::user()->steam_id) }}"><i class="fa fa-user"></i> My Profile</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="{{ url('/logout') }}" ><i class="icon-logout"></i></a>
            </li>
        @else
            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="{{ url('/login') }}"><i class="icon-login"></i></a>
            </li>
        @endif
    </ul>
</header>

<div class="app-body">
    <div class="sidebar">
        @section('sidebar')
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/dashboard') }}"><i class="icon-speedometer"></i> Dashboard</a>
                </li>

                <li class="nav-title">
                    Servers
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/serverlist') }}"><i class="icon-list"></i> Server list</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/search/server') }}"><i class="icon-magnifier"></i> Search server</a>
                </li>

                <li class="nav-title">
                    Players
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link" href="{{ url('/playerlist') }}"><i class="icon-people"></i> Player list</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link" href="{{ url('/search/player') }}"><i class="icon-magnifier"></i> Search players</a>
                </li>

                <li class="nav-title">
                    Geographical Statistics
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link" href="{{ url('/serversByCountry') }}"><i class="icon-game-controller"></i> Servers by country</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link" href="{{ url('/playersByCountry') }}"><i class="icon-people"></i> Players by country</a>
                </li>
            </ul>
        </nav>
        @show
    </div>

    <!-- Main content -->
    <main class="main">

        <!-- Breadcrumb -->
        <ol class="breadcrumb">

            <li class="breadcrumb-item">Home</li>
            @section('breadcrumbs')
            <li class="breadcrumb-item active">...</li>
            @show

            <!-- Breadcrumb Menu-->
            <!--<li class="breadcrumb-menu d-md-down-none">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <a class="btn btn-secondary" href="#"><i class="icon-speech"></i></a>
                    <a class="btn btn-secondary" href="./"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                    <a class="btn btn-secondary" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
                </div>
            </li>-->
        </ol>
        @include('shared.alerts')
        @section('content')
        Not yet implemented.
        @show
        <!-- /.conainer-fluid -->
    </main>
</div>

<footer class="app-footer">
    Version:  1.0.0-alpha-{{ env('GIT_SHORTHASH') }}
    <span class="float-right"> Powered by <a href="http://coreui.io">CoreUI</a></span>
</footer>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-100448168-1', 'auto');
    ga('send', 'pageview');

</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#eaf7f7",
                    "text": "#5c7291"
                },
                "button": {
                    "background": "#56cbdb",
                    "text": "#ffffff"
                }
            },
            "theme": "edgeless"
        })});
</script>

<!-- Bootstrap and necessary plugins -->
<script src="{{ url('bower_components/tether/dist/js/tether.min.js') }}"></script>
<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('bower_components/pace/pace.min.js') }}"></script>

<!-- Plugins and scripts required by all views -->
<script src="{{ url('bower_components/chart.js/dist/Chart.min.js') }}"></script>

<!-- GenesisUI main scripts -->
<script src="{{ url('js/app.js') }}"></script>

<!-- DateTime conversion -->
<script>
    $('.iso6081-datetime').each(function() {
        $(this).html(new Date($(this).html()).toLocaleString());
    });
</script>

@stack('additionalScripts')

</body>

</html>