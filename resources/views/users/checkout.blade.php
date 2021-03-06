@extends('layouts.app')

@section('title')
    {{ __('checkout') }}
@endsection

@section('content')
<div class="container px-4 px-lg-5 mt-5">
    <form action="{{ route('placeorder') }}" method="post">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="_1G9Cv7 "></div>
            <div class="px-3 pt-3">
                <p class="fs-4 title-check">
                    <i class="fa-solid fa-location-dot"></i> {{ __('delivery address')}}
                </p>
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
                        @if (Session::has('cart'))
                            @foreach ($cart->items as $item)
                            <tr>
                                <td>
                                    <img class="img-product" src="{{ asset('images/products/'. $item['image']) }}">
                                </td>
                                <td>
                                    <div id="prdname">
                                        {{ $item['name'] }}
                                    </div>
                                </td>
                                <td>{{ @money($item['price']) }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td class="total-price">{{ @money($item['price']*$item['quantity']) }}</td>
                            </tr>
                            @endforeach
                        @endif
                        <tr class="line-space">
                            <td colspan="4"><strong>{{ __('total') }}<strong></td>
                            <td colspan="2" class="total text-center">{{ @money($cart->total_price) }}</td>
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
                        @php $total_price = 0; @endphp
                        @foreach ($cart->items as $item)
                            @php $total_price += $item['price']*$item['quantity'] @endphp
                        @endforeach
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
            <div class="line-space">
                <button type="submit" class="btn btn-danger float-end mt-3 fs-5 py-1">{{ __('place order') }}</button>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection
