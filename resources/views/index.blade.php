@extends('layout')


@section('content')
    <div class="m-t-1 m-l-1 m-r-1">
        <div id="ranking-type-nav"></div>
        <div id="ranking-container"></div>
    </div>

    <!-- これより前に読み込むとDOM参照でコケる -->
    <script src="{{asset('/js/jsx/ranking.js?'.date('Ymd'))}}"></script>
@endsection