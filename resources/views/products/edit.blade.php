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

    <form action="" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="">
            @error('name') 
                <span class="alert-danger"> {{ $message }}</span>
            @enderror
        </div>
        
        <div class="row">
            <div class="form-group col-md-6">
                <label for="price">{{ __('price') }}</label>
                <input type="text" name="price" id="price" class="form-control" value="">
                @error('price') 
                    <span class="alert-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="quantity">{{ __('quantity') }}</label>
                <input type="text" name="quantity" id="quantity" class="form-control" value="">
                @error('quantity') 
                    <span class="alert-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label for="">{{ __('brand') }}</label>
            <select class="form-select">
                <option value=""></option>
            </select>
            @error('') 
                <span class="alert-danger"> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">{{ __('image') }}</label>
            <input type="file" class="form-control" id="image">
            @error('') 
                <span class="alert-danger"> {{ $message }}</span>
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
