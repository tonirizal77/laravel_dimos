@php
$user = DB::table("users")
    ->leftJoin('usaha','users.usaha_id','=','usaha.id')
    ->leftJoin('roles','users.role_id','=','roles.id')
    ->select('users.*', 'usaha.nama as nama_usaha', 'roles.name as posisi')
    ->where('users.role_id', Auth::user()->role_id)
    ->where('users.id', Auth::user()->id)
    ->first();
@endphp

<aside class="main-sidebar sidebar-dark-info elevation-4">
    {{-- Kunjungi Toko Sendiri atau Toko Relationship --}}
    <!-- Brand Logo -->
    <a href="{{ route('homepage') }}" class="brand-link navbar-cyan" target="_blank">
        <img src="{{ asset('ui_admin/dist/img/logo_dimos.png') }}" alt="SiDiMoS Logo" class="brand-image bg-white img-circle elevation-2" style="opacity: 1">
        {{-- <img src="{{ asset('ui_admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        {{-- <span class="brand-text font-weight-light">{{ config('app.name') }}</span> --}}

        <span class="brand-text text-white text-bold">{{ (Auth::user()->usaha_id == null) ? "SiDiMoS Group" : $user->nama_usaha }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (Auth::user()->profilePicture != null )
                    <img src="{{ url('/images/profile/'.Auth::user()->profilePicture) }}" class="img-circle elevation-2" alt="User Image">
                    {{-- <img src="{{ asset('ui_admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> --}}
                @else
                    <img src="{{ asset('ui_admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <div>{{ Auth::user()->name }}</div>
                <div>{{ ucwords($user->posisi) }}</div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            @include('ui_admin.layouts.menu')
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
