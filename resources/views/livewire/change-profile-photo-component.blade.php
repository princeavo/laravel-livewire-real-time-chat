<div>
    <img src="@if($photo) {{ $photo->temporaryUrl() }} @else {{Illuminate\Support\Facades\Storage::url($profile_photo) }} @endif" alt="">
    <label for="profilePhoto" id="camera"><i class="fa fa-camera" ></i></label>
    <input type="file" name="profile" class="d-none" id="profilePhoto" wire:model='photo' accept="image/*">
</div>
