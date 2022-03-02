@extends('layouts.appAdmin')
@section('title')
    __('update')
@endsection

@section('content')
<div id="form-update-user">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" value="{{ $user->id }}">
        <table>
        <tr>
            <td>
              <label for="name" class="col-form-label ">{{ __('name') }}</label>
            </td>
            <td>
              <input type="text" disabled id="name" class="form-control" value="{{ $user->name }}">
            </td>
        </tr>
        <tr>
            <td>
              <label for="phone" class="col-form-label">{{ __('phone') }}</label>
            </td>
            <td>
              <input type="text" disabled id="phone" class="form-control" value="{{ $user->phone }}">
            </td>
        </tr><tr>
            <td>
              <label for="address" class="col-form-label">{{ __('address') }}</label>
            </td>
            <td>
              <input type="text" disabled id="address" class="form-control" value="{{ $user->address }}">
            </td>
        </tr><tr>
            <td>
              <label for="email" class="col-form-label">{{ __('email') }}</label>
            </td>
            <td>
              <input type="text" disabled id="email" class="form-control" value="{{ $user->email }}">
            </td>
        </tr>
        <tr>
            <td>
              <label for="status" class="col-form-label">{{ __('status') }}</label>
            </td>
            <td>
                @if ($user->status == config('auth.status.lock'))
                    <input type="radio" id="lock" name="status" value="{{ config('auth.status.lock') }}" checked>
                    <label for="lock"><i class="fa-solid fa-lock"></i></label>
                    <input type="radio" id="unlock" name="status" value="{{ config('auth.status.unlock') }}">
                    <label for="unlock"><i class="fa-solid fa-unlock"></i></label>
                @else   
                    <input type="radio" id="lock" name="status" value="{{ config('auth.status.lock') }}">
                    <label for="lock"><i class="fa-solid fa-lock"></i></label>
                    <input type="radio" id="unlock" name="status" value="{{ config('auth.status.unlock') }}" checked>
                    <label for="unlock"><i class="fa-solid fa-unlock"></i></label>
                @endif
            </td>
        <tr>
        <tr>
            <td colspan="2">
                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('submit') }}</button>
                <a class="btn btn-danger" href="{{ route('users.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('back') }}</a>
            </td>
        </tr>
        </table>
    </form>
</div>
@endsection
