@extends('ui_admin.auth.index')

@section('title','AdminLTE 2 | Lock Screen Page')

@section('content')
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name">John Doe</div>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
            <img src="{{asset('adminlte/dist/img/user1-128x128.jpg')}}" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials">
            <div class="input-group">
                <input type="password" class="form-control" placeholder="password">

                <div class="input-group-btn">
                    <button type="button" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                </div>
            </div>
        </form>
        <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
        Enter your password to retrieve your session
    </div>
    <div class="text-center">
        <a href="{{url('/login')}}">Or Sign in as a different user</a>
    </div>
    <div class="lockscreen-footer text-center">
        Copyright &copy; 2014-2016 <b><a href="http://almsaeedstudio.com" class="text-black">Almsaeed Studio</a></b><br>
        All rights reserved
    </div>
</div>
<!-- /.center -->

@endsection
@section('js-x')
<script>
    $("body").addClass('lockscreen')
</script>
@endsection
