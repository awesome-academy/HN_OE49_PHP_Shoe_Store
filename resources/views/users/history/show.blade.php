@extends('layouts.app')

@section('title')
    {{ __('history') }}
@endsection

@section('content')
<div class="container px-4 px-lg-5 mt-5">
    <div class="card mb-3">
        <div class="card-body">
            <div class="_1G9Cv7 "></div>
            <div class="px-3 pt-3">
                <div>
                    <span class="fs-4 title-check">
                        <i class="fa-solid fa-location-dot"></i> {{ __('delivery address')}}
                    </span>
                </div>
                <div class="d-flex fs-5">
                    <div class="col-lg-2">
                        <p class="fw-bolder">{{ Auth::user()->name }}</p>
                        <p class="fw-bolder">{{ Auth::user()->phone }}</p>
                    </div>
                    <div class="col-lg-6">{{ Auth::user()->address }}</div>
                </div>
            </div>     
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="px-3 pt-3">
                <p class="fs-4 title-check">{{ __('product') }}</p>
                <table class="table-cart table table-borderless">
                    <thead>
                        <tr>
                            <th class="w-10"></th>
                            <th>{{ __('product_name') }}</th>
                            <th class="w-10">{{ __('price') }}</th>
                            <th class="w-13">{{ __('quantity') }}</th>
                            <th class="w-15">{{ __('total price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('shop.detail', $product->id) }}">
                                        <img class="img-product" src="{{ asset('images/products/'. $product->images->first()->name) }}">
                                    </a>
                                </td>
                                <td>
                                    <div id="prdname">
                                        {{ $product->name }}
                                    </div>
                                </td>
                                <td>{{ @money($product->price) }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td class="total-price">{{ @money($product->price * $product->pivot->quantity) }}</td>
                            </tr>
                        @endforeach
                        <tr class="line-space">
                            <td colspan="4"><strong>{{ __('total') }}<strong></td>
                            <td colspan="2" class="total text-center">{{ @money($total_price) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row p-3">
                <div class="list-inline-item">
                    <span class="fs-4 title-check">{{ __('payment') }}</span>
                    <span class="fs-5 float-end">{{ __('cash') }}</span>
                </div>
                <div>
                    <table cellpadding="8" class="float-end">
                        <tbody>
                            <tr>
                                <td><strong>{{ __('total') }}<strong></td>
                                <td>{{ @money($total_price) }}</td>
                            </tr>
                            <tr>
                                <td ><strong>{{ __('shipping total') }}</strong></td>
                                <td class="float-end">{{ @money($shipping) }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('total') }}<strong></td>
                                <td class="total-check">{{ @money($total_price + $shipping) }}
                                    <input type="hidden" name="total_price" value="{{ $total_price + $shipping }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <a class="btn btn-danger" href="{{ route('user.history') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('back') }}</a>
        </div>
        <form class="col-6 text-end" action="{{ route('user.cancel', $order->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="order_status_id" value="{{ $order->orderStatus->id }}">
            <button type="submit" id="btn-cancel-order" data-cf="{{ __('confirm cancel') }}" class="btn btn-secondary">{{ __('cancel order') }}</button>
        </form>
    </div>
</div>
@endsection
