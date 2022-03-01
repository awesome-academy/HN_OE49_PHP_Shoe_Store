@extends('layouts.appAdmin')

@section('title')
    {{ __('list') . __('brand') }}
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h2>{{ __('list') . __('brand') }}</h2>
    <a href="{{ route('brands.create') }}" class="btn btn-info">
        <i class="fa-light fa-plus"></i> {{ __('create new') }}
    </a>
</div>
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th class="w-20">{{ __('brand_name') }}</th>
            <th>{{ __('desc') }}</th>
            <th class="w-20">{{ __('function') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brands as $brand)
            <tr>
                <td>{{ $brand->name }}</td>
                <td>
                    <div class="overflow-hidden" id="desc">
                        {{ $brand->desc }}
                    </div>
                </td>
                <td>
                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                        <a href="{{ route('brands.edit', $brand->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        @csrf
                        @method("DELETE")
                        <button id="btn-del" type="submit" class="btn-delete" data-confirm="{{ __('delete confirm') }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
