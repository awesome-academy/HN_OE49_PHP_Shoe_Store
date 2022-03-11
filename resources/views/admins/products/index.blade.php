@extends('layouts.appAdmin')

@section('content')
    <div class="row">
        <div class="col-5">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}">{{ __('create new') ." " .__('product') }}</a>
            </div>
        </div>
        <div class="col-7">
            <form action="{{ route('products.index') }}" class="d-flex justify-content-end">
                <select name="brand_id" class="form-control w-30 me-3">
                    <option class="text-center" disabled selected>----- Select Brand -----</option>
                    @foreach ($brands as $brand)
                        @php
                            $selected = '';
                            if (request()->brand_id == $brand->id) {
                                $selected = 'selected';
                            }
                        @endphp
                        <option value="{{ $brand->id }}" {{ $selected }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
                <input class="form-control w-30 me-3" type="text" placeholder="{{ __('enter product name') }}" name="name" value="{{ request()->name ? request()->name : '' }}">
                <button class="btn btn-secondary mb-0" type="submit">Search</button>
            </form>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>{{ __('no') }}</th>
                <th>{{ __('product_name') }}</th>
                <th>{{ __('brand') }}</th>
                <th>{{ __('price') }}</th>
                <th>{{ __('quantity') }}</th>
                <th width="260px">{{ __('function') }}</th>
            </tr>
        </thead>
        @foreach ($products as $index => $product).
            <tr>
                <td>{{ ++$index }}</td>
                <td>
                    <div id="desc">
                        {{ $product->name }}
                    </div>
                </td>
                <td>{{ $product->brand->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        <a href="{{ route('products.show', $product->id) }}" class="me-1"><i class="fa-solid fa-eye"></i> </a>
                        <a href="{{ route('products.edit', $product->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btn-del" class="btn-delete" data-confirm="{{ __('delete confirm') }}"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach    
    </table>
    {!! $products->appends(request()->all())->links() !!}
@endsection
