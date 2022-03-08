@extends('layouts.app')

@section('title')
    {{ __('cart') }}
@endsection

@section('content')
    <!--Timeline items start -->
<div class="timeline-items container">
    <h2>{{ __('your cart') }}</h2>
    <table class="table-cart table table-borderless">
        <thead>
            <tr>
                <th class="w-10"></th>
                <th>{{ __('product_name') }}</th>
                <th class="w-10">{{ __('price') }}</th>
                <th class="w-18">{{ __('quantity') }}</th>
                <th class="w-13">{{ __('total price') }}</th>
                <th class="w-5"></th>
            </tr>
        </thead>
        <tbody>
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
                    <td>
                        <form id="update-price" class="row g-3" action="{{ route('cart.update', $item['id']) }}">
                            <div class="col-5">
                                <input type="number" name="quantity" class="form-control" min="1" max="25" value="{{ $item['quantity'] }}">
                            </div>
                            <div class="col-7">
                                <button id="update" type="submit" class="btn btn-primary"> {{ __('update') }}</button>
                              </div>
                        </form>
                    </td>
                    <td class="total-price">{{ @money($item['price']*$item['quantity']) }}</td>
                    <td>
                        <a class="btn btn-danger" href="{{ route('cart.remove', $item['id']) }}">
                            {{ __('delete') }}
                        </a>
                    </td>
                </tr>
            @endforeach

            <tr class="total-col">
                <td colspan="4">{{ __('total') }}</td>
                <td colspan="2" class="total">{{ @money($cart->total_price) }}</td>
            </tr>
            
            <tr>
                <td class="text-end" colspan="6">
                    <a class="btn btn-warning" href="{{ route('checkout') }}">
                        {{ __('checkout') }}
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!--Timeline items end -->
@endsection
