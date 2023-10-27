<div class="accordion" id="personal-info">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#personal-infoOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fa fa-contact-book"></i>
          Personal Info
        </button>
      </h2>
      <div id="personal-infoOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
        <div class="accordion-body">
            @if (session()->has('updateProfileSuccessMessage'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Success</strong> {{ session('updateProfileSuccessMessage') }}
              </div>

              <script>
                var alertList = document.querySelectorAll('.alert');
                alertList.forEach(function (alert) {
                  new bootstrap.Alert(alert)
                })
              </script>
            @endif

          <form action="">
              <i class="fa fa-pen editPersonalInfo "></i>
              <i class="fa fa-save editPersonalInfo d-none" wire:click='updateProfile'></i>
              <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text"
                  class="form-control" disabled name="firstname" id="firstname" aria-describedby="helpId" placeholder="Votre prenom" value="{{ $firstname }}" wire:model.defer='firstname'>
                <small id="helpId" class="form-text text-muted">Help text</small>
              </div>
              <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text"
                  class="form-control" disabled name="lastname" id="lastname" aria-describedby="helpId" placeholder="Votre nom" value="{{ $lastname }}" wire:model.defer='lastname'>
                <small id="helpId" class="form-text text-muted">Help text</small>
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email"
                    class="form-control" disabled name="email" id="email" aria-describedby="helpId" placeholder="Votre email" value="{{ $email }}" wire:model.defer='email'>
                  <small id="helpId" class="form-text text-danger"><i class="fa fa-warning"></i> Si vous le modifier nous vous enverrons un mail de confirmation.Sans cette confirmation vous n'aurez pas accès à votre compte.</small>
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone No</label>
                  <input type="tel"
                    class="form-control" disabled name="phone" id="phone" aria-describedby="helpId" placeholder="Votre numéro de tel" value="{{ $contact }}" wire:model.defer='contact'>
                  <small id="helpId" class="form-text text-muted">Help text</small>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text"
                      class="form-control" disabled name="status" id="status" aria-describedby="helpId" placeholder="Votre status" value="{{ $status }}" wire:model.defer='status'>
                    <small id="helpId" class="form-text text-muted">Help text</small>
                  </div>
                <div class="mb-3">
                  <label for="location" class="form-label">Location</label>
                  <select name="location" class="form-control" disabled wire:model.defer='pays_id' id="location">
                    @foreach ($pays as $singlePays)
                        <option value="{{ $singlePays->id }}" @selected($singlePays->id == $pays_id)>{{ $singlePays->name }}</option>
                    @endforeach
                  </select>
                  {{-- <input type="text"
                    class="form-control" disabled name="location" id="location" aria-describedby="helpId" placeholder="ville,pays" value="{{ $pays_id }}" wire:model.defer='pays_id'> --}}
                  <small id="helpId" class="form-text text-muted">Help text</small>
                </div>
          </form>
        </div>
      </div>
    </div>

    <script>
        document.querySelector("#personal-info .editPersonalInfo.fa-pen").addEventListener('click',(e)=>{
            console.log(document.querySelectorAll('#personal-infoOne form .input[disabled]'));
            document.querySelectorAll('#personal-info #personal-infoOne form [disabled]').forEach((input) => {
                input.removeAttribute('disabled');
            });
            e.target.remove();
            document.querySelector("#personal-info .editPersonalInfo.fa-save").classList.remove('d-none');
        });
    </script>

  </div>
