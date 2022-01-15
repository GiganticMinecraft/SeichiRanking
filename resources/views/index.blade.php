@extends('layout')


@section('content')

    {{-- ナビゲーションバーの Partial を使用 --}}
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <!-- スマホやタブレットで表示した時のメニューボタン -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    ...
                </button>

                <!-- ブランド表示 -->
                <a class="navbar-brand" href="/">整地鯖ランキング</a>
            </div>

            <!-- メニュー -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- 期間選択のnavvar -->
                <div id="ranking-duration-nav"></div>

                <!-- 左寄せメニュー -->
                <ul class="nav navbar-nav small">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            その他メニュー <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/about">このページについて</a></li>
                            <li><a href="https://www.seichi.network/gigantic" target="_blank">公式ホームページ</a></li>
                        </ul>
                    </li>


                </ul>

                <form id="player-search-form" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input id="player-search-box" class="form-control" autocomplete="off" placeholder="ユーザー名を検索">
                    </div>
                    <ul id="player-search-suggestions" class="list-group" style="position: absolute;"></ul>
                </form>
                <!-- 右寄せメニュー -->
                <ul class="nav navbar-nav navbar-right">

                {{-- 未ログイン時 --}}
                {{--@if (Auth::guest())--}}
                {{--<li><a href="/lead_system/auth/login">管理者用メニュー</a></li>--}}
                {{-- ログイン時 --}}
                {{--@else--}}
                <!-- ドロップダウンメニュー -->
                    <li class="dropdown">
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                        {{--<span class="glyphicon glyphicon-cog"></span>--}}
                        {{--</a>--}}
                        <ul class="dropdown-menu" role="menu">
                            {{--<li><a href="/lead_system/auth/logout">ログアウト</a></li>--}}
                        </ul>
                    </li>
                    {{--@endif--}}
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        @if (Session::has('flash_message'))
            <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
        @endif

        <div class="row">
            <div class="col-sm-8 top70">
                {{-- メインコンテンツ --}}
                <div class="m-t-1 m-l-1 m-r-1">
                    <div id="ranking-type-nav"></div>
                    <div id="ranking-container"></div>
                </div>
            </div>
            <div class="col-sm-2 top70">
                {{--広告スペース--}}
                <script type="text/javascript">
                    google_ad_client = "ca-pub-1577125384876056";
                    google_ad_slot = "9718464504";
                    google_ad_width = 160;
                    google_ad_height = 600;
                </script>
                <!-- 整地鯖ランキング -->
                <script type="text/javascript"
                        src="//pagead2.googlesyndication.com/pagead/show_ads.js">
                </script>
            </div>
        </div>
    </div>

@endsection
