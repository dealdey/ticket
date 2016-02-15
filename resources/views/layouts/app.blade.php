<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DealDey Ticket - @yield('page')</title>

    {!! Html::style('css/app.css') !!}
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body { padding-top: 60px; }
        @media (max-width: 979px) {
            body { padding-top: 0px; }
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img alt="Brand" src="{{ url('/imgs/dealdey.png') }}" class="logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if(!Auth::guest())
                        <li><a href="{{ url('/tickets') }}">Ticket</a></li>
                    @endif
                    <li><a href="{{ url('/support') }}">Support</a></li>
                    <li><a href="{{ url('/') }}">Knowledge Base</a></li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @if (Auth::user()->can(['create-user', 'edit-user']))
                                <li><a href="{{ url('/register') }}">create user</a></li>
                                @endif
                                <li><a href="{{ url('/password/change') }}">change password</a></li>
                                <li><a href="{{ url('/logout') }}">logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        @if (Session::has('notification'))
            <div class="alert {{ Session::get('notification_type') }}">
                @if (Session::has('notification_important'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @endif
                {{ session('notification') }}
            </div>
        @endif
        @yield('content')
    </div>
    {!! Html::script('js/jquery.min.js') !!}
    @yield('footer')
    {!! Html::script('js/bootstrap.min.js') !!}
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
