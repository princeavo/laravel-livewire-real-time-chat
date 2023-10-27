<div class="modal fade" id="forwardMessageModal" tabindex="-1" role="dialog" aria-labelledby="forwardMessageModal" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">


        @if($contacts->isEmpty())

        <div  class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titre">Transférer un message</h6>
                <button type="button"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div  class="modal-body">
                @if(session()->has('groupSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success🤩!</strong>{{ session('groupSuccess') }}
                    </div>

                    <script>
                    var alertList = document.querySelectorAll('.alert');
                    alertList.forEach(function (alert) {
                        new bootstrap.Alert(alert)
                    })
                    </script>
                @endif
                <div class="contactVide">
                    Vous n'avez pas de contacts pour transférer ce message!
                </div>
            </div>
        </div>

        @else

            <form wire:submit.prevent='forward' class="modal-content">
                <div class="modal-header" id="addMemberToGroupModalHead">
                    <h6 class="modal-title" id="titre">Transférer un message</h6>
                    <button type="button"  data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div  class="modal-body">
                    @if(session()->has('groupSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success🤩!</strong>{{ session('groupSuccess') }}
                    </div>

                    <script>
                    var alertList = document.querySelectorAll('.alert');
                    alertList.forEach(function (alert) {
                        new bootstrap.Alert(alert)
                    })
                    </script>
                    @endif

                        <div class="mb-3">
                          <label for="" class="form-label">Modifier le message</label>
                          <textarea class="form-control @error('messageForForward') is-invalid @enderror" name="message" id="" rows="3" wire:model.defer='messageForForward'  >{{ $messageForForward }}</textarea>
                          @error('messageForForward')
                            <span class="text-sm text-danger invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="membres">Selectionnez les contacts</label>
                            {{-- <div>
                                <select id="input-tags2" value="awesome" autocomplete="off">
                                    <option>awesome</option>
                                    <option>neat</option>
                                </select>
                            </div> --}}


                            <select id="membres" class="form-control @error('contactForForward') is-invalid @enderror" name="membres" multiple wire:model.defer='contactForForward' required  >
                                @foreach($contacts ?? [] as $contact)
                                <option value="{{ $contact->user->id }}" >{{ $contact->user->firstname }} {{ $contact->user->lastname }}</option>
                                @endforeach
                            </select>

                            @error('contactForForward') <span class="invalid-feedback">{{ $message }}</span> @enderror

                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="all" id="all" name="sendToAllContacts" wire:model.defer='sendToAllContacts' >
                            <label class="form-check-label" for="all">
                              Envoyer à tous mes contacts
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeButton" data-dismiss="modal">Fermer</button>
                    <button type="submit" id="inviteButton" wire:loading.remove>Transférer</button>
                    <button type="submit" id="inviteButton"  disabled wire:loading>Loading...</button>
                </div>
            </form>
        @endif
    </div>

</div>


