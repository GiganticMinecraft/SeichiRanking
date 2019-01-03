@extends('layouts.app')

@section('content')

<script>
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.parent().parent().next(':text').val(label);
  });
</script>

<div class="container">

    <h1>第{{$manage_id}}回 {{$presence->build_competition_manage_name}}応募ページ</h1>

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

    <div>
        <p class="text-danger">※：必須項目</p>

        <form method="post" action="/buildCompetition/apply/submit" id="form" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="build_competition_manage_id" value="{{$manage_id}}" />

            <div class="form-group">
                <label for="theme" class="col-sm-2 control-label">テーマ <span class="text-danger">※</span></label>
                <div class="col-sm-10">
                    <select class="form-control" id="theme" name="theme">
                        @foreach($themes as $data)
                            <option value="{{$data->id}}">{{$data->theme_division_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">作品名 <span class="text-danger">※</span></label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="title" value="{!! Input::old('title') !!}" placeholder="作品名を記載してください">
                </div>
            </div>

            <div class="form-group">

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
                    <input type="text" name="contact_id" class="form-control" id="contact_id" value="{!! Input::old('contact_id') !!}" placeholder="Discord ID（#の数字も付けてください）">
                </div>
            </div>

            <div class="form-group">
                <label for="apply_comment" class="col-sm-2 control-label">アピールポイント <span class="text-danger">※</span></label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="apply_comment" rows="3" name="apply_comment" placeholder="作品のアピールポイントを記載してください">{!! Input::old('apply_comment') !!}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="image" class="col-sm-2 control-label">画像</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-info">
                         ファイル選択<input type="file" style="display:none" name="img" id="img">
                        </span>
                        </label>
                        <input type="text" class="form-control" readonly="">
                    </div>
                    <span>※ 1枚のみ投稿可能です</span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">応募する</button>
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

