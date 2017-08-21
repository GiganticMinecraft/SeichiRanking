@extends('layouts.admin')

@section('content')
    <h3>アカウント管理</h3>

    <div style="margin-top:10px">
        @if (count($account_list) > 0)
            <table class="table table-sm table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>区分</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($account_list as $key => $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">
                お問い合わせは0件です
            </div>
        @endif

        {!! $account_list->links() !!}

    </div>


@endsection

