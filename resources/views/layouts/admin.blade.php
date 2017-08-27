<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>整地鯖 管理用ページ</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <script src="{{asset('/js/base/jquery-3.1.1.min.js')}}"></script>
{{--    <script src="{{asset('/js/common.js')}}"></script>--}}
    <script src="{{asset('/js/admin.js')}}"></script>

    {{-- ページ独自JSの組み込み --}}
    @if(!empty($assetJs))
        @foreach($assetJs as $js)
            <script type="text/javascript" src="{{asset($js)}}"></script>
        @endforeach
    @endif

</head>
<body>
    <div id="app">

        <!-- ヘッダー部 -->
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container-fluid">
                <div class="nav-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/admin') }}">
                        整地鯖 管理用ページ
                    </a>

                </div><!-- nav-header -->
                <div id="navbar" class="navbar-collapse collapse in" area-expanded="true">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if ( Auth::guest() )
                            <li><a href="/admin/login/">ログイン</a></li>
                            <li><a href="{{ route('register') }}">ユーザ登録</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="/admin/logout/">ログアウト</a>

                                        {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--</form>--}}
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                    {{--<form class="navbar-form navbar-right">--}}
                        {{--<input type="text" class="form-control" placeholder="検索">--}}
                    {{--</form>--}}
                </div><!-- navbar -->
            </div><!-- container-fluid -->
        </nav>

        @if ( !Auth::guest() )

            <div class="container-fluid">
                <div class="row">
                    <div class="clearfix"></div>
                    <div class="col-sm-3 col-md-2 sidebar">
                        <ul class="nav nav-sidebar">
                            <li><a href="/admin/">管理者TOP</a></li>
                            <li><a href="/admin/inquiry">お問い合わせ管理</a></li>
                            <li><a href="/admin/account">アカウント管理</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-9 col-md-10 main">
                        <!-- メインコンテンツ -->
                        @yield('content')
                    </div>
                </div>
            </div>

        @else
            @yield('content')
        @endif

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
