<div style="position:relative">
    @if(! $hide)
    <div style="display:flex;justify-content:flex-end;background:transparent;position:absolute;top:-70px;left:0;right: 0;padding:25px">
        {{-- <div class="d-flex justify-content-center" style="background-color: #fff;color:rgb(255, 0, 0);width: 20px;height: 20px;border-radius: 50%;position: relative;right: -10px;top:0px">
            <span>3</span>
        </div> --}}
        <button  id="bottomButton" style="border: none;background-color: blueviolet;color:white;border-radius: 50%;width: 30px;height: 30px;"><i class="fa fa-arrow-down" style="font-size: 1.2rem"></i></button>
    </div>
    @if($image)
        <img src="{{ $image->temporaryUrl() }}" alt="" style="width: 150px;position: relative;left:30px;top:-15px">
    @endif
    <form class="bottom" wire:submit.prevent='newMessage'>
        <label for="image"><img src="{{ asset('images/auth/favicon.png') }}" alt=""></label>
        <input type="file" name="image" id="image" class="d-none" accept="image/*" wire:model='image'>
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <input type="text" placeholder="Type your message" wire:model.defer='messageContent'>
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
        <img src="{{ asset('images/auth/favicon.png') }}" alt="">
    </form>
    @endif
</div>
