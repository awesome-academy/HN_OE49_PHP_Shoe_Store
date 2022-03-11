@extends('layouts.app')

@section('title')
    {{ __('product') }}
@endsection

@section('content')
<div class="container px-4 px-lg-5 ">
    <div>
        <div class="d-flex justify-content-end mb-5">
            <form class="row" action="{{ route('home') }}">
                <div class="mb-3 col-6">
                    <label class="pt-2 ms-3">{{ __('price') }}</label>
                    <div class="input-group">
                        <input type="number" min="0" name="min_price" class="form-control" placeholder="Ex: 1000000"
                            value="{{ request()->min_price ? request()->min_price : '' }}">
                        <span class="input-group-text"><i class="fa-solid fa-arrows-left-right ps-0 pe-0 pt-1"></i></span>
                        <input type="number" min="0" name="max_price" class="form-control" placeholder="Ex: 3000000"
                            value="{{ request()->max_price ? request()->max_price : '' }}">
                    </div>                    
                </div>
                <div class="mb-3 col-6">
                    <label class="pt-2 ms-3 ">{{ __('product_name') }}</label>
                    <input type="text" name="name" class="form-control" placeholder="Nike Dunk Low ..."
                        value="{{ request()->name ? request()->name : '' }}">
                </div>
                <div class="col-12 mb-3 text-end">
                    <button type="submit" class="btn btn-success col-2">
                        <i class="fas fa-search"></i> {{ __('search') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach ($products as $product)
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- product image-->
                    <div class="card-image">
                        <a href="{{ route('shop.detail', $product->id) }}">
                            <img class="card-img-top" src="{{ asset('images/products/' . $product->images->first()->name) }}">
                        </a>
                    </div>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                            <!-- Product review -->
                            @php $rating = $product->getAvgRatingAttribute(); @endphp
                            @foreach (range(1, config('rating.max_rating')) as $i)
                                @if ($rating > config('rating.min_rating'))
                                    @if ($rating > config('rating.half_rating'))
                                        <span class="fa-solid fa-star checked"></span>
                                    @else
                                        <span class="fa-solid fa-star-half-stroke checked"></span>
                                    @endif
                                @else
                                    <span class="fa-regular fa-star checked"></span>
                                @endif
                                @php $rating--; @endphp
                            @endforeach
                            {{ number_format($product->getAvgRatingAttribute(), 1, '.', ',') }}
                            <!-- Product price-->
                            <p class="mt-3 fs-5">{{ @money($product->price) }}</p>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('cart.add', $product->id) }}">{{ __('add to cart') }}</a></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="text-center">
    {!! $products->appends(request()->all())->links() !!}
</div>
@endsection
