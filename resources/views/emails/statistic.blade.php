@component('mail::message')
<b>{{ __('statistic order') }}</b>
<p>{{ __('from date') }}: {{ $fromDate }}</p>
<p>{{ __ ('to date') }}: {{ $toDate }}</p>
<br>
<h2 style="text-align: center">{{ __('table') }}</h2>

@component('mail::table')
    @php
        $num = 1;
        $total = 0;
    @endphp
    | {{ __('#') }} | {{ __('order_id') }} | {{ __('total price') }} | {{ __('created_at') }} | {{ __('updated_at_delivered') }}|
    | :----------: |:---------------:| :------------------:|:-----------------:| :-----------------:|
    @foreach ($datas as $data)
        @php
            $total += $data->total_price;
        @endphp
    | {{ $num++ }} | {{ $data['id'] }} | {{ @money($data['total_price']) }}| {{ $data['created_at']->toDateString() }} | {{ $data['updated_at']->toDateString() }} | 
    @endforeach
@endcomponent

<h2 style="float: right; background-color:forestgreen; color:#fff; padding: 8px">{{ __('total') }}: {{ @money($total) }}</h2>

@endcomponent
