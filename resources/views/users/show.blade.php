@extends('layouts.app')

@section('title')
    {{ __('product detail') }}
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 d-flex">
                    <div class="pro-img-details me-3">
                        <img class="card-image-style" src="{{ asset('images/products/' . $product->images->first()->name) }}">
                    </div>
                    <div class="text-center row">
                        @foreach ($product->images->skip(1)->take(3) as $image)
                            <div class="col-7 h-25">
                                <img src="{{ asset('images/products/' . $image->name) }}" alt="" width="120px" height="120px">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h1 class="box-title mt-5 fw-bold">{{ $product->name }}</h1>
                    <div>
                        @php $rating = $product->getAvgRatingAttribute(); @endphp
                        <input type="hidden" id="prd-rate" value="{{ $rating }}">
                        <div id="rateYoP"></div>
                    </div>
                    <h3 class="mt-4">{{ @money($product->price) }}</h3>
                    <button class="btn btn-dark btn-rounded mr-1" data-toggle="tooltip" title="" data-original-title="Add to cart">
                        <a href="{{ route('cart.add', $product->id) }}" class="text-white"><i class="fa fa-shopping-cart"></i></a>
                    </button>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3 class="box-title mt-5">{{ __('general info') }}</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-product">
                            <tbody>
                                <tr>
                                    <td><strong>{{ __('brand') }}<strong></td>
                                    <td>{{ $product->brand->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('desc') }}</strong></td>
                                    <td>{{ $product->desc }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @php
                        $count = 0;
                        foreach($product->comments as $comment) {
                            $count++;
                        }
                    @endphp
                    <h3 class="box-title mt-5">{{ __('comment') }} ({{ $count }})</h3>
                    <hr>
                    @if ($count == 0)
                        <p>{{ __('no comment') }}</p>
                    @endif
                    @foreach ($product->comments as $comment)
                        <div class="row mb-4">
                            <div class="col-1">
                                <div class="avt-cmt">
                                    @if ($comment->user->avatar == null)
                                        <img src="{{ asset('images/user-icon.png') }}" alt="">
                                    @else
                                        <img src="{{ asset('images/profile/' . $comment->user->avatar) }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-11">
                                <h5 class="media-heading">{{ $comment->user->name }}
                                    @php $rating = $comment->rating; @endphp
                                    @foreach (range(1, config('rating.max_rating')) as $i)
                                        @if ($rating > config('rating.min_rating'))
                                            @if ($rating > config('rating.half_rating'))
                                                <small class="fa-solid fa-star checked"></small>
                                            @else
                                                <small class="fa-solid fa-star-half-stroke checked"></small>
                                            @endif
                                        @else
                                            <small class="fa-regular fa-star checked"></small>
                                        @endif
                                        @php $rating--; @endphp
                                    @endforeach
                                </h5>
                                <span>{{ $comment->content }}</span><br>
                                @if ($comment->user_id == Auth::user()->id)
                                    <form class="ms-5" action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                        <small id="btn-edit-cmt">Edit</small>
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <small><button type="submit" id="btn-del" class="btn-delete" data-confirm="{{ __('delete confirm') }}">Delete</button></small>
                                    </form>
                                    <form method="POST" id="form-edit-cmt" class="visually-hidden" action="{{ route('comment.update', $comment->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $comment->id }}">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <textarea class="form-control" name="content" id="comment-content" 
                                            placeholder="{{ __('enter comment') }}" rows="3">{{ $comment->content }}</textarea>
                                        
                                        <button type="submit" class="btn btn-primary mt-1">{{ __('update') }}</button>
                                    </form>
                                    @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    @if ($allowComment)
                        <div class="row">
                            <div class="col-1">
                                <div class="avt-cmt">
                                    @if (Auth::user()->avatar == null)
                                        <img src="{{ asset('images/user-icon.png') }}" alt="">
                                    @else
                                        <img src="{{ asset('images/profile/' . Auth::user()->avatar) }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-11">
                                <h5 class="media-heading">{{ Auth::user()->name }}</h5>
                                <form action="{{ route('comment', $product->id) }}" id="form-comment" method="POST" role="form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="rating" id="rating" value="" />
                                    <div id="rateYo"></div>
                                    <div class="mb-3 mt-1">
                                        <textarea class="form-control" name="content" id="comment-content" placeholder="{{ __('enter comment') }}" rows="3"></textarea>
                                        @error('content')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        @if (Session::has('message'))
                                            <div class="text-success">
                                                {{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" id="btn-comment" class="btn btn-primary" value="{{ __('post comment') }}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
