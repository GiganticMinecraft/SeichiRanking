@extends('layout')


@section('content')

    <div class="m-t-1 m-l-1 m-r-1">
        <!--タブのボタン部分-->
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a href="#tab1" class="nav-link bg-primary" data-toggle="tab">整地神ランキング</a>
            </li>
            <li class="nav-item">
                <a href="#tab2" class="nav-link bg-primary" data-toggle="tab">ログイン神ランキング</a>
            </li>
            @if ($navbar_act !== 'daily')
            <li class="nav-item">
                <a href="#tab3" class="nav-link bg-primary" data-toggle="tab">投票神ランキング</a>
            </li>
            @endif
        </ul>
        <!--タブのコンテンツ部分-->
        <div class="tab-content">
            <div id="tab1" class="tab-pane active">
                <h3>◇ 整地神ランキング</h3>


                {{--<div class="fixing-base">--}}
                    {{--<div class="fixing-box">--}}
                        {{--<form class="navbar-form navbar-right" role="search">--}}
                            {{--<div class="form-group">--}}
                                {{--<input type="text" class="form-control" placeholder="ユーザー名を検索">--}}
                            {{--</div>--}}
                            {{--<button type="submit" class="btn btn-default">検索</button>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}

            <div class="rank">
                
                <table class="table table-striped table-hover">
                    <tbody>

                    @foreach ($ranking_data as $key => $item)
                        <tr>
                            <th scope="row">
                                {{$item->rank}}位
                            </th>
                            <td>
                                <img src="{{$item->mob_head_img}}">
                            </td>
                            <td>
                                [二つ名] {{ $item->name }}<br>
                                <span class="num_break">総整地量：{{ number_format($item->totalbreaknum) }}</span><br>
                                <span class="last_login">Last loign: {{$item->lastquit}}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $ranking_data->render() !!}

            </div>

            </div>

                <div id="tab2" class="tab-pane">
                    <h3>ログイン神ランキング</h3>
                </div>
            {{-- 累計のみ表示する --}}
            @if ($navbar_act !== 'daily')
                <div id="tab3" class="tab-pane">
                    <h3>投票神ランキング</h3>
                </div>
            @endif
        </div>
    </div>

@endsection