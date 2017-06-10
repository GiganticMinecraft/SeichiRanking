<nav class="navbar navbar-default">
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
                    <a href="/ranking/total">累計</a>
                </li>
                <li @if (!empty($navbar_act) && $navbar_act == 'weekly')class="active"@endif>
                    <a href="/ranking/weekly">ウィークリー</a>
                </li>
                <li @if (!empty($navbar_act) && $navbar_act == 'daily')class="active"@endif>
                    <a href="/ranking/daily">デイリー</a>
                </li>
            </ul>

            <!-- 左寄せメニュー -->
            <ul class="nav navbar-nav small">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        整地鯖ランキングとは？ <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/about">このページについて</a></li>
                        <li><a href="/contact">お問い合わせ</a></li>
                    </ul>
                </li>

            </ul>

            {{--<form class="navbar-form navbar-left" role="search">--}}
                {{--<div class="form-group">--}}
                    {{--<input type="text" class="form-control" placeholder="ユーザー名を検索">--}}
                {{--</div>--}}
                {{--<button type="submit" class="btn btn-default">検索</button>--}}
            {{--</form>--}}
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