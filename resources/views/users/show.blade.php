@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 me-4">
                    <div class="pro-img-details mb-2">
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
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                    <h3 class="mt-4">{{ @money($product->price) }}</h3>
                    <button class="btn btn-dark btn-rounded mr-1" data-toggle="tooltip" title="" data-original-title="Add to cart">
                        <i class="fa fa-shopping-cart"></i>
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
