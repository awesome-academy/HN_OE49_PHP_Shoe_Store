@extends('layouts.app')

@section('title')
    {{ __('edit profile') }}
@endsection

@section('content')
<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <form action="{{ route('user.profile.update', $user->id) }}" method="POST" id="form-profile" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header h5">{{ __('avatar')}}</div>
                <div class="card-body text-center">
                    <div class="d-flex flex-column align-items-center text-center py-2">
                        <img class="rounded-circle img-show mb-3" id="img_preview" src="
                            @if ($user->avatar == null)
                                {{ asset('images/user-icon.png') }}
                            @else
                                {{ asset('images/profile/' . $user->avatar) }} 
                            @endif"
                        alt="">
                    </div>
                    <div >
                        <input type="file" id="img_profile" name="avatar" class="mb-3"/>
                    </div>
                    @error('avatar') 
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header h5">{{ __('profile') }}</div>
                    <div class="card-body">
                        <!-- Form Group (username)-->
                        <div class="mb-2">
                            <label class="form-label mb-1" for="name">{{ __('name') }}</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ $user->name }}">
                            @error('name') 
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-2">
                            <!-- Form Group (Address)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="address">{{ __('address') }}</label>
                                <input class="form-control" id="address" name="address" type="text" value="{{ $user->address }}">
                                @error('address') 
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Group (Phone)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="phone">{{ __('phone') }}</label>
                                <input class="form-control" id="phone" name="phone" type="text" value="{{ $user->phone }}">
                                @error('phone') 
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-2">
                            <label class="form-label mb-1" for="email">{{ __('email') }}</label>
                            <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}">
                            @error('email') 
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary mt-4 mb-1" type="submit">{{ __('save changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
