@extends('layouts.admin')

@section('content')
    <h3>お問い合わせ管理</h3>

    @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif


    <div>
        {{--<form action="/admin/inquiry" method="get">--}}
            {{--<div class="input-group">--}}
                {{--<div class="input-group-btn search-panel">--}}
                    {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">--}}
                        {{--<span id="search_concept">絞り込み</span> <span class="caret"></span>--}}
                    {{--</button>--}}
                    {{--<ul class="dropdown-menu" role="menu">--}}
                        {{--<li><a href="#unanswered">未回答</a></li>--}}
                        {{--<li><a href="#solved">回答済</a></li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li><a href="#all">全て</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<input type="hidden" name="search_param" value="all" id="search_param">--}}
                {{--<input type="text" class="form-control" name="word" placeholder="検索キーワード">--}}
                {{--<span class="input-group-btn">--}}
                    {{--<button class="btn btn-info" type="submit">--}}
                        {{--<span class="glyphicon glyphicon-search"></span>--}}
                        {{--検索--}}
                    {{--</button>--}}
                {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}

        <form action="/admin/inquiry" method="get">
            <div class="radio">
                <label>
                    <input type="radio" name="filter" value="0"{{app('request')->input('filter') === '0' || empty(app('request')->input('ans')) ? ' checked': null }}>
                    未回答　
                </label>
                <label>
                    <input type="radio" name="filter" value="1"{{app('request')->input('filter') === '1' ? ' checked': null }}>
                    回答済　
                </label>
                <label>
                    <input type="radio" name="filter" value="all"{{app('request')->input('filter') === 'all' ? ' checked': null }}>
                    全て　
                </label>
            </div>

            <div class="input-group">
                <input type="text" class="form-control" name="word" placeholder="検索キーワード" value="{{!empty(app('request')->input('word')) ?app('request')->input('word') : null }}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">検索</button>
                </span>
            </div>
        </form>


        <div style="margin-top:10px">
            @if (count($inquiry_list) > 0)
                <table class="table table-sm table-hover">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>MCID</th>
                        <th>問い合わせ内容</th>
                        <th>問い合わせ日時</th>
                        <th>回答済</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($inquiry_list as $key => $item)
                        <tr>
                            <td><a href="/admin/inquiry/detail?id={{$item->inquiry_id}}">{{$item->inquiry_id}}</a></td>
                            <td>{{$item->name}}</td>
                            <td>{{str_limit($item->inquiry_text, $limit=120, $end='...')}}</td>
                            <td>{{$item->inquiry_date}}</td>
                            <td>@if ($item->solved_flg === 1) 回答済 @else <span class="text-danger">未回答</span> @endif</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning">
                    お問い合わせは0件です
                </div>
            @endif

            {!! $inquiry_list->links() !!}

        </div>
    </div>
@endsection

