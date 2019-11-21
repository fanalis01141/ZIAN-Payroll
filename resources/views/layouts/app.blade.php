<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'ZIAN') }}</title> --}}
    <title>ZIAN PAYROLL</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/jquery.timepicker.min.css')}}">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


</head>
<body class="raleway bodygrad">

    <div id="app">

        <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark ">
            <div class="container">
                @auth
                    @if (Auth::user()->priority == 'HI')
                        <a class="navbar-brand" href="{{ url('/homedashboard') }}">
                            ZIAN
                        </a>
                    @else
                        <a class="navbar-brand" href="{{ url('/home') }}">
                            ZIAN
                        </a>
                    @endif
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @auth
            @if (Auth::user()->priority == 'HI')
            <div id="wrapper">
                <!-- Sidebar -->
                <div id="sidebar-wrapper" class="bg-dark">
                    <ul class="sidebar-nav">
                        <li class="sidebar-brand bg-primary px-5">
                            <a href="#" class="text-white">
                                Zian Payroll
                            </a>
                        </li>
                        <li  class="{{ (request()->is('homedashboard')) ? 'active-sidebar' : '' }}">
                            <a href="{{route('homedashboard')}}"> <i class="fas fa-home m-3"></i> Dashboard</a>
                        </li>
                        <li  class="{{ (request()->is('employees')) ? 'active-sidebar' : '' }}">
                            <a href="{{route('dashboard')}}"><i class="fas fa-users m-3"></i> Employees</a>
                        </li>
                        <li  class="{{ (request()->is('attendance')) ? 'active-sidebar' : '' }}">
                            <a href="{{route('attendance')}}"><i class="fas fa-chart-bar m-3"></i>Attendance</a>
                        </li>
                        <li class="{{ (request()->is('deductions')) ? 'active-sidebar' : '' }}">
                        <a href="{{route('deductions')}}"><i class="fas fa-comments-dollar m-3"></i>Deductions</a>
                        </li>
                        <li  class="{{ (request()->is('cash-advance')) ? 'active-sidebar' : '' }}">
                            <a href="{{route('ded.showCA')}}"><i class="fas fa-cash-register m-3"></i>Cash Advance</a>
                        </li>
                        <li  class="{{ (request()->is('leave')) ? 'active-sidebar' : '' }}">
                        <a href="{{route('leave')}}"><i class="fas fa-plane-departure m-3"></i></i>Leaves</a>
                        </li>
                        <li  class="{{ (request()->is('payroll')) ? 'active-sidebar' : '' }}">
                        <a href="{{route('payroll')}}"><i class="fas fa-file-invoice-dollar m-3"></i></i></i></i>Payroll</a>
                        </li>
                        <li  class="{{ (request()->is('settings')) ? 'active-sidebar' : '' }}">
                            <a href="{{route('settings')}}"><i class="fas fa-cogs m-3"></i>Settings</a>
                        </li>

                    </ul>
                </div>
                <!-- /#sidebar-wrapper -->
                <div id="page-content-wrapper">
                <a href="#menu-toggle" id="menu-toggle"><i class="fas fa-bars fa-2x"></i></a>
                    <main class="py-4">
                        @yield('content-dashboard')
                    </main>
                </div>
                </div>
            @endif
        @endauth

        <main class="py-4">
            @yield('content')
        </main>



    </div>

   <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('js/jquery.timepicker.min.js')}}"></script>

</body>
</html>
