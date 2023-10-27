<div>
    @if($composantACharger == 1)
        @livewire('contact-component')
    @elseif($composantACharger == 2)
        @livewire('message-component')
        @livewire('create-group-modal-component')
    @elseif($composantACharger == 3)
        @livewire('profile-management-componenent')
    @endif
</div>
