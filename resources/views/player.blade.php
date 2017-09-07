@extends('layouts.app')

@section('content')

    <div class="container">

        @if (Session::has('message'))
            <div class="alert alert-danger">{!! nl2br(e(Session::get('message'))) !!}</div>
        @endif

        <h3>基本情報</h3>

        <table class="table">

            <thead class="thead-inverse">
            <tr>
                <th>プレイヤー名</th>
                <th>最終ログイン日時</th>
            </tr>
            </thead>

            <tr>
                <td>
                    {{$player_data->name or null}}
                </td>
                <td>
                    {{$player_data->lastquit or null}}
                </td>
            </tr>
        </table>

        <hr>

        <h3>ランキング</h3>

        <table class="table">

            <thead class="thead-inverse">
            <tr>
                <th>整地量</th>
                <th>建築量</th>
                <th>ログイン時間</th>
                <th>投票数</th>
            </tr>
            </thead>

            <tr>
                <td>
                    <p>第○位</p>
                </td>
                <td>
                    <p>第○位</p>
                </td>
                <td>
                    <p>第○位</p>
                </td>
                <td>
                    <p>第○位</p>
                </td>
            </tr>
        </table>

        <hr>

        <h3>整地データ</h3>


        <div style="width:400px; float:left;">
            <h4>▼整地アイテム内訳</h4>
            <canvas id="totalBreak" style="width:120px"></canvas>
        </div>

        <div style="width:400px; float:left;">
            <h4>▼ワールド別の整地量</h4>
            <canvas id="example" style="width:120px;"></canvas>
        </div>

        <div style="clear:both;"></div>

    @include('footer')

@endsection

