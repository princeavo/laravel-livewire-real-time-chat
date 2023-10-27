<div>
    @if($data)
    <div class="conversationSend">
        <div class="maxWidth">
            <div class="sendConversation">
                <div class="sendMessage">
                    @if(isset($data['image']) && $data['image'])
                        <img src=" {{ \Illuminate\Support\Facades\Storage::disk('public')->url($data['image']) }}" alt="" style="width: 250px;border-radius:5px">
                        <div style="width: 250px; margin-top:10px;text-align:center">
                            {{ $data['contenu'] }}
                        </div>
                    @else
                        {{ $data['contenu'] }}
                    @endif
                </div>
                <div class="heure">
                    <time>{{ $data['date'] }}</time>
                </div>
                @if(!$data['isUserLeaveGroup'])

                    <div class="dropdown options option">
                        <button class="btn" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">...</button>
                        <div class="dropdown-menu">
                            <div class="dropdown-item "><i class="fa fa-reply"></i> Reply</div>
                            <div class="dropdown-item" data-toggle="modal" data-target="#forwardMessageModal" wire:click='forwadMessage'> <i class="fa fa-share"></i> Forward
                            </div>
                            <div class="dropdown-item"><i class="fa fa-copy"></i> Copy</div>

                            @if (!$data['isSaved'])
                                <div class="dropdown-item"
                                    wire:click='addMessageToGroupBookMark'>
                                    <i class="fa fa-book-bookmark"></i>
                                    Bookmark
                                </div>
                            @else
                                <div class="dropdown-item"
                                    wire:click='deleteMessageToGroupBookMark'>
                                    <i class="fa fa-book-bookmark"></i>
                                    Unsave
                                </div>
                            @endif


                            <div class="dropdown-item text-danger"
                                wire:click="deleteGroupMessageForMe"
                                onclick="return confirm('Are you sure to delete this message? You can\'t undone it')"><i class="fa fa-delete-left"></i> Delete
                                for me
                            </div>


                            @if ($data['isUserAdminForThisGroup'])
                                <div class="dropdown-item text-danger"
                                    wire:click="deleteGroupMessage"
                                    {{-- onclick="return confirm('Are you sure to delete this message? You can\'t undone it')" --}}><i class="fa fa-delete-left"></i>
                                    Delete
                                </div>
                            @endif


                        </div>
                    </div>

                    {{-- <img src="{{ asset('images/auth/favicon.png') }}" alt=""
                    class="options option"> --}}
                    <img src="{{ asset('images/auth/favicon.png') }}" alt=""
                        class="emoji option">



                @endif
            </div>
        </div>
    </div>
    @endif
</div>


