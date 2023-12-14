@php
    $opsi_roles = Auth::user()->role_id;
    $roles = '-';
    switch ($opsi_roles) {
        case '0':
            $roles = 'Owner';
            break;
        case '1':
            $roles = 'Admin';
            break;
        case '2':
            $roles = 'User';
            break;
        case '3':
            $roles = 'Kasir';
            break;
        case '4':
            $roles = 'Accounting';
            break;
        case '5':
            $roles = 'Staff';
            break;
    }
@endphp

<nav class="main-header navbar navbar-expand navbar-dark navbar-cyan">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li> --}}
        <li class="nav-item d-none d-sm-inline-block align-items-center">
            <span class="nav-link text-lg text-white p-1">
                @yield('title-page')
            </span>
        </li>
    </ul>

    <!-- SEARCH FORM
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('ui_admin/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('ui_admin/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('ui_admin/dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link"  data-toggle="tooltip" title="Fullscreen" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- User Account Menu -->
        <li class="nav-item dropdown user-menu">
            <!-- Menu Toggle Button -->
            <a class="nav-link" data-toggle="dropdown" href="#">
                <!-- The user image in the navbar-->
                @if (Auth::user()->profilePicture != null )
                    <img src="{{ url('/images/profile/'.Auth::user()->profilePicture) }}" class="user-image" alt="User Image">
                @else
                    <img src="{{ asset('ui_admin/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                @endif
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                {{-- <span class="hidden-xs">{{ Auth::user()->name }}</span> --}}
            </a>

            <ul class="dropdown-menu dropdown-menu-right rounded">
                <!-- The user image in the menu -->
                <li class="user-header">
                    @if (Auth::user()->profilePicture != null )
                        <img src="{{ url('/images/profile/'.Auth::user()->profilePicture) }}" class="img-circle" alt="User Image">
                    @else
                        <img src="{{ asset('ui_admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                    @endif
                    <p>
                        {{ Auth::user()->name }} - {{ $roles }}
                        <small>Terdaftar Sejak : {{ Auth::user()->created_at->format('d-m-Y') }}</small>
                    </p>
                </li>
                <!-- Menu Body -->
                {{-- <li class="user-body">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </div>
                </li> --}}
                <!-- Menu Footer-->
                <li class="user-footer text-center flex-justify-between">
                    <a href="{{ route('profile-user.index') }}" role="button" class="btn btn-info btn-sm">Data User</a>
                    <a href="#" role="button" class="btn btn-warning btn-sm">Kunci Layar</a>
                    <a href="{{ route('logout') }}" role="button" class="btn btn-sm btn-danger">Keluar</a>
                </li>
            </ul>
        </li>

        <li class="nav-item" >
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
