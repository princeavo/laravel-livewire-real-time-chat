<div id="conversationGlobalBloc" wire:keydown.escape='closeDiscussion'>
    <div id="conversationBloc">
        @if (session()->has('groupActifId'))

        @livewire('forward-message-modal-component')

            {{-- <div class="top">
                <div class="left">
                    <div class="profileImage">
                        <img src="{{ asset("storage/{$groupe->photo}") }}" alt="">
                        <div class="onlineIndicator">
                        </div>
                    </div>
                    <div class="center">
                        <h3 class="nom">{{ $groupe->nom }}</h3>
                        <p class="apercuMessage">Online</p>
                    </div>
                </div>
                <div class="right">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                </div>
            </div> --}}

            @php

                if($isUserLeaveGroup){
                    $isAdmin = 0;
                }else{
                    $isAdmin = $groupe->membres->filter(function($m){
                        return $m->id === auth()->user()->id ;
                    })->first()->pivot->toArray()['isAdmin'];
                }

                /*
                $userLogedInCollection = $groupe->membres->filter(function($m){
                    return $m->id === auth()->user()->id ;
                })->first()->pivot->toArray();

                dd($userLogedInCollection);
                */

            @endphp

            <div class="top">
                <div class="left">
                    <i class="fa fa-backspace" style="cursor: pointer;">Back</i>
                    <div class="profileImage">
                        @livewire('group-photo-component',key($groupe->id),['photo' => $groupe->photo])
                        <div class="onlineIndicator">
                        </div>
                    </div>
                    <div class="center">
                        <h3 class="nom">{{ $groupe->nom }}</h3>
                        <p class="apercuMessage">Online</p>
                    </div>
                </div>
                <div class="right">
                    {{-- <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt=""> --}}
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="details">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="" id="detailsMediaQueries">
                    {{-- <img src="{{ asset('images/auth/favicon.png') }}" alt=""> --}}

                    @livewire('add-or-remove-discussion-from-favorite-component',key("groupe".$groupe->id))

                    {{-- <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt=""> --}}
                </div>
            </div>


            {{-- <livewire:top-component :param='$param' :key="$key"/> --}}

            <div class="separator"></div>


            @php
                /*
                if($isUserLeaveGroup){
                    $isUserAdminForThisGroup = 0;
                }else{

                    $user = auth()->user();
                    $userId = $user->id;
                    $isUserAdminForThisGroup = auth()
                        ->user()
                        ->isAdminForGroupe($groupe->id)->isAdmin;
                }
                */
                $userId = auth()->user()->id;
            @endphp


            <div id="center">
                @foreach ($groupe->messages as $message)
                    @php
                        $isUserDeleteThisMessageForHim = true;
                        $isUserDeleteThisMessageForHim = $message->usersCanNotReadThisMessage->contains(function ($user) use ($userId) {
                            return $user->id == $userId;
                        });

                        $isUserAddThisMessageInFavorite = false;
                        $isUserAddThisMessageInFavorite = $message->usersHaveThisMessageFavorite->contains(function ($user) use ($userId) {
                            return $user->id == $userId;
                        });

                        //dd($message);

                        $data = ['contenu' => $message->contenu,'id' => $message->id,'date' => $message->created_at->format("d/m/y H:i:s"),'isSaved' => $isUserAddThisMessageInFavorite,'isUserAdminForThisGroup'=>$isAdmin,'sender'=>['profile_photo'=>$message->sender->profile_photo,'firstname'=>$message->sender->firstname],'isUserLeaveGroup' => $isUserLeaveGroup,'image' => $message->image]

                    @endphp
                    @if (!$isUserDeleteThisMessageForHim)
                        <div class="conversationReceived" @if ($groupe->messages->last() == $message) id="last" @endif>
                            @if ($message->sender_id == $userId)
                                @livewire('group-message-sent-component',key($message->id),['data' => $data])
                            @else
                               @livewire('group-message-receved-component',key($message->id),['data' => $data])
                            @endif

                            @if (false)
                                <div class="senderProfile">
                                    <img src="{{ asset("storage/{$message->sender->profile_photo}") }}" alt="">
                                    <time>{{ Carbon\Carbon::parse($message->created_at)->isoFormat('dddd [à] HH[h]mm') }}</time>
                                    <br>
                                    <i>{{ $message->sender->firstname }}</i>

                                </div>
                            @endif

                            {{-- Cette partie comporte une image avec légende --}}

                            {{-- <div class="reveivedConversation">
                                <div class="receivedMessage noBackground">
                                    <div class="image" data-toggle="modal" data-target="#myModal">
                                        <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="">
                                        <span>AVOHOU Prince Boris</span>
                                    </div>
                                    <div class="image">
                                        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                                        <span>Juste une légende</span>
                                    </div>
                                </div>
                                <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
                                <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
                            </div> --}}
                        </div>
                    @endif
                @endforeach
                @php
                    $actif = session()->get('groupActifId');
                @endphp



                @livewire('test-group-component',key($actif),['isUserLeaveGroup' => $isUserLeaveGroup])


                {{-- <div class="conversationSend">
                <div class="maxWidth">
                    <div class="sendConversation">
                        <div class="sendMessage">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod numquam sint quae nisi? Sed non, explicabo distinctio qui quod similique esse id aperiam dolorem ut quam praesentium reprehenderit eligendi dolore architecto aspernatur corporis molestiae eveniet earum quas ipsa dolor? Id fugiat laboriosam deserunt aliquid, possimus cum a suscipit expedita amet labore laudantium dolores dolorem harum aliquam optio nulla reiciendis atque non pariatur. Quas corrupti iure labore exercitationem, aperiam corporis eos sed iusto laboriosam a aliquam totam minus. Reprehenderit nisi facere, dolorum deserunt modi corporis voluptatem, sunt enim quos exercitationem non quidem a, incidunt laudantium illo? Blanditiis doloribus accusantium iusto laudantium debitis, repellendus velit totam exercitationem error necessitatibus facilis explicabo, architecto expedita aut est animi vero illum impedit pariatur nemo fugit maxime? Debitis perferendis porro ratione rem totam eos doloremque modi itaque tempore non. Excepturi rem velit porro deserunt sunt qui officiis obcaecati corrupti, recusandae consequuntur rerum animi neque earum magnam fugiat, ab, accusantium est. Voluptas aliquam voluptate et, blanditiis mollitia quidem modi a veniam error quasi itaque voluptatum reprehenderit quis odit, expedita vero consequuntur molestiae sit enim similique! Fuga suscipit accusantium et rem, eligendi ducimus ad consequatur ab iste quam totam tempore dolorum omnis maiores commodi quis magni consequuntur eum animi impedit! Odio in magni quam, eum culpa labore. Illum, blanditiis animi iste delectus ab rem obcaecati, perferendis sapiente nostrum accusamus at facere, quaerat dolorem itaque ducimus doloribus nam repudiandae! Hic magni, eligendi provident excepturi, eveniet possimus, exercitationem enim iure rem iusto itaque voluptate harum. Minima neque commodi dolore dolor dolores laboriosam porro atque tenetur! Cum eaque mollitia sint labore iusto unde nisi minus dicta laborum, corrupti quibusdam facere sit delectus atque nemo error? Hic maiores sit molestias optio repellat unde temporibus iure quam architecto rem repellendus eligendi rerum delectus iste, reprehenderit, sunt ex placeat excepturi quibusdam suscipit. Quod velit enim inventore est esse quidem quaerat eos expedita fuga voluptatibus? Ducimus nam, a vero fugiat dolore aliquam quas neque, accusantium consequatur doloremque iusto illo alias tenetur saepe praesentium debitis optio nostrum voluptas fuga obcaecati aperiam possimus magni! Labore nihil quos aliquid illum voluptas laborum minus, dignissimos aut exercitationem dolorum quibusdam alias at veniam expedita incidunt fugiat eius sapiente cupiditate dolores debitis repudiandae, quaerat ea magnam eligendi. Voluptatibus animi iste error commodi magnam, accusantium, ea voluptate ab nulla fugit quisquam ex! Sapiente eius aperiam inventore minima voluptatem enim corrupti dolorem asperiores vitae molestiae quia quisquam consequuntur debitis dicta, pariatur architecto aliquam.
                        </div>
                        <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
                        <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
                    </div>
                    <div class="heure">
                        <time>10:14 am</time>
                    </div>
                </div>
                </div>
                <div class="conversationSend">
                    <div class="maxWidth">
                        <div class="sendConversation">
                            <div class="sendMessage">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod numquam sint quae nisi? Sed non, explicabo distinctio qui quod similique esse id aperiam dolorem ut quam praesentium reprehenderit eligendi dolore architecto aspernatur corporis molestiae eveniet earum quas ipsa dolor? Id fugiat laboriosam deserunt aliquid, possimus cum a suscipit expedita amet labore laudantium dolores dolorem harum aliquam optio nulla reiciendis atque non pariatur. Quas corrupti iure labore exercitationem, aperiam corporis eos sed iusto laboriosam a aliquam totam minus. Reprehenderit nisi facere, dolorum deserunt modi corporis voluptatem, sunt enim quos exercitationem non quidem a, incidunt laudantium illo? Blanditiis doloribus accusantium iusto laudantium debitis, repellendus velit totam exercitationem error necessitatibus facilis explicabo, architecto expedita aut est animi vero illum impedit pariatur nemo fugit maxime? Debitis perferendis porro ratione rem totam eos doloremque modi itaque tempore non. Excepturi rem velit porro deserunt sunt qui officiis obcaecati corrupti, recusandae consequuntur rerum animi neque earum magnam fugiat, ab, accusantium est. Voluptas aliquam voluptate et, blanditiis mollitia quidem modi a veniam error quasi itaque voluptatum reprehenderit quis odit, expedita vero consequuntur molestiae sit enim similique! Fuga suscipit accusantium et rem, eligendi ducimus ad consequatur ab iste quam totam tempore dolorum omnis maiores commodi quis magni consequuntur eum animi impedit! Odio in magni quam, eum culpa labore. Illum, blanditiis animi iste delectus ab rem obcaecati, perferendis sapiente nostrum accusamus at facere, quaerat dolorem itaque ducimus doloribus nam repudiandae! Hic magni, eligendi provident excepturi, eveniet possimus, exercitationem enim iure rem iusto itaque voluptate harum. Minima neque commodi dolore dolor dolores laboriosam porro atque tenetur! Cum eaque mollitia sint labore iusto unde nisi minus dicta laborum, corrupti quibusdam facere sit delectus atque nemo error? Hic maiores sit molestias optio repellat unde temporibus iure quam architecto rem repellendus eligendi rerum delectus iste, reprehenderit, sunt ex placeat excepturi quibusdam suscipit. Quod velit enim inventore est esse quidem quaerat eos expedita fuga voluptatibus? Ducimus nam, a vero fugiat dolore aliquam quas neque, accusantium consequatur doloremque iusto illo alias tenetur saepe praesentium debitis optio nostrum voluptas fuga obcaecati aperiam possimus magni! Labore nihil quos aliquid illum voluptas laborum minus, dignissimos aut exercitationem dolorum quibusdam alias at veniam expedita incidunt fugiat eius sapiente cupiditate dolores debitis repudiandae, quaerat ea magnam eligendi. Voluptatibus animi iste error commodi magnam, accusantium, ea voluptate ab nulla fugit quisquam ex! Sapiente eius aperiam inventore minima voluptatem enim corrupti dolorem asperiores vitae molestiae quia quisquam consequuntur debitis dicta, pariatur architecto aliquam.
                            </div>
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
                        </div>
                        <div class="heure">
                            <time>10:14 am</time>
                        </div>
                    </div>
                </div>
                <div class="conversationSend">
                    <div class="maxWidth">
                        <div class="sendConversation">
                            <div class="sendMessage">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod numquam sint quae nisi? Sed non, explicabo distinctio qui quod similique esse id aperiam dolorem ut quam praesentium reprehenderit eligendi dolore architecto aspernatur corporis molestiae eveniet earum quas ipsa dolor? Id fugiat laboriosam deserunt aliquid, possimus cum a suscipit expedita amet labore laudantium dolores dolorem harum aliquam optio nulla reiciendis atque non pariatur. Quas corrupti iure labore exercitationem, aperiam corporis eos sed iusto laboriosam a aliquam totam minus. Reprehenderit nisi facere, dolorum deserunt modi corporis voluptatem, sunt enim quos exercitationem non quidem a, incidunt laudantium illo? Blanditiis doloribus accusantium iusto laudantium debitis, repellendus velit totam exercitationem error necessitatibus facilis explicabo, architecto expedita aut est animi vero illum impedit pariatur nemo fugit maxime? Debitis perferendis porro ratione rem totam eos doloremque modi itaque tempore non. Excepturi rem velit porro deserunt sunt qui officiis obcaecati corrupti, recusandae consequuntur rerum animi neque earum magnam fugiat, ab, accusantium est. Voluptas aliquam voluptate et, blanditiis mollitia quidem modi a veniam error quasi itaque voluptatum reprehenderit quis odit, expedita vero consequuntur molestiae sit enim similique! Fuga suscipit accusantium et rem, eligendi ducimus ad consequatur ab iste quam totam tempore dolorum omnis maiores commodi quis magni consequuntur eum animi impedit! Odio in magni quam, eum culpa labore. Illum, blanditiis animi iste delectus ab rem obcaecati, perferendis sapiente nostrum accusamus at facere, quaerat dolorem itaque ducimus doloribus nam repudiandae! Hic magni, eligendi provident excepturi, eveniet possimus, exercitationem enim iure rem iusto itaque voluptate harum. Minima neque commodi dolore dolor dolores laboriosam porro atque tenetur! Cum eaque mollitia sint labore iusto unde nisi minus dicta laborum, corrupti quibusdam facere sit delectus atque nemo error? Hic maiores sit molestias optio repellat unde temporibus iure quam architecto rem repellendus eligendi rerum delectus iste, reprehenderit, sunt ex placeat excepturi quibusdam suscipit. Quod velit enim inventore est esse quidem quaerat eos expedita fuga voluptatibus? Ducimus nam, a vero fugiat dolore aliquam quas neque, accusantium consequatur doloremque iusto illo alias tenetur saepe praesentium debitis optio nostrum voluptas fuga obcaecati aperiam possimus magni! Labore nihil quos aliquid illum voluptas laborum minus, dignissimos aut exercitationem dolorum quibusdam alias at veniam expedita incidunt fugiat eius sapiente cupiditate dolores debitis repudiandae, quaerat ea magnam eligendi. Voluptatibus animi iste error commodi magnam, accusantium, ea voluptate ab nulla fugit quisquam ex! Sapiente eius aperiam inventore minima voluptatem enim corrupti dolorem asperiores vitae molestiae quia quisquam consequuntur debitis dicta, pariatur architecto aliquam.
                            </div>
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
                        </div>
                        <div class="heure">
                            <time>10:14 am</time>
                        </div>
                    </div>
                </div>
                <div class="conversationSend">
                    <div class="maxWidth">
                        <div class="sendConversation noBackground">
                            <div class="sendMessage">
                                <div class="image" data-toggle="modal" data-target="#myModal">
                                    <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="">
                                    <span>AVOHOU Prince Boris</span>
                                </div>
                            </div>
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
                        </div>
                        <div class="heure">
                            <time>10:14 am</time>
                        </div>
                    </div>
                </div>
                <div class="conversationSend">
                    <div class="maxWidth">
                        <div class="sendConversation noBackground">
                            <div class="sendMessage">
                                <div class="image" data-toggle="modal" data-target="#myModal">
                                    <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="">
                                    <span>AVOHOU Prince Boris</span>
                                </div>
                            </div>
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
                        </div>
                        <div class="heure">
                            <time>10:14 am</time>
                        </div>
                    </div>
                </div> --}}








            </div>

            <div id="separator"></div>

            @if(!$isUserLeaveGroup)
                @livewire('send-message-component',key($groupe->id),['isAdmin' => $isAdmin])
            @endif

        @endif

        @if (session()->has('discussionActifId') && $discussion != null)


        @livewire('forward-message-modal-component')


            @php

                $user = auth()->user();
                $userId = $user->id;
                if ($discussion != null) {
                    if ($discussion->user1 == $user) {
                        $discussion->user = $discussion->user2;
                    } else {
                        $discussion->user = $discussion->user1;
                    }
                }

            @endphp


            {{-- <livewire:top-component :param='$param' /> --}}

            <div class="top">
                <div class="left">
                    <div class="profileImage">
                        <img src="{{ asset("storage/{$discussion->user->profile_photo}") }}" alt="">
                        <div class="onlineIndicator">
                        </div>
                    </div>
                    <div class="center">
                        <h3 class="nom">{{ $discussion->user->firstname }} {{ $discussion->user->lastname }}</h3>
                        <p class="apercuMessage">Online</p>
                    </div>
                </div>
                <div class="right">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="details">
                    {{-- <img src="{{ asset('images/auth/favicon.png') }}" alt=""> --}}

                    @livewire('add-or-remove-discussion-from-favorite-component',key("discussion".$discussion->id))

                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                </div>
            </div>

            @php
                $messages = $discussion->messages->filter(function ($message) use ($userId) {
                    if ($message->sender_id == $userId) {
                        return $message->isVisibleForSender;
                    } else {
                        return $message->isVisibleForReceiver;
                    }
                });
            @endphp

            <div id="separator"></div>
            <div id="center">
                @foreach ($messages as $message)
                    <div class="conversationReceived" @if ($discussion->messages->last() == $message) id="last" @endif>
                        @php
                            $isFavorite = $favorites->contains($message->id);
                            $data = ['id' => $message->id,'contenu' => $message->contenu,'date' => $message->created_at->format("d/m/y H:i:s"),'isSaved'=>$isFavorite,'read' => $message->read,'isDeleted' => $message->isDeleted,'image' => $message->image];
                        @endphp
                        @if ($message->sender_id == $userId)
                            <livewire:message-sent-component :data='$data' :key='$message->id'>
                        @else
                            <livewire:message-receved-component :data='$data' :key='$message->id'>
                        @endif

                        @if (false)
                            <div class="senderProfile">
                                {{-- <img src="{{ asset("storage/{$message->sender->profile_photo}") }}" alt=""> --}}
                                {{-- <time>{{ Carbon\Carbon::parse($message->created_at)->isoFormat('dddd [à] HH[h]mm') }}</time> --}}
                                <time>{{ $message->created_at->diffForHumans() }}</time>
                                {{-- <br>
                                <i>{{ $message->sender->firstname }}</i> --}}

                            </div>
                        @endif

                        {{-- Cette partie comporte une image avec légende --}}

                        {{-- <div class="reveivedConversation">
                            <div class="receivedMessage noBackground">
                                <div class="image" data-toggle="modal" data-target="#myModal">
                                    <img src="{{ asset('images/auth/pexels-anna-shvets-4315839.jpg') }}" alt="">
                                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, dolore ducimus? Dolore itaque expedita inventore ut exercitationem provident aspernatur, delectus repellat deleniti, illo, minima quo. Voluptatum illum dolores excepturi et.  </span>
                                </div>
                                <div class="image">
                                    <img src="{{ asset('images/auth/favicon.png') }}" alt="">
                                    <span>Juste une légende</span>
                                </div>
                            </div>
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
                            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji option">
                        </div> --}}
                    </div>
                @endforeach
                {{-- <div class="conversationSend">
            <div class="maxWidth">
                <div class="sendConversation">
                    <div class="sendMessage">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod numquam sint quae nisi? Sed non, explicabo distinctio qui quod similique esse id aperiam dolorem ut quam praesentium reprehenderit eligendi dolore architecto aspernatur corporis molestiae eveniet earum quas ipsa dolor? Id fugiat laboriosam deserunt aliquid, possimus cum a suscipit expedita amet labore laudantium dolores dolorem harum aliquam optio nulla reiciendis atque non pariatur. Quas corrupti iure labore exercitationem, aperiam corporis eos sed iusto laboriosam a aliquam totam minus. Reprehenderit nisi facere, dolorum deserunt modi corporis voluptatem, sunt enim quos exercitationem non quidem a, incidunt laudantium illo? Blanditiis doloribus accusantium iusto laudantium debitis, repellendus velit totam exercitationem error necessitatibus facilis explicabo, architecto expedita aut est animi vero illum impedit pariatur nemo fugit maxime? Debitis perferendis porro ratione rem totam eos doloremque modi itaque tempore non. Excepturi rem velit porro deserunt sunt qui officiis obcaecati corrupti, recusandae consequuntur rerum animi neque earum magnam fugiat, ab, accusantium est. Voluptas aliquam voluptate et, blanditiis mollitia quidem modi a veniam error quasi itaque voluptatum reprehenderit quis odit, expedita vero consequuntur molestiae sit enim similique! Fuga suscipit accusantium et rem, eligendi ducimus ad consequatur ab iste quam totam tempore dolorum omnis maiores commodi quis magni consequuntur eum animi impedit! Odio in magni quam, eum culpa labore. Illum, blanditiis animi iste delectus ab rem obcaecati, perferendis sapiente nostrum accusamus at facere, quaerat dolorem itaque ducimus doloribus nam repudiandae! Hic magni, eligendi provident excepturi, eveniet possimus, exercitationem enim iure rem iusto itaque voluptate harum. Minima neque commodi dolore dolor dolores laboriosam porro atque tenetur! Cum eaque mollitia sint labore iusto unde nisi minus dicta laborum, corrupti quibusdam facere sit delectus atque nemo error? Hic maiores sit molestias optio repellat unde temporibus iure quam architecto rem repellendus eligendi rerum delectus iste, reprehenderit, sunt ex placeat excepturi quibusdam suscipit. Quod velit enim inventore est esse quidem quaerat eos expedita fuga voluptatibus? Ducimus nam, a vero fugiat dolore aliquam quas neque, accusantium consequatur doloremque iusto illo alias tenetur saepe praesentium debitis optio nostrum voluptas fuga obcaecati aperiam possimus magni! Labore nihil quos aliquid illum voluptas laborum minus, dignissimos aut exercitationem dolorum quibusdam alias at veniam expedita incidunt fugiat eius sapiente cupiditate dolores debitis repudiandae, quaerat ea magnam eligendi. Voluptatibus animi iste error commodi magnam, accusantium, ea voluptate ab nulla fugit quisquam ex! Sapiente eius aperiam inventore minima voluptatem enim corrupti dolorem asperiores vitae molestiae quia quisquam consequuntur debitis dicta, pariatur architecto aliquam.
                    </div>
                    <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
<img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
</div>
<div class="heure">
    <time>10:14 am</time>
</div>
</div>
</div>
<div class="conversationSend">
    <div class="maxWidth">
        <div class="sendConversation">
            <div class="sendMessage">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod numquam sint quae nisi? Sed non, explicabo distinctio qui quod similique esse id aperiam dolorem ut quam praesentium reprehenderit eligendi dolore architecto aspernatur corporis molestiae eveniet earum quas ipsa dolor? Id fugiat laboriosam deserunt aliquid, possimus cum a suscipit expedita amet labore laudantium dolores dolorem harum aliquam optio nulla reiciendis atque non pariatur. Quas corrupti iure labore exercitationem, aperiam corporis eos sed iusto laboriosam a aliquam totam minus. Reprehenderit nisi facere, dolorum deserunt modi corporis voluptatem, sunt enim quos exercitationem non quidem a, incidunt laudantium illo? Blanditiis doloribus accusantium iusto laudantium debitis, repellendus velit totam exercitationem error necessitatibus facilis explicabo, architecto expedita aut est animi vero illum impedit pariatur nemo fugit maxime? Debitis perferendis porro ratione rem totam eos doloremque modi itaque tempore non. Excepturi rem velit porro deserunt sunt qui officiis obcaecati corrupti, recusandae consequuntur rerum animi neque earum magnam fugiat, ab, accusantium est. Voluptas aliquam voluptate et, blanditiis mollitia quidem modi a veniam error quasi itaque voluptatum reprehenderit quis odit, expedita vero consequuntur molestiae sit enim similique! Fuga suscipit accusantium et rem, eligendi ducimus ad consequatur ab iste quam totam tempore dolorum omnis maiores commodi quis magni consequuntur eum animi impedit! Odio in magni quam, eum culpa labore. Illum, blanditiis animi iste delectus ab rem obcaecati, perferendis sapiente nostrum accusamus at facere, quaerat dolorem itaque ducimus doloribus nam repudiandae! Hic magni, eligendi provident excepturi, eveniet possimus, exercitationem enim iure rem iusto itaque voluptate harum. Minima neque commodi dolore dolor dolores laboriosam porro atque tenetur! Cum eaque mollitia sint labore iusto unde nisi minus dicta laborum, corrupti quibusdam facere sit delectus atque nemo error? Hic maiores sit molestias optio repellat unde temporibus iure quam architecto rem repellendus eligendi rerum delectus iste, reprehenderit, sunt ex placeat excepturi quibusdam suscipit. Quod velit enim inventore est esse quidem quaerat eos expedita fuga voluptatibus? Ducimus nam, a vero fugiat dolore aliquam quas neque, accusantium consequatur doloremque iusto illo alias tenetur saepe praesentium debitis optio nostrum voluptas fuga obcaecati aperiam possimus magni! Labore nihil quos aliquid illum voluptas laborum minus, dignissimos aut exercitationem dolorum quibusdam alias at veniam expedita incidunt fugiat eius sapiente cupiditate dolores debitis repudiandae, quaerat ea magnam eligendi. Voluptatibus animi iste error commodi magnam, accusantium, ea voluptate ab nulla fugit quisquam ex! Sapiente eius aperiam inventore minima voluptatem enim corrupti dolorem asperiores vitae molestiae quia quisquam consequuntur debitis dicta, pariatur architecto aliquam.
            </div>
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
        </div>
        <div class="heure">
            <time>10:14 am</time>
        </div>
    </div>
</div>
<div class="conversationSend">
    <div class="maxWidth">
        <div class="sendConversation">
            <div class="sendMessage">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod numquam sint quae nisi? Sed non, explicabo distinctio qui quod similique esse id aperiam dolorem ut quam praesentium reprehenderit eligendi dolore architecto aspernatur corporis molestiae eveniet earum quas ipsa dolor? Id fugiat laboriosam deserunt aliquid, possimus cum a suscipit expedita amet labore laudantium dolores dolorem harum aliquam optio nulla reiciendis atque non pariatur. Quas corrupti iure labore exercitationem, aperiam corporis eos sed iusto laboriosam a aliquam totam minus. Reprehenderit nisi facere, dolorum deserunt modi corporis voluptatem, sunt enim quos exercitationem non quidem a, incidunt laudantium illo? Blanditiis doloribus accusantium iusto laudantium debitis, repellendus velit totam exercitationem error necessitatibus facilis explicabo, architecto expedita aut est animi vero illum impedit pariatur nemo fugit maxime? Debitis perferendis porro ratione rem totam eos doloremque modi itaque tempore non. Excepturi rem velit porro deserunt sunt qui officiis obcaecati corrupti, recusandae consequuntur rerum animi neque earum magnam fugiat, ab, accusantium est. Voluptas aliquam voluptate et, blanditiis mollitia quidem modi a veniam error quasi itaque voluptatum reprehenderit quis odit, expedita vero consequuntur molestiae sit enim similique! Fuga suscipit accusantium et rem, eligendi ducimus ad consequatur ab iste quam totam tempore dolorum omnis maiores commodi quis magni consequuntur eum animi impedit! Odio in magni quam, eum culpa labore. Illum, blanditiis animi iste delectus ab rem obcaecati, perferendis sapiente nostrum accusamus at facere, quaerat dolorem itaque ducimus doloribus nam repudiandae! Hic magni, eligendi provident excepturi, eveniet possimus, exercitationem enim iure rem iusto itaque voluptate harum. Minima neque commodi dolore dolor dolores laboriosam porro atque tenetur! Cum eaque mollitia sint labore iusto unde nisi minus dicta laborum, corrupti quibusdam facere sit delectus atque nemo error? Hic maiores sit molestias optio repellat unde temporibus iure quam architecto rem repellendus eligendi rerum delectus iste, reprehenderit, sunt ex placeat excepturi quibusdam suscipit. Quod velit enim inventore est esse quidem quaerat eos expedita fuga voluptatibus? Ducimus nam, a vero fugiat dolore aliquam quas neque, accusantium consequatur doloremque iusto illo alias tenetur saepe praesentium debitis optio nostrum voluptas fuga obcaecati aperiam possimus magni! Labore nihil quos aliquid illum voluptas laborum minus, dignissimos aut exercitationem dolorum quibusdam alias at veniam expedita incidunt fugiat eius sapiente cupiditate dolores debitis repudiandae, quaerat ea magnam eligendi. Voluptatibus animi iste error commodi magnam, accusantium, ea voluptate ab nulla fugit quisquam ex! Sapiente eius aperiam inventore minima voluptatem enim corrupti dolorem asperiores vitae molestiae quia quisquam consequuntur debitis dicta, pariatur architecto aliquam.
            </div>
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
        </div>
        <div class="heure">
            <time>10:14 am</time>
        </div>
    </div>
</div>
<div class="conversationSend">
    <div class="maxWidth">
        <div class="sendConversation noBackground">
            <div class="sendMessage">
                <div class="image" data-toggle="modal" data-target="#myModal">
                    <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="">
                    <span>AVOHOU Prince Boris</span>
                </div>
            </div>
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
        </div>
        <div class="heure">
            <time>10:14 am</time>
        </div>
    </div>
</div>
<div class="conversationSend">
    <div class="maxWidth">
        <div class="sendConversation noBackground">
            <div class="sendMessage">
                <div class="image" data-toggle="modal" data-target="#myModal">
                    <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="">
                    <span>AVOHOU Prince Boris</span>
                </div>
            </div>
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="options">
            <img src="{{ asset('images/auth/favicon.png') }}" alt="" class="emoji">
        </div>
        <div class="heure">
            <time>10:14 am</time>
        </div>
    </div>
</div> --}}


