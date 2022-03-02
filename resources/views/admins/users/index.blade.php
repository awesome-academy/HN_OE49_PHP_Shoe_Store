@extends('layouts.appAdmin')

@section('title')
    {{ __('list') . __('user') }}
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h2>{{ __('list') . __('user') }}</h2>
</div>
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>{{ __('name') }}</th>
            <th>{{ __('phone') }}</th>
            <th>{{ __('address') }}</th>
            <th>{{ __('email') }}</th>
            <th>{{ __('role') }}</th>
            <th>{{ __('status') }}</th>
            <th class="w-10">{{ __('function') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name }}</td>
                <td>
                    @if ($user->status == config('auth.status.lock'))
                        <i class="fa-solid fa-lock"></i>
                    @else
                        <i class="fa-solid fa-unlock"></i>
                    @endif
                </td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
