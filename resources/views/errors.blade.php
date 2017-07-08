@extends('layouts.app')

@section('content')

    <div class="container">
        @if (Session::has('flash_message'))
            <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
        @endif

        <br>
        <div class="alert alert-danger mt-1">
            {{$message}}
        </div>

    </div>

    @include('footer')

@endsection
