<div class="flex justify-center">
    @foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale === $current_locale)
            <span class="btn btn-primary">{{ $locale_name }}</span>
        @else
            <a class="btn" href="{{ route('lang', ['locale' => $available_locale]) }}">
                <span>{{ $locale_name }}</span>
            </a>
        @endif
    @endforeach
</div>
