<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head_unique')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a 
                    class="navbar-brand" 
                    href="{{ url('/') }}"
                >FeatherMarks</a>

                <div id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <div>
                                <i 
                                    class="fas fa-user-circle fa-2x text-muted"
                                    onclick="$('#hover-main-menu').toggle();"
                                ></i>

                                <section 
                                    id="hover-main-menu"
                                    style="display:none;"
                                >
                                    <ul 
                                        style="
                                            list-style: none;
                                            padding-left: 0px;
                                        "
                                    >
                                        <li>
                                            <select 
                                                class="form-control"
                                                style="width:110px"
                                                onchange="window.location.href = '/home?cat=' + this.value" 
                                            >
                                                <option value="personal">Personal</option>
                                                
                                                <option 
                                                    value="work"
                                                    @if($category === 'work')
                                                        selected="true"
                                                    @endif 
                                                >Work</option>
                                            </select>
                                        </li>

                                        <li>
                                            <form 
                                                action="{{ route('logout') }}" 
                                                method="POST" 
                                                class="inline-block"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn btn-link ml-10 text-muted"
                                                    style="
                                                        padding: 0px;
                                                        margin: 0px;
                                                    "
                                                >Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </section>
                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
