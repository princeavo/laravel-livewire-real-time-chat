<div id="profileManagement">
    <div class="top">
        @livewire('change-bachground-profile-image-component')
        <div class="photoBloc">
            <div class="photo">
                @livewire('change-profile-photo-component')
                <div class="drop">
                    <div class="dropdown">
                        <button id="activeStatus" class="btn" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Text <i class="fa fa-chevron-down"></i> </button>
                        <ul class="dropdown-menu" aria-labelledby="activeStatus">
                            <li class="dropdown-item">Active</li>
                            <li class="dropdown-item">Away</li>
                            <li class="dropdown-item">Do not disturb</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="bottom">
        @livewire('personal-info-component')

        <div class="accordion accordion-flush" id="privacy">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacyOne" aria-expanded="true" aria-controls="flush-collapseOne">
                <i class="fa fa-lock"></i>
                Privacy
              </button>
            </h2>
            <div id="privacyOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne">
              <div class="accordion-body">
                <h6>Who can see my personal info</h6>
                <div class="select">
                    <label id="profile_photo_label" for="profile_photo">Profile photo</label>
                    <div class="mb-3 input-group">
                        <select id="profile_photo" name="profile_photo" class="form-control form-select" aria-label="">
                            <option>EveryOne</option>
                            <option>Nobody</option>
                        </select>
                    </div>
                </div>
                <div class="select">
                    <label id="profile_photo_label" for="profile_photo">Profile photo</label>
                    <div class="mb-3 input-group">
                        <select id="profile_photo" name="profile_photo" class="form-control form-select" aria-label="">
                            <option>EveryOne</option>
                            <option>Nobody</option>
                        </select>
                    </div>
                </div>
                <div class="select">
                    <label id="profile_photo_label" for="profile_photo">Profile photo</label>
                    <div class="mb-3 input-group">
                        <select id="profile_photo" name="profile_photo" class="form-control form-select" aria-label="">
                            <option>EveryOne</option>
                            <option>Nobody</option>
                        </select>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <label class="form-check-label" for="lastSeen">Last seen</label>
                    <input class="form-check-input" type="checkbox" id="lastSeen" checked>
                </div>
                <div class="form-check form-switch">
                    <label class="form-check-label" for="read-receipts">Read receipts</label>
                    <input class="form-check-input" type="checkbox" id="read-receipts" checked>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion accordion-flush" id="security">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headerOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#securityOne" aria-expanded="true" aria-controls="flush-collapseOne">
                <i class="fa fa-check-square"></i>
                    Security
              </button>
            </h2>
            <div id="securityOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="lastSeen">Show security notification</label>
                    <input class="form-check-input" type="checkbox" id="lastSeen" checked>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion accordion-flush" id="help">
          <div class="accordion-item">
            <h2 class="accordion-header" id="helpOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#helpnOne" aria-expanded="true" aria-controls="flush-collapseOne">
                <i class="fa fa-question-circle"></i>
                Help
              </button>
            </h2>
            <div id="helpnOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <a href="">FAQS</a>
                <a href="">Contact</a>
                <a href="">Terms & Privacy policy</a>
              </div>
            </div>
          </div>

        </div>
    </div>
    {{-- <i class="fa fa-question-circle"></i> --}}
    {{-- <i class="fa fa-check-square"></i> --}}
</div>
