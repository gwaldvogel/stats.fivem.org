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
    <link rel="shortcut icon" href="img/favicon.png">

    <title>@section('title')FiveM stats
    @show</title>

    <!-- Icons -->
    <link href="{{ url('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/simple-line-icons.css') }}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>

    @stack('additionalHeadScripts')
</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
5. '.sidebar-compact'			  - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Footer options
1. '.footer-fixed'						- Fixed footer

-->

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
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"onclick="window.location.reload()"><i class="icon-refresh"></i></a>
        </li>
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

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/serverlist') }}"><i class="icon-list"></i> Server list</a>
                </li>

                <!--<li class="nav-title">
                    Geographical Statistics
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link" href="{{ url('/serversByCountry') }}"><i class="icon-game-controller"></i> Servers by country</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link" href="{{ url('/playersByCountyr') }}"><i class="icon-people"></i> Players by country</a>
                </li>-->
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

<!-- Bootstrap and necessary plugins -->
<script src="{{ url('bower_components/tether/dist/js/tether.min.js') }}"></script>
<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('bower_components/pace/pace.min.js') }}"></script>

<!-- Plugins and scripts required by all views -->
<script src="{{ url('bower_components/chart.js/dist/Chart.min.js') }}"></script>

<!-- GenesisUI main scripts -->
<script src="{{ url('js/app.js') }}"></script>

@stack('additionalScripts')

</body>

</html>