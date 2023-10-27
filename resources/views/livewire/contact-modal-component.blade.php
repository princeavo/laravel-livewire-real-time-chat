{{-- <!--Add Contact Modal --> --}}
<div class="modal fade contactModal" id="{{ $idModal }}" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="newContactModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header addContactModalHead" id="addContactModalHead">
                <h6 class="modal-title" id="titre">New Contact</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="{{ $submitFonction }}" wire:target='inviteContact'>
                <div class="modal-body">
                    @if (session()->has('newInvitationSentMessage'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Success</strong> {{ session('newInvitationSentMessage') }}
                        </div>

                        <script>
                            var alertList = document.querySelectorAll('.alert');
                            alertList.forEach(function(alert) {
                                new bootstrap.Alert(alert)
                            })
                        </script>
                    @endif

                    <div class="mb-3">
                        <label id="email_label" for="email" class="mb-1">Email Address</label>
                        <input id="email" name="email" type="email" placeholder="jonhdoe@exemple.fr"
                            class="form-control @error('email') is-invalid @enderror" wire:model.defer='email' required @if(!$isEmailFielEditable) readonly @endif/>
                        @error('email')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 ">
                        <label id="message_label" for="message" class="mb-2 required">Invitation message</label>
                        <textarea id="message" required name="message" rows="5" class="form-control @error('invitationMessage') is-invalid @enderror"
                            placeholder="I'm Jonh Doe.I'd like to chat with you about our travel.Thanks!" wire:model.defer='invitationMessage' @if(!$isMessageFielEditable) readonly @endif></textarea>
                            @error('invitationMessage')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeButton" data-dismiss="modal">Close</button>
                    <button type="submit" id="inviteButton"  wire:loading.class='d-none'>{{ $submitButtonName }}</button>
                    <button type="button" id="inviteButton" wire:target="@if($submitButtonName != 'Invite') updateInvitationSubmit @else inviteContact @endif" wire:loading disabled style="background-color: #6a6e97">Sending</button>
                </div>
            </form>
        </div>
    </div>
</div>
