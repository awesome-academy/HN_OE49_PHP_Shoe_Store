@extends('layouts.appAdmin')

@section('title')
    {{ __('order detail') }}
@endsection

@section('content')
    <div class="mb-3 col-6">
        <strong>{{ __('name') }}</strong>
        <p>{{ $order->user->name }}</p>
    </div>

    <div class="mb-3 col-6">
        <strong>{{ __('phone') }}</strong>
        <p>{{ $order->user->phone }}</p>
    </div>

    <div class="mb-3">
        <strong>{{ __('address') }}</strong>
        <p>{{ $order->user->address }}</p>
    </div>

    <div class="mb-3">
        <strong>{{ __('list') . __('product') }}</strong>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('product_name') }}</th>
                    <th class="text-center">{{ __('price') }}</th>
                    <th class="text-center">{{ __('quantity') }}</th>
                    <th class="text-center">{{ __('total price') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <td><div id="desc">{{ $product->name }}</div></td>
                        <td class="text-center">{{ @money($product->price) }}</td>
                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                        <td class="text-center">{{ @money($product->price * $product->pivot->quantity) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="mb-3">
        <strong>{{ __('total') }}</strong>
        <p>{{ @money($order->total_price) }}</p>
    </div>

    <div class="mb-3">
        <strong>{{ __('status') }}</strong>
        <div>
            @switch($order->orderStatus->id)
                @case(config('orderstatus.delivered'))
                    <span class="badge bg-gradient-faded-success">{{ $order->orderStatus->name }}</span>
                    @break
                @case(config('orderstatus.cancelled'))
                    <span class="badge bg-gradient-secondary">{{ $order->orderStatus->name }}</span>
                    @break
                @default
                    <span class="badge bg-gradient-faded-warning">{{ $order->orderStatus->name }}</span>
            @endswitch
        </div>
    </div>

    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> {{ __('update order') }}</a>

@endsection
