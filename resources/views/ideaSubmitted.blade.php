<!DOCTYPE HTML>
<html lang="ja">
<head>
    <title>アイディア投稿フォーム</title>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="{{asset('/js/base/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('/js/base/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/base/jquery.bootgrid.min.js')}}"></script>
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
</head>
<body>

<div class="container">
    @if (Session::has('flash_message'))
        <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
    @endif

    <div>
        アイディアの投稿、ありがとうございました。
        <script>
            setTimeout("redirect()", 5);
            function redirect(){
                location.href='/ideaForm';
            }
        </script>
    </div>

</div>

@include('footer')
</body>
</html>