<div id="messages">

    <div class="top">
        <p id="messageTitle">Messages<span>(128)</span></p>
        <div id="searchContainer">
            <input type="text" placeholder="Search here">
        </div>
    </div>


    <div class="bottom">
        <div class="forScroll">
            <div id="noResult" style="display:none;transition:0.5s ease;">
                <p style="text-align:center;color:#666">No result matches your request 😐</p>
            </div>
            <div id="favourites">
                <h4>Favourites</h4>
                @php
                    $discussionsFavorites =$discussions->filter(function($discussion){
                        return $discussion->favorite;
                    });
                    $groupesFavorites =$groupes->filter(function($groupe){
                        return $groupe->favorite;
                    });
                    $nombresDiscussionsFavorites = $discussionsFavorites->count() + $groupesFavorites->count();
                @endphp
                @foreach ($discussionsFavorites as $discussionsFavorite)


                @php

                    if($discussionsFavorite->message == null)
                        continue;

                    //if($discussion->user1 == auth()->user())
                        //$discussion->user = $discussion->user2;
                    //else
                        //$discussion->user = $discussion->user1;


                    if($discussionsFavorite->utilisateur1Id != auth()->user()->id){
                        $firstname = $discussionsFavorite->utilisateur1FirstName;
                        $lastname = $discussionsFavorite->utilisateur1LastName;
                        $profile_photo = $discussionsFavorite->utilisateur1Photo;
                    }
                    else{
                       $firstname = $discussionsFavorite->utilisateur2FirstName;
                       $lastname = $discussionsFavorite->utilisateur2LastName;
                       $profile_photo = $discussionsFavorite->utilisateur2Photo;
                    }
                    $data = [
                        "id" => $discussionsFavorite->id,
                        "profile_photo" => $profile_photo,
                        "firstname" => $firstname,
                        "lastname" => $lastname,
                        "message" => $discussionsFavorite->message,
                        "numberUnreadMessages" => $discussionsFavorite->numberUnreadMessages,
                        "favorite" => $discussionsFavorite->favorite,
                    ];
                    // discussion_id
                    // profile_photo
                    // firstname
                    // lastname
                    // message
                @endphp


                @php
                    if($discussionsFavorite->user1 == auth()->user())
                        $discussionsFavorite->user = $discussionsFavorite->user2;
                    else
                        $discussionsFavorite->user = $discussionsFavorite->user1;
                @endphp
                @livewire('discussion-component', ['data' => $data],key($discussionsFavorite->id))
                @endforeach
                @foreach ($groupesFavorites as $groupeFavorite)
                    @php
                        // id
                        //photo
                        //nom
                        // nombre_membres
                        // numberUnreadMessages
                        $data = [
                            "id" => $groupeFavorite->id,
                            "photo" => $groupeFavorite->photo,
                            "nom" => $groupeFavorite->nom,
                            "nombresMembres" => $groupeFavorite->nombreMembres,
                            "numberUnreadMessages" => random_int(-5, 9),
                        ];
                    @endphp
                    @livewire('group-component',['data' => $data],key($groupeFavorite->id))
                @endforeach
                {{-- @for ($i = 0; $i < 4; $i++)
                    <div class="message" @if ($i == 0) id="active" @endif>
                        <div class="profileImage">
                            <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="">
                            <div class="onlineIndicator">
                            </div>
                        </div>
                        <div class="center">
                            <h3 class="nom">Victoria Lane</h3>
                            <p class="apercuMessage">
                                {{ Illuminate\Support\Str::limit(Illuminate\Support\Str::random(40), 25) }}</p>
                        </div>
                        @php
                            $number = random_int(-5, 9);
                        @endphp
                        @if ($number > 0)
                            <div class="numberUnreadMessages">
                                {{ $number }}
                            </div>
                        @endif
                    </div>
                @endfor --}}
            </div>






            @php
                $discussions =$discussions->filter(function($discussion){
                    return !($discussion->favorite);
                });
            @endphp
            <div id="directsMessages">
                <div class="flex">
                    <h4>Directs messages</h4>
                    <div class="plusButton">
                        <i class="fa fa-plus"></i>
                    </div>
                    {{-- <img src="{{ asset('images/auth/bg-registration-form-3.jpg') }}" alt="" class="plusButton"> --}}
                </div>
                @php

                    $id = auth()->user()->id;
                @endphp
                @foreach ($discussions as $discussion)
                @php

                    if($discussion->message == null)
                        continue;

                    //if($discussion->user1 == auth()->user())
                        //$discussion->user = $discussion->user2;
                    //else
                        //$discussion->user = $discussion->user1;


                    if($discussion->utilisateur1Id != $id){
                        $firstname = $discussion->utilisateur1FirstName;
                        $lastname = $discussion->utilisateur1LastName;
                        $profile_photo = $discussion->utilisateur1Photo;
                    }
                    else{
                       $firstname = $discussion->utilisateur2FirstName;
                       $lastname = $discussion->utilisateur2LastName;
                       $profile_photo = $discussion->utilisateur2Photo;
                    }
                    $data = [
                        "id" => $discussion->id,
                        "profile_photo" => $profile_photo,
                        "firstname" => $firstname,
                        "lastname" => $lastname,
                        "message" => $discussion->message,
                        "numberUnreadMessages" => $discussion->numberUnreadMessages,
                        "favorite" => $discussion->favorite,
                    ];
                    // discussion_id
                    // profile_photo
                    // firstname
                    // lastname
                    // message
                @endphp
                    @livewire('discussion-component', ['data' => $data],key($discussion->id))
                @endforeach
            </div>
            @php
                $groupes =$groupes->filter(function($groupe){
                    return !($groupe->favorite);
                });
            @endphp
            <div id="channels">
                <div class="flex">
                    <h4>Channels</h4>
                    <div class="plusButton" data-toggle="modal" data-target="#newGroupModal">
                        <i class="fa fa-plus"></i>
                    </div>
                    {{-- <img src="{{ asset('images/auth/bg-registration-form-3.jpg') }}" alt="" class="plusButton"> --}}
                </div>
                @foreach($groupes as $groupe)
                @php
                    // id
                    //photo
                    //nom
                    // nombre_membres
                    // numberUnreadMessages
                    $data = [
                        "id" => $groupe->id,
                        "photo" => $groupe->photo,
                        "nom" => $groupe->nom,
                        "nombresMembres" => $groupe->nombreMembres,
                        "numberUnreadMessages" => random_int(-5, 9),
                    ];
                @endphp
                @livewire('group-component',['data' => $data],key($groupe->id))
                @endforeach
            </div>
        </div>
        </div>




    <script>



                {{-- @if(session()->has('discussionActifId'))
                window.addEventListener('activeDiscussion', event => {
                    document.querySelectorAll('.message').forEach((discussion) => {
                        discussion.classList.remove('active');
                    });

                    const selectedDiscussion = document.querySelector(`.message[data-discussion-id="{{ session("discussionActifId") }}"]`);
                    if (selectedDiscussion) {
                        selectedDiscussion.classList.add('active');
                    }

                });
            @elseif (session()->has('groupActifId'))
            window.addEventListener('activeGroup', event => {
                document.querySelectorAll('.message').forEach((discussion) => {
                discussion.classList.remove('active');
            });

            const selectedDiscussion = document.querySelector(`.message[data-group-id="{{ session()->get('groupActifId') }}"]`);
            if (selectedDiscussion) {
                selectedDiscussion.classList.add('active');
            }

            });
            @endif --}}



        window.addEventListener('activeDiscussion', event => {
            document.querySelectorAll('.message').forEach((discussion) => {
                discussion.classList.remove('active');
            });

            const selectedDiscussion = document.querySelector(`.message[data-discussion-id="${event.detail.id}"]`);
            if (selectedDiscussion) {
                selectedDiscussion.classList.add('active');
            }
            {{-- alert('Name updated to: ' + event.detail.id); --}}
        })


        window.addEventListener('activeGroup', event => {
            document.querySelectorAll('.message').forEach((discussion) => {
                discussion.classList.remove('active');
            });

            const selectedDiscussion = document.querySelector(`.message[data-group-id="${event.detail.id}"]`);
            if (selectedDiscussion) {
                selectedDiscussion.classList.add('active');
            }
            {{-- alert('Name updated to: ' + event.detail.id); --}}
        })
    </script>

    {{-- Cette partie est pour la partie rechercher --}}

    <script>
        const searchField = document.querySelector('#searchContainer > input[type=text]');

        searchField.addEventListener('keyup',(e)=>{
            document.querySelectorAll('#messages .message').forEach((conversation) => {
                if(conversation.querySelector('h3.nom').innerText.toLowerCase().includes(e.target.value.toLowerCase())){
                    conversation.style.display = "flex";
                }else{
                    conversation.style.display = "none";
                }
            })
            const fav = Array.from(document.querySelectorAll('#messages #favourites .message'));

            let = n = 0;

            if(isAllMessageInDisplayNone(fav)){
                document.querySelector('#messages #favourites').style.display = "none";
                n++;
            }else{
                document.querySelector('#messages #favourites').style.display = "block";
            }

            const disc = Array.from(document.querySelectorAll('#messages #directsMessages .message'));

            if(isAllMessageInDisplayNone(disc)){
                document.querySelector('#messages #directsMessages').style.display = "none";
                n++;
            }else{
                document.querySelector('#messages #directsMessages').style.display = "block";
            }


            const groups = Array.from(document.querySelectorAll('#messages #channels .message'));

            if(isAllMessageInDisplayNone(groups)){
                document.querySelector('#messages #channels').style.display = "none";
                n++;
            }else{
                document.querySelector('#messages #channels').style.display = "block";
            }


            if(n === 3){
                document.querySelector('#messages #noResult').style.display = "block";
            }else{
                document.querySelector('#messages #noResult').style.display = "none";
            }
        });

        function isAllMessageInDisplayNone(arrayOfElements){
            let n = 0;

            for(let f of arrayOfElements){
                if(f.style.display === "none"){
                    n++;
                }
            }

            return n === arrayOfElements.length;
        }

    </script>



    {{-- Modals are here --}}
        {{-- Create group modal --}}



</div>
