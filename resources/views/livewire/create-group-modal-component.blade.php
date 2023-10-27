<div class="modal fade" id="newGroupModal" tabindex="-1" role="dialog" aria-labelledby="newGroupModalTitle" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form wire:submit.prevent='createGroup' class="modal-content" enctype="multipart/form-data">
            <div class="modal-header" id="addGroupModalHead">
                <h6 class="modal-title" id="titre">Create new Group</h6>
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
                        <label id="email_label" for="email" class="mb-1">Nom du groupe</label>
                        <input id="email" name="nom_group" type="text" class="form-control @error('nom_group') is-invalid @enderror" wire:model.defer='nom_group' required  autocomplete="off"/>
                        @error('nom_group') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label for="membres">Selectionnez les membres</label>
                        <select id="membres" class="form-control @error('membre_group') is-invalid @enderror" name="membres" multiple wire:model.defer='membre_group' required>
                            @foreach($contacts as $contact)
                            <option value="{{ $contact->user->id }}" >{{ $contact->user->firstname }} {{ $contact->user->lastname }}</option>
                            @endforeach
                        </select>
                        @error('membre_group') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    @if($photo)
                    <img class="img-thumbnail" src="{{ $photo->temporaryUrl() }}" alt="" style="max-height: 80px">
                    @endif
                    <div class=" file-upload">
                        <label for="file_upload">Choisir un logo</label>
                        <div class="custom-file">
                            <div class="mb-3 input-group">
                                <input id="file_upload" name="file_upload" type="file" class="custom-file-input form-control" aria-label="File Upload" accept="image/*" wire:model.defer='photo'/>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label id="message_label" for="message" class="mb-2 required">Description</label>
                        <textarea id="message" name="description" rows="5" class="form-control @error('description_group') is-invalid @enderror" wire:model.defer='description_group' required></textarea>
                        @error('description_group') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeButton" data-dismiss="modal">Fermer</button>
                <button type="submit" id="inviteButton" wire:loading.remove>Créer</button>
                <button type="submit" id="inviteButton"  disabled wire:loading>Validation...</button>
            </div>
        </form>
    </div>
</div>
