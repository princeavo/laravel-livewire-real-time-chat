<?php

namespace App\Http\Livewire;

use App\Events\DeleteDiscussionMessageEvent;
use App\Models\Discussion;
use App\Models\Message;
use Livewire\Component;
use Exception;
use Illuminate\Support\Facades\Storage;

class MessageSentComponent extends Component
{

    use MessageInterface, EmojiDetectionTrait;


    public function getListeners()
    {
        return [
            "markRead" . $this->data['id']  => "markRead",
            "markRead" => "markRead",
            'delete' . $this->data['id'] => "deleted"
        ];
        // if (count($this->data) != 1) {
        //     if ($this->data['isDeleted'])
        //         return [];
        //     if (!$this->data['read']) {
        //         return [
        //             "markRead" . $this->data['id'] => "markRead",
        //             "markRead" => "markRead",
        //             'delete' . $this->data['id'] => "deleted"
        //         ];
        //     }
        //     return ['delete' . $this->data['id'] => "deleted", "markRead"];
        // }
        // return ['delete' . $this->data['id'] => "deleted"]; //Ceci c'est pour un message supprimé chez moi mais pas chez l'autre

    }

    private function deleteMessage()
    {
        try {
            // Message::find($this->data['id'])->delete();


            $discussion = Discussion::where('id', session()->get('discussionActifId'))->first();

            $receiverId = ($discussion->user1_id == auth()->user()->id) ? $discussion->user2_id : $discussion->user1_id;



            event(new DeleteDiscussionMessageEvent(['receiver_id' => $receiverId, "message_id" => $this->data['id']]));

            // $this->data = null;

            $this->data = ["isDeleted" => true, "contenu" => "This message is deleted", "id" => $this->data['id']];

            if ($this->data['image']) {
                Storage::disk('public')->delete($this->data['image']);
            }

            // dd("ok");

        } catch (Exception $e) {
        }
    }
    public function render()
    {
        return view('livewire.message-sent-component');
    }

    // public function est_emoji($caractere) {
    //     /**
    //      * Les emojis Unicode couvrent une large gamme de codes Unicode, et il est difficile de les énumérer tous. Cependant, je vais vous donner quelques plages Unicode couramment utilisées pour les emojis. Notez que de nouvelles emojis sont régulièrement ajoutées, donc cette liste peut ne pas être exhaustive.

    //         Voici quelques plages Unicode courantes pour les emojis :

    //         Plage Emoji de base :

    //         De U+1F600 à U+1F64F : Emojis émotionnels (sourires, visages, etc.)
    //         De U+1F300 à U+1F5FF : Symboles et emojis variés
    //         De U+1F680 à U+1F6FF : Transports et emojis liés à la technologie
    //         Plage Emoji supplémentaire :

    //         De U+1F700 à U+1F77F : Emojis liés à la météo
    //         De U+1F780 à U+1F7FF : Emojis liés à la nature (animaux, plantes, etc.)
    //         De U+1F800 à U+1F8FF : Emojis liés à la culture, la nourriture, et l'art
    //         Plage Emoji supplémentaire 2 :

    //         De U+1F900 à U+1F9FF : Emojis liés à la personne (cheveux, peau, professions)
    //         De U+1FA00 à U+1FA6F : Emojis liés à des objets et activités spécifiques (jeux, sports, etc.)
    //         De U+1FA70 à U+1FAFF : Emojis liés à la science et la médecine
    //         De U+1F004 : Emoji de la carte à jouer (🀄)
    //         Plage Emoji de symboles divers :

    //         De U+1F0CF : Emoji de la carte de tarot (🃏)
    //         De U+1F170 à U+1F251 : Emojis liés aux symboles et signes divers (☕, ♻️, etc.)
    //         Ces plages Unicode couvrent une grande partie des emojis couramment utilisés. Cependant, gardez à l'esprit que de nouveaux emojis sont ajoutés régulièrement avec chaque mise à jour Unicode, ce qui signifie que la liste complète des emojis Unicode peut évoluer avec le temps. Vous pouvez vérifier la dernière version du standard Unicode pour obtenir la liste complète des emojis avec leurs codes associés.
    //      */
    //     $motifEmoji = '/^[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{1F004}\x{1F0CF}\x{1F170}-\x{1F251}\x{2764}\x{1F493}]$/u';


    //     // Utilisez preg_match pour rechercher le motif d'emoji dans le caractère
    //     if (preg_match($motifEmoji, $caractere)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function markRead()
    {
        $this->data['read'] = true;
    }

    public function deleted()
    {
        if ($this->data)
            $this->data = ["isDeleted" => true, "contenu" => "This message is deleted"];
    }

    public function deleteDiscussionMessage()
    {

        Message::where('id', $this->data['id'])->update(['isDeleted' => true]);

        $discussion = Discussion::where('id', session()->get('discussionActifId'))->first();

        $receiverId = ($discussion->user1_id == auth()->user()->id) ? $discussion->user2_id : $discussion->user1_id;
        event(new DeleteDiscussionMessageEvent(['receiver_id' => $receiverId, "message_id" => $this->data['id']]));


        $this->data = ["isDeleted" => true, "contenu" => "This message is deleted"];
        // $this->deleteMessage();
        // $this->dispatchBrowserEvent('newMessageDeletedFromADiscussion');
    }
}
