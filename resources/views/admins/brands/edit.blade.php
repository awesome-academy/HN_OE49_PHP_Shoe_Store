@extends('layouts.appAdmin')

@section('title')
    {{ __('edit brand') }}
@endsection

@section('content')
    <form action="{{ route('brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $brand->id }}">
        <div class="mb-3 form-group">
            <label for="name" class="form-label">{{ __('brand_name') }}</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $brand->name }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 form-group">
            <label for="desc" class="form-label">{{ __('desc') }}</label>
            <textarea name="desc" id="desc" cols="30" rows="10" class="form-control">{{ $brand->desc }}</textarea>
            @error('desc')
                <div class="text-danger">{{ $message }}</div>
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
