<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('/wp/css/app.css') }}" rel="stylesheet">

    @yield('head_unique')
</head>

<body>
    <div id="vue_app">
        <div 
            class="text-right mt-20 mr-30"
        >
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
                    <h5 
                        class="text-muted"
                        onclick="$('#hover-main-menu').toggle();"
                    >
                        <span>{{ucwords($category)}}&nbsp;</span>

                        <i class="fas fa-feather-alt fa-lg text-muted"></i>
                    </h5>

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
        </div>

        <main class="mb-10">
            @yield('content')
        </main>
    </div>

    <script src="{{ mix('/wp/js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
