<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/rateyo/min/jquery.rateyo.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.jpg') }}" height="35px" alt="logo"> 
                    Anh Shoes
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <img class="img-icon" id="avt" width="40px" src="
                                    @if (Auth::user()->avatar == null)
                                        {{ asset('images/user-icon.png') }}
                                    @else
                                        {{ asset('images/profile/' . Auth::user()->avatar) }} 
                                    @endif"
                                alt="">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.profile', Auth::user()->id) }}">{{ __('profile') }}</a>
                                    <a class="dropdown-item" href="{{ route('user.history', Auth::user()->id) }}">{{ __('history') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        <li class="nav_item">
                            @include('partials/language_switcher')
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-2">
            <div class="container">
            @if (Auth::user())
                <nav class="navbar navbar-expand-md navbar-light mb-2">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link text-uppercase h5 me-2" href="/"><i class="fa-solid fa-house-user"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="btn-select nav-link text-uppercase h5 me-2" href="{{ route('shop') }}">{{__('shop now')}}</a>
                            </li>
                            <li class="nav-item dropdown me-2">
                                <a class="btn-select nav-link dropdown-toggle h5 text-uppercase" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{__('brand')}}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach ($brands as $brand)
                                    <li><a class="dropdown-item" href="{{ route('brand', $brand->id) }}">{{ $brand->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul> 
                    </div>

                    <div class="text-right">
                        <a id="cart" href="{{ route('cart') }}" class="btn btn-outline-dark">
                            <i class="fa-solid fa-cart-shopping"></i>
                            {{ __('cart') }}
                            <span class="badge bg-dark text-white ms-1 rounded-pill">{{ $cart->total_quantity }}</span>
                        </a>
                    </div>
                </nav>
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible" id="flash">
                    {{ $message }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @elseif ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible" id="flash">
                    {{ $message }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif
            @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('bower_components/rateyo/min/jquery.rateyo.min.js') }}"></script>
</body>
</html>
