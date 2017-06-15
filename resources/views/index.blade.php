@extends('layout')


@section('content')

    <div class="m-t-1 m-l-1 m-r-1">
        <!--タブのボタン部分-->
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a href="#tab1" class="nav-link bg-primary" data-toggle="tab">総　合</a>
            </li>
            <li class="nav-item">
                <a href="#tab2" class="nav-link bg-primary" data-toggle="tab">整 地 量</a>
            </li>
            <li class="nav-item">
                <a href="#tab3" class="nav-link bg-primary" data-toggle="tab">建 築 量</a>
            </li>
            <li class="nav-item">
                <a href="#tab4" class="nav-link bg-primary" data-toggle="tab">接続時間</a>
            </li>
            @if ($navbar_act !== 'daily')
                <li class="nav-item">
                    <a href="#tab3" class="nav-link bg-primary" data-toggle="tab">投 票 数</a>
                </li>
            @endif
        </ul>
        <!--タブのコンテンツ部分-->
        <div class="tab-content">
            <div id="tab1" class="tab-pane active">
                <h3>◇ 総合ランキング</h3>
                <div class="rank">
                    ※ 近日公開予定
                </div>
            </div>

            <div id="tab2" class="tab-pane">
                <h3>◇ 整地量ランキング</h3>

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

                    @if (!empty($navbar_act) && $navbar_act == 'year' || $navbar_act == 'monthly' || $navbar_act == 'weekly' || $navbar_act == 'daily')
                        ※ 近日公開予定
                    @else
                        <table class="table table-striped table-hover">
                            <tbody>

                            @foreach ($ranking_data as $key => $item)
                                <tr>
                                    <th scope="row">
                                        <big>{{$item->rank}}位</big>
                                    </th>
                                    <td>
                                        <img src="{{$item->mob_head_img}}">
                                    </td>
                                    <td>
                                        {{ $item->name }}<br>
                                        <span class="num_break">総整地量：{{ number_format($item->allmineblock) }}</span><br>
                                        {{--<span class="last_login">Last loign: {{$item->lastquit}}</span>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- ページネーション --}}
                        {!! $ranking_data->appends(['kind' => 'break'])->links() !!}

                    @endif

                </div>
            </div>

            <div id="tab3" class="tab-pane">
                <h3>◇ 建築量ランキング</h3>
                <div class="rank">
                    ※ 近日公開予定
                </div>
            </div>
            <div id="tab4" class="tab-pane">
                <h3>◇ 接続時間ランキング</h3>
                <div class="rank">
                    ※ 近日公開予定
                </div>
            </div>
            {{-- 累計のみ表示する --}}
            @if ($navbar_act !== 'daily')
                <div id="tab5" class="tab-pane">
                    <h3>◇ 投票数ランキング</h3>
                    <div class="rank">
                        ※ 近日公開予定
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection