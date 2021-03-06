@extends('layouts.appAdmin')

@section('title')
    {{ __('dashboard') }}
@endsection
@section('content')
    @if ($message = Session::get('noti'))
        <h3> {{ $message }} </h3>
    @endif
    <form action="" method="GET" class="row">
        @csrf
        <div class="col-2">
            <select name="filter" class="form-select" id="filter">
                <option hidden>{{ __('sub day') }}</option>
                <option value="day" @if (request()->filter == 'day') selected @endif>{{ __('today') }}</option>
                <option value="week" @if (request()->filter == 'week') selected @endif>{{ __('sub day') }}</option>
                <option value="month" @if (request()->filter == 'month') selected @endif>{{ __('sub month') }}</option>
            </select>
        </div>
        <button type="button" id="btn-filter" class="btn btn-secondary col-1">{{ __('filter') }}</button>
    </form>
    <canvas id="myChart" height="80px"></canvas>
    <script>
        var label = JSON.parse('{!! json_encode(__("quantity sold")) !!}')
        var brand_labels = JSON.parse('{!! json_encode($label) !!}');
        var brand_quantity = JSON.parse('{!! json_encode($quantity1) !!}');
        var brand_quantity2 = JSON.parse('{!! json_encode($quantity2) !!}');
        var brand_quantity3 = JSON.parse('{!! json_encode($quantity3) !!}');
    </script>
@endsection
