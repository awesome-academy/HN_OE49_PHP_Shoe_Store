@extends('layouts.appAdmin')

@section('title')
    {{ __('create') . " " .__('product') }}
@endsection

@section('content')
    @if ($mess = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ __($mess) }}</p>
        </div>
    @endif

    <h4>{{ __('create new') ." " .__('product') }}</h4><br>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="name">{{ __('product_name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            @error('name') 
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="price">{{ __('price') }}</label>
                <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
                @error('price') 
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="quantity">{{ __('quantity') }}</label>
                <input type="text" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}">
                @error('quantity') 
                    <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="">{{ __('brand') }}</label>
            <select class="form-select" name='brand_id'>
                <option selected></option>
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
            <textarea name="desc" id="desc" rows="4" class="form-control">{{ old('desc') }}</textarea>
            @error('desc')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="image">{{ __('img') }}</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
            @error('images') 
                <span class="text-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="tile-footer mb-3">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('submit') }}</button>
                    <a class="btn btn-danger" href="{{ route('products.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('back') }}</a>
                </div>
            </div>
        </div>
    </form>
@endsection
