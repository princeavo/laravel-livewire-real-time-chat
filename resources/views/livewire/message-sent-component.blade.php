<div @class(['conversationSend' => $data])>
    @isset($data['contenu'])
    <div class="maxWidth">
        <div class="sendConversation">
            @if(isset($data['image']) && $data['image'])
            <div>
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($data['image']) }}" alt="" style="width:250px;border-radius:5px">
            </div>
            <div class="sendMessage" style="text-align: center;margin-top:15px" @if($this->est_emoji($data['contenu'])) style="font-size:70px" @elseif(isset($data['isDeleted']) && $data['isDeleted']) style="font-weight: 700"  @endif>
                {{ $data['contenu'] }}
            </div>
            @else
            <div class="sendMessage"  @if($this->est_emoji($data['contenu'])) style="font-size:70px" @elseif(isset($data['isDeleted']) && $data['isDeleted']) style="font-weight: 700"  @endif >
                {{ $data['contenu'] }}
            </div>
            @endif
            @if(!(isset($data['isDeleted']) && $data['isDeleted']))
            <div class="dropdown options option">
                <button class="btn" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">...</button>
                <div class="dropdown-menu">
                    <div class="dropdown-item "><i class="fa fa-reply"></i> Reply</div>
                    <div class="dropdown-item" data-toggle="modal" data-target="#forwardMessageModal" wire:click='forwadMessage'> <i class="fa fa-share"></i> Forward
                    </div>
                    <div class="dropdown-item"><i class="fa fa-copy"></i> Copy</div>

                    @if(!$this->data['isSaved'])
                        <div class="dropdown-item"
                            wire:click='addMessageToDiscussionBookMark '>
                            <i class="fa fa-book-bookmark"></i>
                            Bookmark
                        </div>
                    @else
                        <div class="dropdown-item"
                            wire:click='deleteMessageToDiscussionBookMark '>
                            <i class="fa fa-book-bookmark"></i>
                            Unsave
                        </div>
                    @endif


                    <div class="dropdown-item text-danger"
                        wire:click="deleteDiscussionMessageForMe "
                        {{-- onclick="return confirm('Are you sure to delete this message? You can\'t undone it')" --}}><i class="fa fa-delete-left"></i> Delete for
                        me4
                    </div>

                    <div class="dropdown-item text-danger"
                        wire:click="deleteDiscussionMessage "
                        {{-- onclick="return confirm('Are you sure to delete this message? You can\'t undone it')" --}}><i class="fa fa-delete-left"></i> Delete
                    </div>


                </div>
            </div>
            <img src="{{ asset('images/auth/favicon.png') }}" alt=""
                class="emoji option">
            @endif

        @if(!(isset($data['isDeleted']) && $data['isDeleted']))
        <div class="heure">
            {{-- <time>{{ Carbon\Carbon::parse($message->created_at)->isoFormat('dddd [à] HH[h]mm') }}</time> --}}
            <time>{{ $data['date'] }}</time>
            @if($data['read'])
                <img src="{{ asset('images/read.png') }}" alt="">
            @endif
            {{-- $message->created_at->shortAbsoluteDiffForHumans() --}}
        </div>
        @endif
        </div>
    </div>
    @endisset
</div>
