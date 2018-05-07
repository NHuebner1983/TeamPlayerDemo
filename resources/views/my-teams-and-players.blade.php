@extends('themes.laravel-default')

@section('content')

    @include('_partials.demo-css')

    <div class="flex-center position-ref">
        <div class="content">
            <div class="title m-b-md">
                Demo Team/Players
            </div>
            <div id="app">
                <my-teams-and-players-api></my-teams-and-players-api>
            </div>
        </div>
    </div>

@endsection
