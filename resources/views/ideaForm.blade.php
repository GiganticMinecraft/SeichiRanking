@extends('layouts.app')

@section('content')

<div class="container">

    <h1>アイデアの投稿</h1>

    @if (Session::has('message'))
        <div class="alert alert-danger">{!! nl2br(e(Session::get('message'))) !!}</div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <p>ギガンティック☆整地鯖に関するアイデアを投稿できます。</p>
    <p>投稿されたアイデアは公式DiscordグループやRedmine等にて一般公開されます。</p>

    <form method="post" action="/ideaForm/submit" id="form">
        <div class="form-group">
            {{ csrf_field() }}
            <label for="idea_text">{{__('label.idea_text')}} <span class="text-danger">*</span></label>
            <textarea class="form-control" id="idea_text" rows="2" name="idea_text" placeholder="アイデアの内容を記載してください"></textarea>

            <label for="idea_text">{{__('label.idea_reason')}} <span class="text-danger">*</span></label>
            <textarea class="form-control" id="idea_reason" rows="2" name="idea_reason" placeholder="そのアイデアが「必要な根拠」、もしくは「なぜあると便利か」を記載してください"></textarea>

            <label for="idea_text">{{__('label.idea_example')}} <span class="text-danger">*</span></label>
            <textarea class="form-control" id="idea_example" rows="2" name="idea_example" placeholder="そのアイデアは「いつ」「どこで」「どんな」使われ方をするか、具体的に記載してください"></textarea>

        </div>
        <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">送信</button>
    </form>
</div>

{{-- 広告欄 --}}
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1577125384876056"
     data-ad-slot="4448153429"
     data-ad-format="auto"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>

@include('footer')

@endsection

