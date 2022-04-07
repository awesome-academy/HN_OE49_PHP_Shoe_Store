@extends('layouts.appAdmin')

@section('title')
    {{ __('dashboard') }}
@endsection
@section('content')
    @if ($message = Session::get('noti'))
        <h3> {{ $message }} </h3>
    @endif
    <form action="{{ route('admin') }}" method="GET" class="row">
        @csrf
        <div class="col-2">
            <select name="filter" class="form-select" id="">
                <option value="day" @if (request()->filter == 'day') selected @endif>{{ __('7 days ago') }}</option>
                <option value="month" @if (request()->filter == 'month') selected @endif>{{ __('sub month') }}</option>
            </select>
        </div>
        <button type="submit" id="btn-filter" class="btn btn-secondary col-1">{{ __('filter') }}</button>
    </form>
    <canvas id="myChart" height="80px"></canvas>
    <script>
        var brand_labels = JSON.parse('{!! json_encode($label) !!}');
        var brand_quantity = JSON.parse('{!! json_encode($quantity) !!}');
    </script>
    <script src="{{ asset('js/statistic.js') }}"></script>
@endsection
