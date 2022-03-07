@extends('layouts.app')

@section('title')
    {{ __('product detail') }}
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 d-flex">
                    <div class="pro-img-details me-3">
                        <img class="card-image-style" src="{{ asset('images/products/' . $product->images->first()->name) }}">
                    </div>
                    <div class="pro-img-list text-center">
                        @foreach ($product->images->skip(1) as $image)
                            <img src="{{ asset('images/products/' . $image->name) }}" alt="" width="120px" height="120px">
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h1 class="box-title mt-5 fw-bold">{{ $product->name }}</h1>
                    <div>
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
                        {{ number_format($product->getAvgRatingAttribute(), 1, '.', '') }}
                    </div>
                    <h3 class="mt-4">{{ @money($product->price) }}</h3>
                    <button class="btn btn-dark btn-rounded mr-1" data-toggle="tooltip" title="" data-original-title="Add to cart">
                        <a href="{{ route('cart.add', $product->id) }}"><i class="fa fa-shopping-cart"></i></a>
                    </button>
                    <button class="btn btn-danger btn-rounded">{{ __('buy now') }}</button>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3 class="box-title mt-5">{{ __('general info') }}</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-product">
                            <tbody>
                                <tr>
                                    <td><strong>{{ __('brand') }}<strong></td>
                                    <td>{{ $product->brand->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('desc') }}</strong></td>
                                    <td>{{ $product->desc }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3 class="box-title mt-5">{{ __('comment') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
