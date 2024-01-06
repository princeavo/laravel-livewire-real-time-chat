<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DiscussionComponent extends Component
{


    // discussion_id
    // profile_photo
    // firstname
    // lastname
    // message

    // public $listeners = ["removeIsActive"];

    public function getListeners()
    {
        return [
            "showApercuMessage" . $this->data['id'] => "showApercuMessage",
            "showApercuMessageWithReset" . $this->data['id'] => "showApercuMessageWithReset",
            "resetCount" . $this->data['id'] => "resetCount"
        ];
    }

    public $data;

    public function mount($data)
    {
        $this->data = array_merge($data, ['isActive' => session()->has('discussionActifId') && session('discussionActifId') == $data['id'], 'class' => null]);
    }

    public function render()
    {
        return view('livewire.discussion-component');
    }

    public function showConversation()
    {
        $this->emitTo('loading-component', 'load');
        $this->emit('showDiscussion', $this->data['id']);

        $this->data['class'] = null;

        //Je vais mettre read à 1 pour tous mes messages reçus

        // Message::where('discussion_id' , '=' , $this->data['id'])
        //     ->where('read','0')
        //     ->where('receiver_id',auth()->user()->id)
        //     ->update(["read" => true]);

        $this->data['numberUnreadMessages'] = 0;
        // $this->emit('removeIsActive',['isDiscussion' => true,'id' => $this->data['id']]);
        $this->data['isActive'] = true;
        // $this->dispatchBrowserEvent('manageActive',['id' => $this->id]);
    }

    public function removeIsActive($infos)
    {

        $this->data['isActive'] = false;

        if ($infos['isDiscussion'] && $infos['id'] == $this->data['id']) {
            $this->data['isActive'] = true;
        }
    }

    public function showApercuMessage($message, $incr = true)
    {
        $this->data['message'] = $message;
        if ($incr)
            $this->data['numberUnreadMessages']++;
        $this->data['scrollToUp'] = true;

        if ($this->data['id'] !== session()->get('discussionActifId')) {
            $this->dispatchBrowserEvent('removeNewMessageClass');
            $this->data['class'] = 'newMessage';
            $this->data['isActive'] = false;
            $this->dispatchBrowserEvent('newMessageDiscussion');
        } else {
            $this->dispatchBrowserEvent('newMessageSentFromActiveDiscussion');
        }

        // if(is_null(session()->get('discussionActifId')) && is_null(session()->get('groupActifId'))){
        //     $this->data['isActive'] = true;
        //     $this->dispatchBrowserEvent('moveActiveDiscussion');
        // }

    }

    public function resetCount()
    {
        $this->data['numberUnreadMessages'] = 0;
    }

    public function showApercuMessageWithReset($message)
    {
        $this->showApercuMessage($message, false);
        $this->resetCount();
    }
}
