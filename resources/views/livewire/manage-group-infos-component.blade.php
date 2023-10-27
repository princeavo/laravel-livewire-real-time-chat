<div>
    @if($data)
        <script>
            var alertList = document.querySelectorAll('.alert');
            alertList.forEach(function(alert) {
                new bootstrap.Alert(alert)
            })
        </script>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 12px">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Error🤔!</strong>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @if (session()->has('groupeSuccessAlert'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 12px">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Success🤩!</strong>
                {{ session('groupeSuccessAlert') }}
            </div>
            @php
                session()->forget('groupeSuccessAlert');
            @endphp
        @endif



        <div class="top">



            <i class="fa fa-close closeDetail"></i>

            @if(!$data['hideOptions'])

                <div class="dropdown">
                    <button  class="btn" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">...</button>
                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                        <li class="dropdown-item " data-toggle="modal" data-target="#addMemberToGroupModal">Add a member</li>
                        <div class="form-group dropdown-item">
                            <label for="my-input">Change group photo</label>
                            {{-- @dump($errors->all()) --}}
                            <input id="my-input" class="form-control-file d-none" required type="file"
                                name="" wire:model='photo' accept="image/*">
                            {{-- <button class="dropdown-item" type="submit" >Change group photo</button> --}}
                        </div>
                        <li class="dropdown-item text-danger"
                            wire:click='leaveGroup'>Quit group</li>

                        @if($data['isAdmin'])
                        <li class="dropdown-item text-danger" wire:click="deleteGroupe">Delete group</li>
                        @endif


                    </div>
                </div>
            @endif
            @if ($photo && !$errors->any())
                <img src="{{ $photo->temporaryUrl() }}" alt="" id="photoDiscussion">
            @else
                <img src="{{ asset("storage/{$data['photo']}") }}" alt="" id="photoDiscussion">
            @endif

            <div class="separator">

            </div>
        </div>
    @endif
</div>
