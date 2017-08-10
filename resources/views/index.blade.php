@extends('layout')


@section('content')

    <div class="m-t-1 m-l-1 m-r-1">
        <!--タブのボタン部分-->
        <ul class="nav nav-tabs">
            {{--<li class="nav-item active">--}}
                {{--<a href="#tab1" class="nav-link bg-primary" data-toggle="tab">総　合</a>--}}
            {{--</li>--}}
            <li class="nav-item @if (app('request')->input('kind') == 'break' || is_null(app('request')->input('kind')))active @endif">
                <a href="#tab2" class="nav-link bg-primary" data-toggle="tab">整 地 量</a>
            </li>
            <li class="nav-item @if (app('request')->input('kind') == 'build')active @endif">
                <a href="#tab3" class="nav-link bg-primary" data-toggle="tab">建 築 量</a>
            </li>
            <li class="nav-item @if (app('request')->input('kind') == 'playtime')active @endif">
                <a href="#tab4" class="nav-link bg-primary" data-toggle="tab">接続時間</a>
            </li>
            @if ($navbar_act !== 'daily')
                <li class="nav-item @if (app('request')->input('kind') == 'vote')active @endif">
                    <a href="#tab5" class="nav-link bg-primary" data-toggle="tab">投 票 数</a>
                </li>
            @endif
        </ul>
        <!--タブのコンテンツ部分-->
        <div class="tab-content">

            <div id="tab2" class="tab-pane @if (app('request')->input('kind') == 'break' || is_null(app('request')->input('kind')))active @endif">
                <h3>◇ 整地量ランキング</h3>

                <div class="rank">

                    @if (!empty($navbar_act) && $navbar_act == 'year' || $navbar_act == 'monthly' || $navbar_act == 'weekly' || $navbar_act == 'daily')
                        ※ 近日公開予定
                    @else

                        <table class="table table-striped table-hover">
                            <tbody>

                            @foreach ($break_ranking as $key => $item)
                                <tr>
                                    <th scope="row">
                                        <big>{{$item->rank}}位</big>
                                    </th>
                                    <td>
                                        <img src="{{$item->mob_head_img}}">
                                    </td>
                                    <td>
                                        {{ $item->name }}<br>
                                        {{--<span class="num_break">総整地量：{{ number_format($item->allmineblock) }}</span><br>--}}
                                        <span class="num_break">整地量：{{ number_format($item->totalbreaknum) }}</span><br>
                                        <span class="last_login">Last login: {{$item->lastquit}}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- ページネーション --}}
                        {!! $break_ranking->appends(['kind' => 'break'])->links() !!}

                    @endif

                </div>
            </div>

            <div id="tab3" class="tab-pane @if (app('request')->input('kind') == 'build')active @endif">
                <h3>◇ 建築量ランキング</h3>
                <div class="rank">
                    @if (!empty($navbar_act) && $navbar_act == 'year' || $navbar_act == 'monthly' || $navbar_act == 'weekly' || $navbar_act == 'daily')
                        ※ 近日公開予定
                    @else

                        <table class="table table-striped table-hover">
                            <tbody>

                            @foreach ($build_ranking as $key => $item)
                                <tr>
                                    <th scope="row">
                                        <big>{{$item->rank}}位</big>
                                    </th>
                                    <td>
                                        <img src="{{$item->mob_head_img}}">
                                    </td>
                                    <td>
                                        {{ $item->name }}<br>
                                        {{--<span class="num_break">総整地量：{{ number_format($item->allmineblock) }}</span><br>--}}
                                        <span class="num_break">建築量：{{ number_format($item->build_count) }}</span><br>
                                        <span class="last_login">Last login: {{$item->lastquit}}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- ページネーション --}}
                        {!! $build_ranking->appends(['kind' => 'build'])->links() !!}

                    @endif
                </div>
            </div>
            <div id="tab4" class="tab-pane @if (app('request')->input('kind') == 'playtime')active @endif">
                <h3>◇ 接続時間ランキング</h3>
                <div class="rank">
                    @if (!empty($navbar_act) && $navbar_act == 'year' || $navbar_act == 'monthly' || $navbar_act == 'weekly' || $navbar_act == 'daily')
                        ※ 近日公開予定
                    @else
                        <table class="table table-striped table-hover">
                            <tbody>

                            @foreach ($playtime_ranking as $key => $item)
                                <tr>
                                    <th scope="row">
                                        <big>{{$item->rank}}位</big>
                                    </th>
                                    <td>
                                        <img src="{{$item->mob_head_img}}">
                                    </td>
                                    <td>
                                        {{ $item->name }}<br>
                                        {{--<span class="num_break">総整地量：{{ number_format($item->allmineblock) }}</span><br>--}}
                                        <span class="num_break">接続時間：{{ $item->playtime }}</span><br>
                                        <span class="last_login">Last login: {{$item->lastquit}}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- ページネーション --}}
                        {!! $playtime_ranking->appends(['kind' => 'playtime'])->links() !!}

                    @endif

                </div>
            </div>
            {{-- 累計のみ表示する --}}
            @if ($navbar_act !== 'daily')
                <div id="tab5" class="tab-pane @if (app('request')->input('kind') == 'vote')active @endif">
                    <h3>◇ 投票数ランキング</h3>
                    <div class="rank">
                        @if (!empty($navbar_act) && $navbar_act == 'year' || $navbar_act == 'monthly' || $navbar_act == 'weekly' || $navbar_act == 'daily')
                            ※ 近日公開予定
                        @else
                            <table class="table table-striped table-hover">
                                <tbody>

                                @foreach ($vote_ranking as $key => $item)
                                    <tr>
                                        <th scope="row">
                                            <big>{{$item->rank}}位</big>
                                        </th>
                                        <td>
                                            <img src="{{$item->mob_head_img}}">
                                        </td>
                                        <td>
                                            {{ $item->name }}<br>
                                            {{--<span class="num_break">総整地量：{{ number_format($item->allmineblock) }}</span><br>--}}
                                            <span class="num_break">投票数：{{ $item->p_vote }}</span><br>
                                            <span class="last_login">Last login: {{$item->lastquit}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{-- ページネーション --}}
                            {!! $vote_ranking->appends(['kind' => 'vote'])->links() !!}

                        @endif

                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Googleアナリティクス--}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js%27,%27ga');

        ga('create', 'UA-60578176-4', 'auto');
        ga('send', 'pageview');

    </script>
@endsection