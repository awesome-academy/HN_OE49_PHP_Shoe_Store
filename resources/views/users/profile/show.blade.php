@extends('layouts.app')

@section('content')
@if ($mess = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ __($mess) }}</p>
    </div>
@endif
<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header h5">{{ __('avatar') }}</div>
                <div class="card-body text-center">
                    <div class="d-flex flex-column align-items-center text-center py-2">
                        <img class="img-show" id="avt" src="
                            @if ($user->avatar == null)
                                {{ asset('images/user-icon.png') }}
                            @else
                                {{ asset('images/profile/' . $user->avatar) }} 
                            @endif"
                        alt="">
                    </div>
                    <a href="{{ route('user.profile.edit', $user->id) }}" class="btn btn-outline-dark mt-2">{{ __('edit profile') }}</a>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header h5">{{ __('profile') }}</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <strong class="me-4">{{ __('name') }}:</strong>
                            {{ $user->name }}
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (Address)-->
                            <div class="col-md-6">
                                <strong class="me-4">{{ __('address') }}:</strong>
                                {{ $user->address }}
                            </div>
                            <!-- Form Group (Phone)-->
                            <div class="col-md-6">
                                <strong class="me-4">{{ __('phone') }}:</strong>
                                {{ $user->phone }}
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <strong class="me-4">{{ __('email') }}:</strong>
                            {{ $user->email }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
