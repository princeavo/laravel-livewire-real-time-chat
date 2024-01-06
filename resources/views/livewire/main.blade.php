<body wire:keydown.escape="$emitTo('conversation-bloc-component','closeDiscussion')">


    @livewire('received-discussion-broadcoasting')
    @livewire('add-tofavorites-component')

    @php
        $user = auth()->user();
        //event(new \App\Events\NewMessageSent());
    @endphp
    <div id="aside">
        <div class="top">
            <button type="button" class="active" title="Chat site"><i class="fa fa-comments" aria-hidden="true" wire:click="$emitTo('message-contact-management-component','two')" ></i></button>
            <button type="button" class="active" title="Contacts"><i class="fa fa-cog "  wire:click="$emitTo('message-contact-management-component','three')"></i></button>
            {{-- <img src="{{ asset("images/chat-bubble.png") }}" alt=""> --}}
            {{-- <img src="{{ asset('images/auth/bg-registration-form-3.jpg') }}" alt=""> --}}
            <button type="button" class="active" title="Messages"><img src="{{ asset('images/icons8-chat-48.png') }}" alt="" wire:click="$emitTo('message-contact-management-component','two')"></button>
            <button type="button" class="active" title="Your profile"><i class="fa fa-user " aria-hidden="true" wire:click="$emitTo('message-contact-management-component','one')"></i></button>
            <button type="button" class="active" title="Saved messages"><i class="fa fa-save " aria-hidden="true" wire:click="$emitTo('message-contact-management-component','one')"></i></button>
            {{-- Je dois emmetre un event vers message component --}}
        </div>

        <div class="bottom">
            {{ $user->firstname }}  {{ $user->lastname }}   {{ $user->id }}
            {{-- <img src="{{ asset('images/auth/bg-registration-form-3.jpg') }}" alt=""> --}}
            <i class="fa fa-lock"></i>
            <a href="{{ route('logout') }}" id="logoutLink">Logout<i class="fa fa-location-pin-lock" class="logout"></i></a>
            <form action="{{ route('logout') }}" method="POST" style="display: none" id="logoutForm">
                @csrf
                @method('POST')
            </form>
            <img src="{{ asset("storage/{$user->profile_photo}") }}" alt="" id="profile">
        </div>
    </div>

    @livewire('message-contact-management-component')



    {{-- @livewire('top-component') --}}



    @livewire('loading-component')





    {{-- Create Group Modal here --}}



    @livewire('conversation-bloc-component')



    <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog"  tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image en plein écran</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('images/auth/AVOHOU_Prince.jpg') }}" alt="Image en plein écran" style="width: 100%;">
            </div>
            <div class="modal-footer">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat esse harum iusto, facilis rem voluptate dolor labore tenetur soluta rerum?
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@livewireScripts

<script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('icons/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/slim.min.js') }}"></script>
<script  src="{{ asset('js/popper.min.js') }}" ></script>
<script src="{{ asset('js/bootstrap.min.js') }}"  ></script>

{{-- Cette partie concerne le logout --}}
<script src="{{ asset('js/logout.js') }}"></script>



<script>
    window.addEventListener('hideContactModal', event => {
        $('#newContactModal').modal('hide');
    });
</script>



{{-- <script>
    @if(session()->has('discussionActifId'))
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.message').forEach((discussion) => {
                discussion.classList.remove('active');
            });

            const selectedDiscussion = document.querySelector(`.message[data-discussion-id="{{ session("discussionActifId") }}"]`);
            if (selectedDiscussion) {
                selectedDiscussion.classList.add('active');
            }

        });
    @elseif (session()->has('groupActifId'))
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.message').forEach((discussion) => {
        discussion.classList.remove('active');
    });

    const selectedDiscussion = document.querySelector(`.message[data-group-id="{{ session()->get('groupActifId') }}"]`);
    if (selectedDiscussion) {
        selectedDiscussion.classList.add('active');
    }

    });
    @endif


</script> --}}



