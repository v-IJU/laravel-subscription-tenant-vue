@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ isset(Configurations::getConfig('site')->site_icon) ? URL::asset(Configurations::getConfig('site')->site_icon) : '' }}"
                style="width: 80px;" alt="{{ config('app.name') }}" />
        @endcomponent
    @endslot
    {{-- Body --}}
    <strong>Hi {{ $user->first_name }} {{ $user->last_name }}</strong>
    <p>Your Login credentials</p>
    <p>Username : <strong>{{ $user->username }}</strong></p>
    <p>Password : <strong>{{ $password }}</strong></p>
    @component('mail::button', ['url' => route('backendlogin')])
        Login
    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ config('app.name') }}.</h6>
        @endcomponent
    @endslot
@endcomponent
