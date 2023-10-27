<div>
    @if($data)
    <div class="message  @if($data['isActive']) active @endif" onclick="document.querySelectorAll('.message.active').forEach((element)=>{
        element.classList.remove('active');
    });"  wire:click="showConversation">
        <div class="profileImage">
            <img src="{{ asset("storage/{$data['photo']}") }}" alt="">
            <div class="onlineIndicator">
            </div>
        </div>
        <div class="center">
            <h3 class="nom">{{ $data['nom'] }}</h3>
            <p class="apercuMessage">
                {{-- {{ Illuminate\Support\Str::limit($lastMessage == null ? '' : $lastMessage->contenu , 25) }} --}}
                {{-- {{ $discussionsFavorite->id }} --}}
                {{ $data['nombresMembres'] }} membres
            </p>
        </div>
        @if ($data['numberUnreadMessages'] > 0)
            <div class="numberUnreadMessages">
                {{ $data['numberUnreadMessages'] }}
            </div>
        @endif
    </div>

    @endif
</div>
