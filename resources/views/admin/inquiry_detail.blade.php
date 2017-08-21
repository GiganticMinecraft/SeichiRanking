@extends('layouts.admin')

@section('content')
    <h3>お問い合わせ詳細</h3>

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    {{--<div class="panel-heading">MCID</div>--}}
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/admin/inquiry/submit">
                            {{ csrf_field() }}
                            <input type="hidden" name="name" value="{{$inquiry_detail->name}}">

                            <div>
                                <label class="col-md-3 control-label">No.</label>

                                <div class="col-md-7">
                                    <p class="pt-5">{{$inquiry_detail->inquiry_id}}</p>
                                    <input type="hidden" name="inquiry_id" value="{{$inquiry_detail->inquiry_id}}">

                                    @if ($errors->has('inquiry_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('inquiry_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="col-md-3 control-label">問い合わせ日時</label>

                                <div class="col-md-7">
                                    <p class="pt-5">{{$inquiry_detail->inquiry_date}}</p>

                                    @if ($errors->has('inquiry_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('inquiry_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="col-md-3 control-label">内容</label>

                                <div class="col-md-7">
                                    {{--<textarea id="inquiry_text" class="form-control" name="inquiry_text">{{ old('inquiry_text') }}</textarea>--}}
                                    <p class="pt-5">{!! nl2br(e($inquiry_detail->inquiry_text)) !!}</p>

                                    @if ($errors->has('inquiry_text'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('inquiry_text') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                                <label for="answer" class="col-md-3 control-label">回答</label>

                                <div class="col-md-7">
                                    <textarea id="answer" class="form-control" name="answer" rows="5" required>{{$inquiry_detail->answer_text}}</textarea>

                                    @if ($errors->has('answer'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('answer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('discord_notice') ? ' has-error' : '' }}">
                                <label for="discord_notice" class="col-md-3 control-label">Discord通知</label>

                                <div class="col-md-7">

                                    <label class="radio-inline"><input type="radio" name="discord_notice" checked>通知する</label>
                                    <label class="radio-inline"><input type="radio" name="discord_notice">通知しない</label>

                                    @if ($errors->has('discord_notice'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('discord_notice') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- 返信先がtwitterの場合のみ --}}
                            @if ($inquiry_detail->reply_type === 1)

                            <div class="form-group{{ $errors->has('twitter_notice') ? ' has-error' : '' }}">
                                <label for="twitter_notice" class="col-md-3 control-label">Twitterでの回答</label>

                                <div class="col-md-7">

                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="twitter_notice">回答先：{{$inquiry_detail->contact_id}}
                                    </label>

                                    @if ($errors->has('twitter_notice'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('twitter_notice') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        回答する
                                    </button>
                                    <a href="/admin/inquiry" class="btn btn-info">
                                        キャンセル
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        </div>
@endsection

