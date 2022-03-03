@extends('layouts.app')

@section('content')
<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header h5">Profile Picture</div>
                <div class="card-body text-center">
                    <form method="post" action="" enctype="multipart/form-data" id="myform">
                        <div class='preview'>
                            <img src="" alt="">
                        </div>
                        <div >
                            <input type="file" id="file" name="file" class="mb-2"/>
                            <button type="submit" class="btn btn-primary">{{ __('upload') }}</button>
                        </div>
                    </form>
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
                            <label class="small mb-1" for="name">{{ __('name') }}</label>
                            <input class="form-control" id="name" type="text" placeholder="Enter your username" value="{{ $user->name }}">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (Address)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="address">{{ __('address') }}</label>
                                <input class="form-control" id="address" type="text" placeholder="Enter your first name" value="{{ $user->address }}">
                            </div>
                            <!-- Form Group (Phone)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="phone">{{ __('phone') }}</label>
                                <input class="form-control" id="phone" type="text" placeholder="Enter your last name" value="{{ $user->phone }}">
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">{{ __('email') }}</label>
                            <input class="form-control" id="email" type="email" placeholder="Enter your email address" value="{{ $user->email }}">
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button">{{ __('save changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
