@extends('layouts.app')

@section('title')
    {{ __('history') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="panel-heading">
                <h4 class="mb-3">{{ __('history') }}</h4>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">{{ __('number product') }}</th>
                        <th class="text-center">{{ __('total price') }}</th>
                        <th class="text-center">{{ __('status') }}</th>
                        <th class="w-10 text-center">{{ __('show') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="text-center">{{ $order->id }}</td>
                            <td class="text-center">{{ $order->products->count() }}</td>
                            <td class="text-center">{{ @money($order->total_price) }}</td>
                            <td class="text-center">
                                @switch($order->orderStatus->id)
                                    @case(config('orderstatus.delivered'))
                                        <span class="badge bg-success">{{ ucfirst($order->orderStatus->name) }}</span>
                                        @break
                                    @case(config('orderstatus.cancelled'))
                                        <span class="badge bg-secondary">{{ ucfirst($order->orderStatus->name) }}</span>
                                        @break
                                    @default
                                        <span class="badge bg-warning">{{ ucfirst($order->orderStatus->name) }}</span>
                                @endswitch
                            </td>
                            <td class="text-center">
                                <a href="{{ route('user.history.detail', $order->id) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection('content')
