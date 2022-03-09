@extends('layouts.appAdmin')

@section('title')
    {{ __('list') . __('order') }}
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h2>{{ __('list') . __('order') }}</h2>
</div>
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th class="text-center">ID</th>
            <th>{{ __('name') }}</th>
            <th>{{ __('phone') }}</th>
            <th class="text-center">{{ __('number product') }}</th>
            <th class="text-center">{{ __('total') }}</th>
            <th class="text-center">{{ __('status') }}</th>
            <th class="w-10 text-center">{{ __('function') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td class="text-center">{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->phone }}</td>
                <td class="text-center">{{ $order->products->count() }}</td>
                <td class="text-center">{{ @money($order->total_price) }}</td>
                <td class="text-center">
                    <span class="badge bg-gradient-faded-danger">{{ $order->orderStatus->name }}</span>
                </td>
                <td class="text-center">
                    <a href="{{ route('orders.show', $order->id) }}">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('orders.edit', $order->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $orders->appends(request()->all())->links() !!}
@endsection
