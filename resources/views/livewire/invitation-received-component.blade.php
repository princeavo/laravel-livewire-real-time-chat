<div id="invitationsSent">
@if($invitationsReceived->isNotEmpty())
    <h6>Invitations recues</h6>

    {{-- <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
          <button class="p-3 accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
            Invitations envoyées
          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            @for($i = 0; $i < 20; $i++)
                <div class="invitation">
                <div class="receverProfile">
                    <i class="fa fa-contact-book"></i>
                    <span>avohouprince@gmail.com</span>
                </div>
                <div class="options">
                    <div class="btn-group">
                        <a class="btn" data-toggle="dropdown" href="#" style="position: relative;top:-10px">
                          ...
                        </a>
                        <ul class="dropdown-menu" style="font-size:12px !important">
                          <!-- dropdown menu links -->
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </ul>
                      </div>
                </div>
            </div>
            @endfor
          </div>
        </div>
      </div>

    </div> --}}


    {{-- @php
        dump($invitationsSent);
    @endphp --}}

    @php
        $idModal = "seeInvitationModal";
    @endphp

        <livewire:contact-modal-component :idModal="$idModal">

    @foreach($invitationsReceived as  $invitationReceived)
        <div class="invitation">
        <div class="receverProfile">
            <i class="fa fa-contact-book"></i>
            <span>{{ $invitationReceived->sender->email }}</span>
        </div>
        <div class="options">
            <div class="btn-group">
                <a class="btn" data-toggle="dropdown" href="#" style="position: relative;top:-10px">
                  ...
                </a>
                <ul class="dropdown-menu" style="font-size:12px !important">
                  <!-- dropdown menu links -->
                  <li class="dropdown-item" data-toggle="modal" data-target="#{{ $idModal }}" wire:click="$emitTo('contact-modal-component','seeInvitation',{{ $invitationReceived->id  }})">Voir</li>
                  <li class="dropdown-item" wire:click="$emitTo('contact-modal-component','acceptInvitation',{{ $invitationReceived->id  }})">Accepter</li>
                  <div class="dropdown-divider"></div>
                  <li class="dropdown-item text-danger" wire:click='refuser({{ $invitationReceived->id }})'>Refuser</li>
                </ul>
              </div>
        </div>
    </div>
    @endforeach

@endif
</div>
