@extends('layouts.app')

@section('content')

<div class="container">

    <h1>アイデアの投稿</h1>

    @if (Session::has('message'))
        <div class="alert alert-danger">{!! nl2br(e(Session::get('message'))) !!}</div>
    @endif


    <p>こちらからアイデアを投稿できます。</p>
        <p>投稿されたアイデアは公式DiscordグループやRedmine等にて一般公開されます。</p>
        <p>投稿の際、現時点で考えつく限りで構いませんので、何故そのアイデアを提案するのか、根拠も併せてご記入頂くと、採用され易くなります。</p>

        <form method="post" action="/ideaForm/submit" id="form">
            <div class="form-group">
                {{ csrf_field() }}
                <label for="idea_text">アイデア <span class="text-danger">*</span></label>
                <textarea class="form-control" id="idea_text" rows="3" name="idea" placeholder="アイディアの内容"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">送信</button>
        </form>
</div>

@include('footer')

@endsection

