@extends('layouts.app')

@section('content')

<div class="container">

    <h1>お問い合わせフォーム</h1>

    {{-- エラーメッセージ --}}
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        当フォームより、運営チームに直接お問い合わせ頂けます。<br>
        不具合報告、迷惑プレイヤーの通報は<a href="https://seichi.click/wiki/お問い合わせ">専用フォーム</a>をご利用ください。

    <br><br>

    <ul>
        <li>返答には最大2週間程度のお時間を頂いております。</li>
        <li>内容によっては返答を差し控えさせて頂くことがありますことをご了承ください。</li>
        <li>内容に不備がある場合は、返答並びに対応出来ません。</li>
    </ul>
    </div>

    <hr>

    <div>
        <h3>ゲーム内の特定場所・特定時間を報告する時の注意</h3>
        <p>以下の事項が全て明記されていないと、運営チームが場所や時間を特定出来ません。</p>

        <ul>
            <li>サーバー名(アルカディア鯖？エデン鯖？ヴァルハラ鯖？…)</li>
            <li>ワールド名(メインワールド？整地ワールド？第二整地ワールド？…)</li>
            <li>座標(X座標、Y座標、Z座標)</li>
        </ul>
    </div>

    <hr>

    <div>
        <h3>Compromised Account(不正アカウント検知)によるアクセス拒否を受けた方へ</h3>
        <p><a href="https://seichi.click/wiki/Compromised_Account判定解除申請手順">こちら</a>のページをご確認ください。</p>
    </div>

    <hr>

    <div>
        <h3>上の文章をよく読んだ上で、以下にご記入ください。</h3>

        <p class="text-danger">※：必須項目</p>

        <form method="post" action="/inquiryForm/submit" id="form" class="form-horizontal">

            <div class="form-group">
                {{ csrf_field() }}
                <label for="inputEmail3" class="col-sm-2 control-label">連絡先 <span class="text-danger">※</span></label>

                <div class="radio col-sm-10">
                    <label><input type="radio" name="reply_type" value="discord" @if(old('reply_type') == 'discord' || old('reply_type') == null) checked @endif>Discord　</label>
                    <label><input type="radio" name="reply_type" value="twitter" @if(old('reply_type') == 'twitter') checked @endif>Twitter　</label>
                </div>
            </div>

            <div class="form-group" id="contact_id_form">
                <label for="contact_id" class="col-sm-2 control-label">
                    <span id="contact_id_label">Discord ID</span>
                    <span class="text-danger">※</span>
                </label>
                <div class="col-sm-10">
                    <input type="text" name="contact_id" class="form-control" id="contact_id" value="{!! Input::old('contact_id') !!}" placeholder="Discord ID(#の数字もつけてください)">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">お問い合わせ内容 <span class="text-danger">※</span></label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="inquiry_text" rows="3" name="inquiry_text" placeholder="お問い合わせ内容">{!! Input::old('inquiry_text') !!}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">送信</button>
                </div>
            </div>
        </form>


    </div>


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

