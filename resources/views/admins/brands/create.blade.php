@extends('layouts.appAdmin')

@section('title')
    {{ __('create brand') }}
@endsection

@section('content')
    <form action="{{ route('brands.store') }}" method="POST">
        @csrf
        <div class="mb-3 form-group">
            <label for="name" class="form-label">{{ __('brand_name') }}</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 form-group">
            <label for="desc" class="form-label">{{ __('desc') }}</label>
            <textarea name="desc" id="desc" cols="30" rows="10" class="form-control" required>{{ old('desc') }}</textarea>
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
