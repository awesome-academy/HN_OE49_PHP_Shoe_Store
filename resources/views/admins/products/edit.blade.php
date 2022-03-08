@extends('layouts.appAdmin')

@section('title')
    {{ __('edit') . " " .__('product') }}
@endsection

@section('content')
    @if ($message = Session::has('success'))
        <div class="alert alert-success">
            {{ __($message) }}
        </div>
    @endif

    <h4>{{ __('edit') ." " .__('product') }}</h4><br>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">{{ __('product_name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
            @error('name') 
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>
        
        <div class="row">
            <div class="form-group mb-3 col-md-6">
                <label for="price">{{ __('price') }}</label>
                <input type="text" name="price" id="price" class="form-control" value="{{ $product->price}}">
                @error('price') 
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="quantity">{{ __('quantity') }}</label>
                <input type="text" name="quantity" id="quantity" class="form-control" value="{{ $product->quantity }}">
                @error('quantity') 
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group mb-3">
            <label for="">{{ __('brand') }}</label>
            <select class="form-select" name="brand_id">
                @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            @error('brand_id') 
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="desc" class="form-label">{{ __('desc') }}</label>
            <textarea name="desc" id="desc" rows="4" class="form-control">{{ $product->desc }}</textarea>
            @error('desc')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="image">{{ __('img') }}</label>
            <div class="mb-3">
            @foreach ($images as $image) 
                <img src="{{ asset('images/products/' . $image->name) }}" height="120px" width="120px" class="me-2" alt="">
            @endforeach
            </div>
            <input type="file" class="form-control" id="images" name="images[]" multiple value="{{ $image->name }}">
            @error('images') 
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('update') }}</button>
                    <a class="btn btn-danger" href="{{ route('products.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('back') }}</a>
                </div>
            </div>
        </div>
    </form>
@endsection
