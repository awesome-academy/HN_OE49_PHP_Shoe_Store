@extends('layouts.appAdmin')

@section('title')
    {{ __('update order') }}
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

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" value="{{ $order->id }}">
        <div class="mb-3">
            <label for="status">{{ __('status') }}</label>
            <select name="order_status_id" id="status" class="form-select">
                @foreach ($statuses as $status)
                    @php
                        $selected = '';
                        if ($status->name == $order->orderStatus->name) {
                            $selected = "selected";
                        }
                    @endphp
                    <option value="{{ $status->id }}" {{ $selected }}>{{ Str::ucfirst($status->name) }}</option>
                @endforeach
            </select>
            @error('order_status_id') 
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>
        <div class="tile-footer mb-3">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" id="update-order-status" type="submit" data-cf="{{ __('sure update') }}">
                        <i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('submit') }}
                    </button>
                    <a class="btn btn-danger" href="{{ route('brands.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('back') }}</a>
                </div>
            </div>
        </div>
    </form> 

@endsection
