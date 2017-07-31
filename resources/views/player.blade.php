@extends('layouts.app')

@section('content')

    <div class="container">

        <h1>プレイヤー詳細ページ</h1>

        @if (Session::has('message'))
            <div class="alert alert-danger">{!! nl2br(e(Session::get('message'))) !!}</div>
        @endif


        <table class="table">

            <thead class="thead-inverse">
                <tr>
                    <th>プレイヤー名</th>
                    <th>最終ログイン日時</th>
                </tr>
            </thead>

            <tr>
                <td>
                    {{$player_data->name}}
                </td>
                <td>
                    {{$player_data->lastquit}}
                </td>
            </tr>
        </table>

    </div>

    @include('footer')

@endsection

