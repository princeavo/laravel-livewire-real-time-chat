<div class="message @if($data['isActive']) active @endif @if($data['class']) {{ $data['class'] }} @endif"  wire:click="showConversation" onclick="document.querySelectorAll('.message.active').forEach((element)=>{
    element.classList.remove('active');
});">
<script>
    {{-- console.log(document.nextSibling); --}}
</script>
        @php
            $profile_photo = $data['profile_photo'];
            if(isset($data['scrollToUp'])){
                unset($data['scrollToUp']);
            }
        @endphp
    <div class="profileImage">
        <img src='{{ asset("storage/$profile_photo") }}' alt="">
        <div class="onlineIndicator">
        </div>
    </div>
    <div class="center">
        <h3 class="nom">{{ $data['firstname'] }}  {{ $data['lastname'] }}  {{ $data['id'] }}</h3>
        <p class="apercuMessage">
            {{ Illuminate\Support\Str::limit($data['message'] ?? "", 25) }}</p>
    </div>
        {{-- $number = random_int(-5, 9); --}}
    @php
        $number = $data['numberUnreadMessages'];
    @endphp
    @if ($number > 0)
        <div class="numberUnreadMessages">
            {{ $number }}
        </div>
    @endif
</div>




