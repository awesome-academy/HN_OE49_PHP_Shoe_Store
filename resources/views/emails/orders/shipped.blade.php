@component('mail::message')
Notification

<h2 style="text-align: center">{{ __('thanks order') }}</h2>
<div>
    <p style="font-size: 16px">Hello, {{ $user->name }}</p>
    <p>{{ __('receive require') }}</p>
</div>

@component('mail::table')
|               | {{ __('product_name') }} | {{ __('price') }}    | {{ __('quantity') }}  |  {{ __('total price') }}     |
| :------------ |:--------------| :--------| :---------| :-----------|
@foreach ($cart->items as $item)
|<img width="50" src="{{ asset('images/products/'. $item['image']) }}">| {{ $item['name'] }}| {{ @money($item['price']) }}| {{ $item['quantity'] }} |{{ @money($item['price']*$item['quantity']) }}
@endforeach
@endcomponent

<div>
    <p>{{ __('note') }}</p>
</div>

@component('mail::button', ['url' => $url, 'color' => 'success'])
{{ __('show order status') }}
@endcomponent

Thanks,<br>
Anh Shoe
@endcomponent
