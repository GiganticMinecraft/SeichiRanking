
@extends('content')

@section('ranking')

{{--    @if ($navbar_act == 'total')--}}
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
                        総整地量：{{ number_format($item->totalbreaknum) }}<br>
                        Last loign: {{$item->lastquit}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $ranking_data->render() !!}

    {{--@else--}}
        ※ 実装中
    {{--@endif--}}

@endsection