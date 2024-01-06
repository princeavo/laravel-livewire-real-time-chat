<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Message;
use Livewire\Component;
use App\Models\Discussion;
use App\Events\DeleteDiscussionMessageEvent;

class MessageRecevedComponent extends Component
{
    use MessageInterface, EmojiDetectionTrait;

    public function getListeners()
    {
        return [
            'delete' . $this->data['id'] => "deleted"
        ];
        // if ($this->data) {
        //     if ($this->data['isDeleted'])
        //         return [];
        //     return ['delete' . $this->data['id'] => "deleted"];
        // }
        // return ['delete' . $this->data['id'] => "deleted"];
    }


    public function render()
    {
        return view('livewire.message-receved-component');
    }

    private function deleteMessage()
    {
        try {
            // Message::find($this->data['id'])->delete();

            $discussion = Discussion::where('id', session()->get('discussionActifId'))->first();

            $receiverId = ($discussion->user1_id == auth()->user()->id) ? $discussion->user2_id : $discussion->user1_id;



            event(new DeleteDiscussionMessageEvent(['receiver_id' => $receiverId, "message_id" => $this->data['id']]));

            // $this->data = null;


            $this->data = ["isDeleted" => true, "contenu" => "This message is deleted"];
        } catch (Exception $e) {
        }
    }

    public function deleted()
    {
        // if ($this->data)
        $this->data = ["isDeleted" => true, "contenu" => "This message is deleted"];
    }
}
