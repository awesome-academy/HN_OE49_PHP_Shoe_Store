@extends('layouts.appAdmin')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}">{{ __('create new') ." " .__('product') }}</a>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ __($message) }}</p>
        </div>
    @endif
     
    <table class="table table-index">
        <tr>
            <th>{{ __('no') }}</th>
            <th>{{ __('name') }}</th>
            <th>{{ __('brand') }}</th>
            <th>{{ __('price') }}</th>
            <th>{{ __('quantity') }}</th>
            <th width="260px">{{ __('function') }}</th>
        </tr>
    
        <tr>
        @foreach ($products as $index => $product)
            <td>{{ ++$index }}</td>
            <td>{{ $product->name }}</td>
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
@endsection
