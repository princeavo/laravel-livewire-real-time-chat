<div class="modal fade" id="addMemberToGroupModal" tabindex="-1" role="dialog" aria-labelledby="newGroupModalTitle" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">


        @if($contacts->isEmpty())

        <div  class="modal-content">
            <div class="modal-header" id="addMemberToGroupModalHead">
                <h6 class="modal-title" id="titre">Add a member to group</h6>
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
                    Vous n'avez pas de contacts pour ajouter d'autres membres.!
                </div>
            </div>
        </div>

        @else

            <form wire:submit.prevent='addMemberToGroup' class="modal-content" enctype="multipart/form-data">
                <div class="modal-header" id="addMemberToGroupModalHead">
                    <h6 class="modal-title" id="titre">Add a member to group</h6>
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
                        <div class="mb-3 form-group">
                            <label for="membres">Selectionnez les membres</label>
                            <select id="membres" class="form-control @error('membre_group') is-invalid @enderror" name="membres" multiple wire:model.defer='membre_group' required>
                                @foreach($contacts ?? [] as $contact)
                                <option value="{{ $contact->user->id }}" >{{ $contact->user->firstname }} {{ $contact->user->lastname }}</option>
                                @endforeach
                            </select>
                            @error('membre_group') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeButton" data-dismiss="modal">Fermer</button>
                    <button type="submit" id="inviteButton" wire:loading.remove>Ajouter les membres</button>
                    <button type="submit" id="inviteButton"  disabled wire:loading>Validation...</button>
                </div>
            </form>
        @endif
    </div>
</div>
