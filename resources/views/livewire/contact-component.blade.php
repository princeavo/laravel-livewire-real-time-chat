<div id="contacts">
    @php
        //dd($contacts);
        $idModal = "newContactModal";
    @endphp
    <div class="top">
        <div id="contactRow">
            <p id="messageTitle">Contact</p>
            <i class="fa fa-plus" data-toggle="modal" data-target="#{{ $idModal }}"></i>
        </div>
        <div id="searchContainer">
            <input type="text" placeholder="Search contact">
        </div>
    </div>
    <div id="classement">
        @foreach ($contacts as $letter => $contactGroupe)
        <div class="letter">
            <div class="head">
                <h4>{{ $letter }}</h4>
                <hr>
            </div>
            @foreach($contactGroupe as $contact)
            <div class="contactApercu">
                <div class="contactProfile" wire:click='messageAContact({{ $contact->user->id }})'>
                    <img src="{{ asset("storage/{$contact->user->profile_photo}") }}" alt="">
                    <h6>{{ $contact->user->lastname }} {{ $contact->user->firstname }} {{ $contact->user->id }}</h6>
                </div>
                <div class="options">
                    <div class="btn-group">
                        <a class="btn " data-toggle="dropdown" href="#" style="position: relative;top:-10px">
                          ...
                        </a>
                        <ul class="dropdown-menu" style="font-size:12px !important">
                          <!-- dropdown menu links -->
                          @if(!($contact->isBlocked1 || $contact->isBlocked2))
                            <li class="dropdown-item" wire:click='messageAContact({{ $contact->user->id }})'><i class="fa fa-message" style="color: #6d75c5" ></i> Message</li>
                            <li class="dropdown-item" wire:click='blockUser({{ $contact->user->id }})'><i class="fa fa-stop text-danger"></i> Bloquer</li>
                          @else
                            <li class="dropdown-item" wire:click='unBlockUser({{ $contact->user->id }})'><i class="fa fa-lock-open text-success"></i>Débloquer</li>
                          @endif
                          <div class="dropdown-divider"></div>
                          <li class="dropdown-item text-danger" wire:click='deleteFromMyContacts({{ $contact->user->id }})'>Supprimer de mes contacts</li>
                        </ul>
                      </div>
                </div>
            </div>
            @endforeach
            {{-- <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div> --}}
        </div>
        @endforeach

        {{-- <div class="letter">
            <div class="head">
                <h4>A</h4>
                <hr>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
        </div>
        <div class="letter">
            <div class="head">
                <h4>A</h4>
                <hr>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
        </div>
        <div class="letter">
            <div class="head">
                <h4>A</h4>
                <hr>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
        </div>
        <div class="letter">
            <div class="head">
                <h4>A</h4>
                <hr>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
        </div>
        <div class="letter">
            <div class="head">
                <h4>A</h4>
                <hr>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
        </div>
        <div class="letter">
            <div class="head">
                <h4>A</h4>
                <hr>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
            <div class="contactApercu">
                <div class="contactProfile">
                    <img src="{{ asset('images/man.png') }}" alt="">
                    <h6>AVOHOU Prince Boris</h6>
                </div>
                <div class="options">
                    texte
                </div>
            </div>
        </div> --}}

        <livewire:contact-modal-component :idModal="$idModal">



    </div>
    @livewire('invitations-sent-component')
    @livewire('invitation-received-component')

</div>
