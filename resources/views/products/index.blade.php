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
            <th width="260px">{{ __('action') }}</th>
        </tr>
    
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <form action="" method="POST">
                    <a class="btn btn-info" href="">{{ __('show') }}</a>
                    <a class="btn btn-primary" href="">{{ __('edit') }}</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-delete" data-confirm="{{ __('delete confirm') }}">{{ __('delete') }}</button>
                </form>
            </td>
        </tr>    
    </table>
    <script type="text/javascript" src="{{ asset('js/delete.js') }}"></script>
@endsection