{{-- Ce script est pour afficher aboutADiscussion pour les media inf. à 1200px --}}

<script>
    const detailsMediaQueriesButton = document.querySelector('#detailsMediaQueries');
    const conversationBloc = document.querySelector('#conversationBloc');
    const aboutADiscussion = document.querySelector('#aboutADiscussion');
    const closeDetail = document.querySelector('.closeDetail');

    detailsMediaQueriesButton.addEventListener('click',() => {
        aboutADiscussion.style.display = "block";
        aboutADiscussion.style.left = '0';
        aboutADiscussion.style.opacity = '1';
        aboutADiscussion.style.width='100%';
        conversationBloc.style.visibility='hidden';
    });

    closeDetail.addEventListener('click',()=>{
        aboutADiscussion.style.left = '100%';
        aboutADiscussion.style.opacity = '0';
        aboutADiscussion.style.width = '370px';
        {{-- aboutADiscussion.style.display="none"; --}}
        conversationBloc.style.visibility='visible';
    });
    window.addEventListener('resize',function(){
        if(window.innerWidth > 1200){
            conversationBloc.style.visibility = "visible";
            aboutADiscussion.style.width = '370px';
            aboutADiscussion.style.opacity = '1';
        }else{
            if(aboutADiscussion.style.width=='100%'){
                conversationBloc.style.visibility='hidden';
            }else if(aboutADiscussion.style.width == "370px" && aboutADiscussion.style.opacity =="1"){
                aboutADiscussion.style.display = "none";
            }
        }
        {{-- console.log(window.innerWidth); --}}
    });
    {{-- window.addEventListener('newMessageSentFromADiscussion',function(){
        alert("event.detail");
    }); --}}




</script>

<script defer>
    document.querySelector('#bottomButton').addEventListener('click',()=>{
        dispatchEvent(new CustomEvent('scrollToLastMessage'));
    });
</script>


<script>
    const editButton = document.querySelector('#aboutADiscussion #status .bottom button[type="button"] ');
    const saveButton = document.querySelector('#aboutADiscussion #status .bottom button[type="submit"] ');

    const description = document.querySelector('#aboutADiscussion #status .bottom #description');
    const groupNameField = document.querySelector('#aboutADiscussion #status .bottom input');

    editButton.addEventListener('click',()=>{
        saveButton.style.display = "inline-block";
        editButton.style.display = "none";

        description.removeAttribute('disabled');
        groupNameField.removeAttribute('disabled');

    });
</script>

<script>
    {{-- window.addEventListener('manageActive',function(e){
        document.querySelectorAll('.message.active').forEach((element)=>{
            element.classList.remove('active');
        });
        document.querySelector(`.message[wire:id="${e.detail.id}"]`).classList.add('active');
    }); --}}

    window.addEventListener('addToFavorite',()=>{
        const h4 = document.querySelector('#messages #favourites h4');
        const div = document.querySelector('#messages .message.active');

        h4.insertAdjacentElement('afterend',div);
    });

    window.addEventListener('removeToDiscussionFavorite',()=>{
        const h4 = document.querySelector('#messages #directsMessages .flex');
        const div = document.querySelector('#messages .message.active');

        h4.insertAdjacentElement('afterend',div);
    });

    window.addEventListener('removeToGroupFavorite',()=>{
        const h4 = document.querySelector('#messages #channels .flex');
        const div = document.querySelector('#messages .message.active');

        h4.insertAdjacentElement('afterend',div);
    });


</script>

<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>


<script>
    {{-- window.addEventListener('sing',function(){
        Window.newMessageSong = new Audio('song.mp3');
        console.log(Window.newMessageSong.play());
    }); --}}
</script>


{{-- <script>
    new TomSelect("#membres",{
        plugins: ['remove_button'],
        persist: false,
        create: true,
        maxItems: 1,
    });
    new TomSelect('#input-tags2',{
        plugins: ['remove_button'],
        persist: false,
        create: true,
        maxItems: 1,
    });
</script> --}}



</body>

</html>
