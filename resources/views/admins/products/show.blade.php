@extends('layouts.appAdmin')

@section('title')
    {{ __('show') . " " .__('product') }}
@endsection

@section('content')
    @if ($message = Session::has('success'))
        <div class="alert alert-success">
            {{ __($message) }}
        </div>
    @endif

    <h4>{{ __('show') ." " .__('product') }}</h4><br>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <strong>{{ __('product_name') }}</strong>
            <p>{{ $product->name }}</p>
        </div>
        
        <div class="row">
            <div class="form-group mb-3 col-md-6">
                <strong>{{ __('price') }}</strong>
                <p>{{ $product->price}}</p>
            </div>

            <div class="form-group mb-3 col-md-6">
                <strong>{{ __('quantity') }}</strong>
                <p>{{ $product->quantity }}</p>
            </div>
        </div>
        
        <div class="form-group mb-3">
            <strong>{{ __('brand') }}</strong>
            <p>{{ $product->brand->name }}</p>
        </div>

        <div class="form-group mb-3">
            <strong>{{ __('desc') }}</strong>
            <p>{{ $product->desc }}<p>
        </div>

        <div class="form-group mb-3">
            <strong>{{ __('img') }}</label>
            <div>
            @foreach ($images as $image) 
                <img src="{{ asset('images/products/' .$image->name) }}" height="150px" width="150px" class="me-2" alt="">
            @endforeach
            </div>
        </div>

        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <a class="btn btn-danger" href="{{ route('products.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('back') }}</a>
                </div>
            </div>
        </div>
    </form>
@endsection
