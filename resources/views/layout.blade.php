<!DOCTYPE HTML>
<html lang="ja">
<head>
    <title>整地鯖ランキング</title>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="{{asset('/js/base/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('/js/base/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/base/jquery.bootgrid.min.js')}}"></script>
    <script src="{{asset('/js/base/Chart.min.js')}}"></script>
    <script src="{{asset('/js/base/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('/js/total.js')}}"></script>
    {{--<script src="{{asset('/js/index.js')}}"></script>--}}

    {{--<script src="http://fb.me/react-0.13.3.js"></script>--}}
    {{--<script src="http://fb.me/JSXTransformer-0.13.3.js"></script>--}}
    {{--<script src="https://unpkg.com/react@15/dist/react.js"></script>--}}
    {{--<script src="https://unpkg.com/react-dom@15/dist/react-dom.js"></script>--}}

    {{-- ページ独自JSの組み込み --}}
    @if(!empty($assetJs))
        @foreach($assetJs as $js)
            <script type="text/javascript" src="{{$js}}"></script>
        @endforeach
    @endif

    <link rel="stylesheet" href="{{asset('/css/base/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/base/jquery.bootgrid.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/common.css')}}">
    {{-- ページ独自CSSの組み込み --}}
    @if(!empty($assetCss))
        @foreach($assetCss as $css)
            <link rel="stylesheet" href="{{$css}}">
        @endforeach
    @endif
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
</head>
<body>
    {{-- ナビゲーションバーの Partial を使用 --}}
    @include('navbar')

    <div class="container">
        @if (Session::has('flash_message'))
            <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
        @endif

            <div class="row">
                <div class="col-sm-2 top70">
                    <h4>サーバー稼働状況</h4>

                    <p>☆ 合計接続人数：{{$server_status[0]['online'] or 0}}人</p>
                    <table class="table table-responsive">
                        <tr>
                            <td class="warning">ロビー</td>
                            <td class="warning text-right">{{$server_status[0]['lobby'] or 0}}人</td>
                        <tr>
                            <td class="success">第1:メイン</td>
                            <td class="success text-right">{{$server_status[0]['s1'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="success">第2:メイン</td>
                            <td class="success text-right">{{$server_status[0]['s2'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="success">第3:メイン</td>
                            <td class="success text-right">{{$server_status[0]['s3'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="danger">第1:整地専用</td>
                            <td class="danger text-right">{{$server_status[0]['s5'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="danger">第2:整地専用</td>
                            <td class="danger text-right">{{$server_status[0]['s6'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="info">公共施設</td>
                            <td class="info text-right">{{$server_status[0]['s7'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="">イベント</td>
                            <td class="text-right">{{$server_status[0]['eve'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="">クリエイティブ</td>
                            <td class="text-right">{{$server_status[0]['cre'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="active">第1:ベータ</td>
                            <td class="active text-right">{{$server_status[0]['g1'] or 0}}人</td>
                        </tr>
                        <tr>
                            <td class="active">第2:ベータ</td>
                            <td class="active text-right">{{$server_status[0]['g2'] or 0}}人</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-8 top70">
                    @yield('content')
                </div>
                <div class="col-sm-2">
                    広告スペース(仮)
                </div>
            </div>
    </div>

    @include('footer')
</body>
</html>