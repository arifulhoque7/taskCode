<footer {{ $attributes->merge(['class'=>'']) }}>
    <div class="">
        <div class="copy">© {{ date('Y') }} <a class="text-capitalize" href="{{ config('app.url') }}" target="_blank">{{
                config('app.name')
                }}</a>.</div>
        <div class="credit">{{ __('Designed & Developed by') }}: <a href="https://www.arif.com/" target="_blank">{{
                __('arif') }}<a></div>
    </div>
</footer>