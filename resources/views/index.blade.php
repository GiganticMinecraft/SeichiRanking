@extends('layout')


@section('content')
    <div class="m-t-1 m-l-1 m-r-1">
        <!--タブのボタン部分-->
        <!--TODO: タブは動的に管理されるべき-->
        <ul class="nav nav-tabs" id="ranking-type-nav">
            <li class="nav-item ranking-type-item" data-ranking-type="break">
                <a class="nav-link bg-primary" data-toggle="tab">整 地 量</a>
            </li>
            <li class="nav-item ranking-type-item" data-ranking-type="build">
                <a class="nav-link bg-primary" data-toggle="tab">建 築 量</a>
            </li>
            <li class="nav-item ranking-type-item" data-ranking-type="playtime">
                <a class="nav-link bg-primary" data-toggle="tab">接続時間</a>
            </li>
            @if ($navbar_act !== 'daily')
                <li class="nav-item ranking-type-item" data-ranking-type="vote">
                    <a class="nav-link bg-primary" data-toggle="tab">投 票 数</a>
                </li>
            @endif
        </ul>

        <div id="ranking-container"></div>
    </div>
    <!-- これより前に読み込むとDOM参照でコケる -->
    <script src="{{asset('/js/jsx/ranking.js?'.date('Ymd'))}}"></script>
@endsection