@php
// use Illuminate\Support\Facades\DB;
// $website = DB::table('websites')
$website = DB::table('websites')->orderBy('id','asc')->first();
@endphp

<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Copyright &copy; {{ date('Y') }} ~ By. <strong>{{$website->nama}}</strong> Telp. {{$website->telp}}
    </div>
    <!-- Default to the left -->
    Hari ini : <strong>{{ date('l, d - M - Y')}}</strong>
</footer>
