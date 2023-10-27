<div class="top">
    @isset($data['discussion'])
    <div class="left">
        <div class="profileImage">
            <img src="{{ asset("storage/{$data['discussion']['user']['profile_photo']}") }}" alt="">
            <div class="onlineIndicator">
            </div>
        </div>
        <div class="center">
            <h3 class="nom">{{ $data['discussion']['user']["firstname"] }} {{$data['discussion']['user']["lastname"] }}</h3>
            <p class="apercuMessage">Online</p>
        </div>
    </div>
    <div class="right">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="details">
        {{-- <img src="{{ asset('images/auth/favicon.png') }}" alt=""> --}}
        <input class="star" type="checkbox" title="Favori?"  wire:model='bool'>
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
    </div>
    @endisset
    @isset($data['groupe'])
    <div class="left">
        <div class="profileImage">
            <img src="{{ asset("storage/{$data['groupe']['photo']}") }}" alt="">
            <div class="onlineIndicator">
            </div>
        </div>
        <div class="center">
            <h3 class="nom">{{ $data['groupe']['nom'] }}</h3>
            <p class="apercuMessage">Online</p>
        </div>
    </div>
    <div class="right">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="details">
        {{-- <img src="{{ asset('images/auth/favicon.png') }}" alt=""> --}}
        <input class="star" type="checkbox" title="Favori?" wire:model='bool'>
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
    </div>
    @endisset
</div>
