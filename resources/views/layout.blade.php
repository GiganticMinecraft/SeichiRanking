<!DOCTYPE HTML>
<html lang="ja">
<head>
    <title>整地鯖ランキング</title>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="{{asset('/js/base/jquery-3.1.1.min.js?'.date('Ymd'))}}"></script>
    <script src="{{asset('/js/base/bootstrap.min.js?'.date('Ymd'))}}"></script>
    <script src="{{asset('/js/base/jquery.bootgrid.min.js?'.date('Ymd'))}}"></script>
    <script src="{{asset('/js/base/Chart.min.js?'.date('Ymd'))}}"></script>
    <script src="{{asset('/js/base/Chart.bundle.min.js?'.date('Ymd'))}}"></script>
    {{--<script src="{{asset('/js/index.js')}}"></script>--}}

    {{-- ページ独自JSの組み込み --}}
    @if(!empty($assetJs))
        @foreach($assetJs as $js)
            <script type="text/javascript" src="{{asset($js.'?'.date('Ymd'))}}"></script>
        @endforeach
    @endif

    <link rel="stylesheet" href="{{asset('/css/base/bootstrap.min.css?'.date('Ymd'))}}">
    <link rel="stylesheet" href="{{asset('/css/base/jquery.bootgrid.min.css?'.date('Ymd'))}}">
    <link rel="stylesheet" href="{{asset('/css/common.css?'.date('Ymd'))}}">
    {{-- ページ独自CSSの組み込み --}}
    @if(!empty($assetCss))
        @foreach($assetCss as $css)
            <link rel="stylesheet" href="{{asset($css)}}">
        @endforeach
    @endif
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    {{-- Googleアナリティクス--}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-60578176-4', 'auto');
        ga('send', 'pageview');

    </script>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-1577125384876056",
            enable_page_level_ads: true
        });
    </script>
</head>
<body>
    @yield('content')

    @include('footer')
</body>
</html>