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

    <h1>アイデアの投稿</h1>

    @if (Session::has('message'))
        <div class="alert alert-danger">{!! nl2br(e(Session::get('message'))) !!}</div>
    @endif


    <p>こちらからアイデアを投稿できます。</p>
        <p>投稿されたアイデアは公式DiscordグループやRedmine等にて一般公開されます。</p>
        <p>投稿の際、現時点で考えつく限りで構いませんので、何故そのアイデアを提案するのか、根拠も併せてご記入頂くと、採用され易くなります。</p>

        <form method="post" action="/ideaForm/submit">
            <div class="form-group">
                {{ csrf_field() }}
                <label for="idea_text">アイディア <span class="text-danger">*</span></label>
                <textarea class="form-control" id="idea_text" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">送信</button>
        </form>
</div>

@include('footer')
</body>
</html>