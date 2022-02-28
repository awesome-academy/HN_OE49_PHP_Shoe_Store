@extends('layouts.appAdmin')

@section('title')
    {{ __('dashboard') }}
@endsection
@section('content')
    @if ($message = Session::get('noti'))
        <h3> {{ $message }} </h3>
    @endif
@endsection
