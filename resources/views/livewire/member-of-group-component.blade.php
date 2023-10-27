<div @class(["accordion-body" => $data]) >
    @if($data)
    <div class="commonGroup">
        <img src="{{ asset("storage/{$data['membre']['profile_photo']}") }}"
            alt="">
        <span
            style="color: #666;font-family:'Courier New';font-size:12px">{{ $data['membre']['firstname'] }}
            {{ $data['membre']['lastname'] }}  {{ $data['membre']['id'] }}</span>

        <div class="dropdown">
            <button id="manageUserInGroup" class="btn" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">...</button>
            <div class="dropdown-menu" aria-labelledby="manageUserInGroup">
                <div class="dropdown-item ">Message</div>
                @if(!$data['hideOptions'])
                    @if ($data['auth']['isAdmin'])
                        <div class="dropdown-item text-danger"
                            wire:click='retirerDuGroupe'>
                            Retirer du groupe
                        </div>
                        @if ($data['membre']['isAdmin'])
                            <div class="dropdown-item"
                                wire:click="retirerAdmin">
                                Retirer des Admins
                            </div>
                        @else
                            <div class="dropdown-item"
                                wire:click="nommerAdmin">
                                Nommer Admin
                            </div>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
