<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <!-- スマホやタブレットで表示した時のメニューボタン -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                ...
            </button>

            <!-- ブランド表示 -->
            <a class="navbar-brand" href="/">整地鯖ランキング</a>
        </div>

        <!-- メニュー -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <li @if (!empty($navbar_act) && $navbar_act == 'total')class="active"@endif>
                    <a href="/ranking/total">総合</a>
                </li>
                <li @if (!empty($navbar_act) && $navbar_act == 'daily')class="active"@endif>
                    <a href="/ranking/daily">日間</a>
                </li>
                <li @if (!empty($navbar_act) && $navbar_act == 'weekly')class="active"@endif>
                    <a href="/ranking/weekly">週間</a>
                </li>
                <li @if (!empty($navbar_act) && $navbar_act == 'monthly')class="active"@endif>
                    <a href="/ranking/monthly">月間</a>
                </li>
                <li @if (!empty($navbar_act) && $navbar_act == 'year')class="active"@endif>
                    <a href="/ranking/year">年間</a>
                </li>
            </ul>

            <!-- 左寄せメニュー -->
            <ul class="nav navbar-nav small">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        お問い合わせ <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSctLrByNvAiQop2lha9Mxn-D5p1OUaOf8JKQJCyAdggGBbzpg/viewform?c=0&w=1">
                                ご意見・ご感想・リクエスト
                            </a>
                        </li>

                        <li><a href="/ideaForm">アイディアの投稿</a></li>
                        <li><a href="/inquiryForm">お問い合わせ</a></li>
                        <li><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfK9DQkUCD2qs8zATUuYIC3JuV3MyXRVCYjMb5g4g_hBUusSA/viewform?c=0&w=1">
                                通報フォーム
                            </a>
                        </li>
                        <li><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSdn9fTTs55c-oGLT3c68KVTGvfUjTK-W_cdataU7_XyzqcBRg/viewform?c=0&w=1">
                                不具合報告フォーム
                            </a>
                        </li>
                        <li><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSezwur20tx0JCQ0KMY0JiThYy7oEQDykFRiic96KxK17WOBwA/viewform?c=0&w=1">
                                寄付受付フォーム
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        その他メニュー <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/about">このページについて</a></li>
                        <li><a href="http://seichi.click/" target="_blank">公式Wiki</a></li>
                    </ul>
                </li>


            </ul>

            <form id="player-search-form" class="navbar-form navbar-left">
                <div class="form-group">
                    <input id="player-search-box" class="form-control" autocomplete="off" placeholder="ユーザー名を検索">
                </div>
            </form>
            <!-- 右寄せメニュー -->
            <ul class="nav navbar-nav navbar-right">

                {{-- 未ログイン時 --}}
                {{--@if (Auth::guest())--}}
                    {{--<li><a href="/lead_system/auth/login">管理者用メニュー</a></li>--}}
                {{-- ログイン時 --}}
                {{--@else--}}
                    <!-- ドロップダウンメニュー -->
                    <li class="dropdown">
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                            {{--<span class="glyphicon glyphicon-cog"></span>--}}
                        {{--</a>--}}
                        <ul class="dropdown-menu" role="menu">
                            {{--<li><a href="/lead_system/auth/logout">ログアウト</a></li>--}}
                        </ul>
                    </li>
                {{--@endif--}}
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>