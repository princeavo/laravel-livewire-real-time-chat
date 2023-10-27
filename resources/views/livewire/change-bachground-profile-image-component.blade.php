<div id="settings" style="background-image: @if($backgroundImage) url('{{ $backgroundImage->temporaryUrl() }}') @else url({{Illuminate\Support\Facades\Storage::url($photo) }}) @endif">
    <div>
        <h4>Settings</h4>
        <label for="image"><i class="fa fa-pen"></i></label>
        <input type="file" class="d-none" id="image" wire:model.defer='backgroundImage' accept="image/*">
    </div>
</div>
