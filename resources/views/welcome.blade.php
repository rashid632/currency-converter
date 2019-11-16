@extends('layouts.front')

@section('content')
<div class="converter">
    <div class="title m-b-md h1 text-center my-5">
        Currency Converter
    </div>

    @include('partials.form')

    @include('partials.result')

    @include('partials.errors')
</div>


@endsection