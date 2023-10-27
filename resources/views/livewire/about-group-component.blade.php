<div id="aboutADiscussion">
    @if ($data)

    @php
        if($groupe['hideOptions']){
            $userNowInfos = ['groupe_id' => session()->get('groupActifId') ,'user_id' => auth()->user()->id ,'isAdmin' => 0];
        }else{
            $userNowInfos = collect($groupe['membres'])->filter(function($m){
                return $m['id'] === auth()->user()->id;
            })->first()['pivot'];
            if(!is_array($userNowInfos))
                $userNowInfos = $userNowInfos->toArray();
        }
    @endphp

        <livewire:add-member-to-group-modal-component submitFunction="addMemberToGroup">
        <div id="status">
{{-- @dd($groupe['hideOptions']) --}}

                @livewire('manage-group-infos-component',key($groupe['id']),['data' => ['id' => $groupe['id'],'photo' => $groupe['photo'],'isAdmin' => $userNowInfos['isAdmin'],'hideOptions' => $groupe['hideOptions']]])


            <div class="bottom">
                {{-- <i class="fa fa-pen" style="display:block;text-align:right;padding-inline-end:20px;padding-top:10px"></i> --}}
                @if(!$groupe['hideOptions'])
                    <form wire:submit.prevent='updateGroupeInfo'>
                        <div class="my-2">
                            <div class="d-flex">
                                <button type="submit" class="btn" style="margin-left: auto;display:none"><i
                                        class="fa fa-save"></i></button>
                                <button type="button" class="btn" style="margin-left: auto"><i
                                        class="fa fa-pen"></i></button>
                            </div>

                            <h4 class="titre">Nom du groupe</h4>
                            {{-- <span>{{ $groupe['nom'] }}</span> --}}
                            <input type="text" value="{{ $groupe['nom'] }}" disabled class="form-control" wire:model.defer='nomGroupe'>
                        </div>
                        <div id="status">
                            <h4 class="titre">Description</h4>
                            <div class="form-group">
                                <textarea id="description" class="form-control" disabled name="" rows="5" wire:model.defer='descriptionGroupe'>{{ $groupe['description'] }}</textarea>
                            </div>
                            {{-- <span>{{ $groupe['description'] }}</span> --}}
                        </div>
                    </form>
                @else
                    <div class="mb-3 mt-2">
                        <input type="text" value="{{ $groupe['nom'] }}" disabled class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <textarea id="description" class="form-control" disabled name="" rows="5">{{ $groupe['description'] }}</textarea>
                    </div>
                @endif

                <div id="info">
                    <h4 class="titre">Infos du créateur</h4>
                </div>
                <div class="info">
                    <i class="fa fa-user"></i>
                    <span>{{ $groupe['creator']['firstname'] }} {{ $groupe['creator']['lastname'] }}</span>
                </div>
                <div class="info">
                    <i class="fa fa-mail-bulk"></i>
                    <span>{{ $groupe['creator']['email'] }}</span>
                </div>
                <div class="info">
                    <i class="fa fa-phone"></i>
                    <span>{{ $groupe['creator']['contact'] ?? "Inconnu"}}</span>
                </div>
                <div class="info">
                    <i class="fa fa-location"></i>
                    <span><i>{{ $groupe['creator']['pays']['name'] ?? '' }}</i></span>
                </div>

                <div class="separator"></div>
                {{-- <h4 class="titre">Membres</h4> --}}
                <div class="mt-3 overflow">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Membres
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                @foreach ($groupe['membres'] as $membre)
                                @php
                                    $data = [
                                        "membre" => [
                                            "firstname" => $membre['firstname'],
                                            "lastname" => $membre['lastname'],
                                            "id" => $membre['id'],
                                            "isAdmin" => $membre['pivot']['isAdmin'],
                                            "profile_photo" => $membre['profile_photo'],
                                        ],
                                        "groupe" => [
                                            "id" => $groupe['id']
                                        ],
                                        "auth" => $userNowInfos,
                                        'hideOptions' => $groupe['hideOptions']
                                    ]
                                @endphp
                                    @livewire('member-of-group-component',["data" => $data],key("groupeMembre". session()->get('groupActifId') .$membre['id']))
                                @endforeach
                            </div>
                        </div>

                    </div>
                    {{-- @foreach ($groupe->membres as $membre)
                <div class="commonGroup" >
                    <img src="{{ asset("storage/{$membre->profile_photo }") }}" alt="">
                    <span style="color: #666;font-family:'Courier New';font-size:12px">{{ $membre->firstname }} {{ $membre->lastname }}</span>

                    <div class="dropdown">
                        <button id="manageUserInGroup" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                        <div class="dropdown-menu" aria-labelledby="manageUserInGroup">
                            <li class="dropdown-item text-danger" >Retirer du groupe</li>
                            <li class="dropdown-item " >Nommer Admin</li>
                        </div>
                    </div>
                </div>
            @endforeach --}}
                </div>

            </div>
        </div>
    @endif
</div>
