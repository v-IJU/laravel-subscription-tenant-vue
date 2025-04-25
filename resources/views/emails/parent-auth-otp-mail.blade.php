@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ @Configurations::getConfig('site')->site_logo ? URL::asset(Configurations::getConfig('site')->site_logo) : '#' }}"
                alt="" width="50">
        @endcomponent
    @endslot
    {{-- Body --}}
    <div>
        <h2>Hello! </h2>
        <span>Your One Time Password For Verification is {{ @$data['otp'] }}</span>
        <p>Thanks & Regards,</p>
        {{ isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : 'Vivek Tailor' }}
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} .
                {{ isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : 'Vivek Tailor' }}
            </h6>
        @endcomponent
    @endslot
@endcomponent
