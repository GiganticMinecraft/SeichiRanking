@extends('layouts.app')

@section('content')

<div class="container">
    @if (Session::has('flash_message'))
        <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
    @endif

    <br>
    <div class="alert alert-success mt-1">
        {{ session('message') }}
    </div>

    <div>
        ※ 数秒後、ギガンティック☆整地鯖の公式建築コンペ投票ページへ移動します。
        <br><br>
        <script>
            setTimeout("redirect()", 3000);
            function redirect(){
                location.href='/buildCompetition';
            }
        </script>
    </div>

</div>

@include('footer')

@endsection
