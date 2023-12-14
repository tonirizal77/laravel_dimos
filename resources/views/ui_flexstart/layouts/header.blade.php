<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        {{-- <h1 class="logo">
            <a href="{{url('#header')}}" class="scrollto">{{ $website->nama }}</a>
        </h1> --}}

        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="#hero" class="logo d-flex align-items-center">
            <img src="{{ asset($theme.'/assets/img/logo.png') }}" alt="logo">
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link scrollto" href="#features">Features</a></li>
                <li><a class="nav-link scrollto" href="#pricing">Price</a></li>
                {{-- <li><a class="nav-link scrollto" href="#services">Services</a></li> --}}
                {{-- <li><a class="nav-link scrollto" href="#portfolio">Portfolio</a></li> --}}
                {{-- <li><a class="nav-link scrollto" href="#team">Team</a></li> --}}
                {{-- <li><a href="blog.html">Blog</a></li> --}}
                <!--
                <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                    <li><a href="#">Drop Down 1</a></li>
                    <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                        <ul>
                        <li><a href="#">Deep Drop Down 1</a></li>
                        <li><a href="#">Deep Drop Down 2</a></li>
                        <li><a href="#">Deep Drop Down 3</a></li>
                        <li><a href="#">Deep Drop Down 4</a></li>
                        <li><a href="#">Deep Drop Down 5</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Drop Down 2</a></li>
                    <li><a href="#">Drop Down 3</a></li>
                    <li><a href="#">Drop Down 4</a></li>
                    </ul>
                </li>
                -->
                {{-- <li><a class="nav-link scrollto" href="#contact">Contact</a></li> --}}
                {{-- <li><a class="getstarted scrollto" href="#about">Get Started</a></li> --}}
                @if (Route::has('login'))
                    @auth
                        @php
                            $role = DB::table('roles')->where('id', Auth::user()->role_id)->first();
                            $px = $role->redirect_to;
                        @endphp
                        {{-- <li><a href="{{ url($px.'/dashboard') }}">Dashboard</a></li> --}}
                        <li><a href="{{ route('dashboard.index') }}">Go Dashboard</a></li>
                    @else
                        <li><a class="getstarted" href="{{ route('register', ['tp' => 'free'])}}">Daftar Gratis</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @endauth
                @endif
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