@php
    $actif = session()->get('discussionActifId');
@endphp


@livewire('test-component',key($actif))



            </div>
            <div id="separator"></div>



            @livewire('send-message-component')

        @endif

    </div>
    {{-- <div id="separateurConversation"></div> --}}
    @if (session()->has('discussionActifId') && $discussion != null)
        @php
            $groupes1 = $discussion->user->groupes;
            $groupes2 = $user->groupes;
            $groupesCommun = $groupes1->intersect($groupes2);
        @endphp
        <div id="aboutADiscussion" style="display: none;">
            <div id="status">
                <div class="top">
                    <img src="{{ asset("storage/{$discussion->user->profile_photo}") }}" alt=""
                        id="photoDiscussion">
                    <div class="separator">

                    </div>
                </div>
                <div class="bottom">
                    <div id="status">
                        <h4 class="titre">Status</h4>
                        <span>{{ $discussion->user->status }}</span>
                    </div>

                    <div id="info">
                        <h4 class="titre">Infos</h4>
                    </div>
                    <div class="info">
                        <i class="fa fa-user-friends"></i>
                        <span>{{ $discussion->user->firstname }} {{ $discussion->user->lastname }}</span>
                    </div>
                    <div class="info">
                        <i class="fa fa-mail-bulk"></i>
                        <span>{{ $discussion->user->email }}</span>
                    </div>
                    <div class="info">
                        <i class="fa fa-contact-book"></i>
                        <span>{{ $discussion->user->contact ?? "Inconnu" }}</span>
                    </div>
                    <div class="info">
                        <i class="fa fa-location"></i>
                        <span><i>{{ $discussion->user->pays->name }}</i></span>
                    </div>

                    <div class="separator"></div>
                    <h4 class="titre" style="margin-top: 10px">Group in common <i class="fa fa-user-friends"></i></h4>
                    @foreach ($groupesCommun as $groupeCommun)
                        <div class="commonGroup">
                            <img src='{{ asset("storage/{$groupeCommun->photo}") }}' alt="">
                            <span>{{ $groupeCommun->nom }}</span>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    @endif
    @if (session()->has('groupActifId'))
        @php
            $key = $groupe->id . 'groupe';

            $AboutGroupData = [
                "groupe" => [
                    "creator" => [
                        "lastname" => $groupe['creator']['lastname'],
                        "firstname" => $groupe['creator']['firstname'],
                        "email" => $groupe['creator']['email'],
                        "pays" => $groupe['creator']['pays'],
                        "contact" => $groupe['creator']['contact'],
                    ],
                    "membres" => $groupe['membres'],
                    'id' => $groupe['id'],
                    'nom' => $groupe['nom'],
                    'description' => $groupe['description'],
                    'photo' => $groupe['photo'],

                    "hideOptions" => false,
                ]
            ];

            if($isUserLeaveGroup){
                $AboutGroupData['groupe']['hideOptions'] = true;
            }

            //dd($AboutGroupData);

        @endphp
        <livewire:about-group-component :key='$key' :data="$AboutGroupData">
    @endif

    <script>
        @php
            $data = ['id' => '1','contenu' =>'Sequi culpa impedit pariatur accusamus. Ullam eos dolorem provident eos illo. Eveniet est maiores tempore. Sapiente rerum sed rem hic. Ex et magnam architecto quis mollitia. Unde nihil aut pariatur dolorem et. Voluptates similique nisi officia qui velit nulla autem. Omnis facere voluptatem nemo aspernatur enim quia. Totam ratione autem nihil eum illum enim. Perferendis accusamus ut magnam ex.','date' => 'Une date'];
        @endphp
        {{-- window.addEventListener('scrollToLastMessage', event => {
            const lastMessage = document.querySelector('#last');
            if (lastMessage) {
                lastMessage.scrollIntoView();
            }
        }); --}}

        {{-- Livewire.on('showDiscussion',function(){
            dispatch('scrollToLastMessage');
        }); --}}
        window.addEventListener('scrollToLastMessage',()=>{
            {{-- document.querySelector('#last').removeAttribute('id'); --}}
            {{-- document.querySelector('#center :nth-last-child().conversationSend .heure').scrollIntoView(); --}}
            const heures = document.querySelectorAll('#center  .heure');
            heures[heures.length-1].scrollIntoView();
        });
        window.addEventListener('newMessageSentFromADiscussion', event => {
            const selector = `#messages .message.active .center .apercuMessage`;
            const aperMessage = document.querySelector(selector);

            aperMessage.innerText = event.detail.apercuMessage;

            const favContainer = document.querySelector('#messages #favourites');
            const activeDiscussion = document.querySelector('#messages .message.active');
            const directsMessagesContainer = document.querySelector('#messages #directsMessages');
            if(favContainer.querySelector('.message.active')){
                favContainer.querySelector('h4').insertAdjacentElement('afterend',activeDiscussion);
            }else{
                directsMessagesContainer.querySelector('.flex').insertAdjacentElement('afterend',activeDiscussion);
            }

        });
        window.addEventListener('removeNewMessageClass',()=>{
            document.querySelectorAll('.newMessage').forEach((el)=>{
                el.classList.remove(".newMessage");
            });
        });
        window.addEventListener('newMessageDiscussion',()=>{

            const favContainer = document.querySelector('#messages #favourites');
            const activeDiscussion = document.querySelector('#messages .message.newMessage');
            const directsMessagesContainer = document.querySelector('#messages #directsMessages');
            if(favContainer.querySelector('.message.newMessage')){
                favContainer.querySelector('h4').insertAdjacentElement('afterend',activeDiscussion);
            }else{
                directsMessagesContainer.querySelector('.flex').insertAdjacentElement('afterend',activeDiscussion);
            }
        });
        window.addEventListener('newMessageSentFromActiveDiscussion',()=>{

            const favContainer = document.querySelector('#messages #favourites');
            const activeDiscussion = document.querySelector('#messages .message.active');
            const directsMessagesContainer = document.querySelector('#messages #directsMessages');
            if(favContainer.querySelector('.message.active')){
                favContainer.querySelector('h4').insertAdjacentElement('afterend',activeDiscussion);
            }else{
                directsMessagesContainer.querySelector('.flex').insertAdjacentElement('afterend',activeDiscussion);
            }
        });
        window.addEventListener('newMessageSentFromAGroup', event => {

            const favContainer = document.querySelector('#messages #favourites');
            const activeGroup = document.querySelector('#messages .message.active');
            const groupesMessagesContainer = document.querySelector('#messages #channels');
            if(favContainer.querySelector('.message.active')){
                favContainer.querySelector('h4').insertAdjacentElement('afterend',activeGroup);
            }else{
                groupesMessagesContainer.querySelector('.flex').insertAdjacentElement('afterend',activeGroup);
            }

        });

        window.addEventListener('newMessageDeletedFromADiscussion',()=>{
            document.querySelector("#messages .message.active .center .apercuMessage").innerHTML = "<b>You've deleted a message</b>";
        });

        const monElement = document.querySelector('.details');

        monElement.addEventListener('click', () => {
            const elemQuiVeutAvoirDisplayNone = document.querySelector('#aboutADiscussion');

            (elemQuiVeutAvoirDisplayNone.style.display === 'none') ? (elemQuiVeutAvoirDisplayNone.style.display =
                'block') : (elemQuiVeutAvoirDisplayNone.style.display = 'none');
        });

        {{-- const closeDetailIcon = document.querySelector('.closeDetail');

        closeDetailIcon.addEventListener('click', () => {
            const elemQuiVeutAvoirDisplayNone = document.querySelector('#aboutADiscussion');

            elemQuiVeutAvoirDisplayNone.style.display = 'none';

        }); --}}
    </script>
    {{-- <div role="status" class="max-w-sm p-4 border border-gray-200 rounded shadow animate-pulse md:p-6 dark:border-gray-700" style="height: 100%">
            <div class="flex items-center justify-center h-48 mb-4 bg-gray-300 rounded dark:bg-gray-700">
                <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                    <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"/>
                    <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                </svg>
            </div>
            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            <div class="flex items-center mt-4 space-x-3">
               <svg class="w-10 h-10 text-gray-200 dark:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                </svg>
                <div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32 mb-2"></div>
                    <div class="w-48 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
            </div>
            <div class="flex items-center mt-4 space-x-3">
                <svg class="w-10 h-10 text-gray-200 dark:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                     <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                 </svg>
                 <div>
                     <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32 mb-2"></div>
                     <div class="w-48 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                 </div>
             </div>
             <div class="flex items-center mt-4 space-x-3">
                <svg class="w-10 h-10 text-gray-200 dark:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                     <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                 </svg>
                 <div>
                     <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32 mb-2"></div>
                     <div class="w-48 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                 </div>
             </div>
             <div class="flex items-center mt-4 space-x-3">
                <svg class="w-10 h-10 text-gray-200 dark:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                     <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                 </svg>
                 <div>
                     <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32 mb-2"></div>
                     <div class="w-48 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                 </div>
             </div>
            <span class="sr-only">Loading...</span>
        </div> --}}

</div>
