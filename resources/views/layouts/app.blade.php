<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MiArpro') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/favicon.ico') }}">
  </head>
  <body class="app sidebar-mini">
  <div id="app">
  @guest 
  
  @else
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="/">
      <img src="img/emi5.png" alt="" style="width: 200px; "></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
       
            <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href=""><i class="bi bi-gear me-2 fs-5"></i> {{ Auth::user()->name }}</a></li>
            <li><a class="dropdown-item" href=""><i class="bi bi-person me-2 fs-5"></i> Perfil</a></li>
            <li><a class="dropdown-item" href=""
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i> {{ __('Salir') }}</a>
                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
            </li>
          </ul>
        </li>
        </ul>
    </header>
    <li>  
    

    <!-- Sidebar menu-->
    @include('plantilla.sidebar')
    @endguest 
    @yield('content')
    </div>
    
    <!-- Essential javascripts for application to work--> 
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script src="{{ asset('js/main.js') }}" defer></script> 
    
    <!-- Page specific javascripts-->
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css">
    <!-- Data table plugin-->
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}" defer></script>
    @yield('scripts')
    <!--The javascript plugin to display page loading on top-->
    <script src="{{ asset('js/plugins/pace.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
  
  </body>
