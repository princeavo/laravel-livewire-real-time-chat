<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Models\Invitation;
use App\Models\User;
use Exception;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ContactModalComponent extends Component
{

    public $email, $invitationMessage, $idModal, $isEmailFielEditable = true, $isMessageFielEditable = true, $submitButtonName = "Invite", $invitationId;

    public $listeners = ["updateInvitation", "seeInvitation", "acceptInvitation"];

    // public function mount(){
    //     // $this->modalId = $modalId;
    // }

    public function render()
    {
        $submitFonction = "inviteContact";
        if ($this->submitButtonName == "Invite") {
            $submitFonction = "inviteContact";
        } elseif ($this->submitButtonName == 'Save changes') {
            $submitFonction = "updateInvitationSubmit";
        } elseif ($this->submitButtonName == 'Accepter') {
            $submitFonction = "accepter";
        }
        return view('livewire.contact-modal-component', [
            "submitFonction" => $submitFonction
        ]);
    }
    public function inviteContact()
    {  //je dois vérifier si le contact exite si oui on va refuser d'envoyer l'invitation
        $this->validate(
            [
                "email" => ["required", "email", Rule::exists("users", "email")->whereNot("email", auth()->user()->email)],
                "invitationMessage" => "required|string|max:255"
            ],
            [
                "email.required" => "Champ obligatoire",
                "email.email" => "Le format de l'email est invalide",
                "email.exists" => "Utilisateur non trouvé",
                "invitationMessage.required"  => "Veuillez ajouter un message d'invitation",
                "invitationMessage.string"  => "Le format du message n'est pas valide",
                "invitationMessage.max" => "Nombre max de caractères autorisé:255"
            ]
        );

        $user_id = auth()->user()->id;

        $recever = User::where('email', '=', $this->email)->first();

        $senderOfInvitationId = $recever->id;

        $contact1 = Contact::where('user1_id', $senderOfInvitationId)->where('user2_id', $user_id)->first();
        $contact2 = Contact::where('user1_id', $user_id)->where('user2_id', $senderOfInvitationId)->first();

        if ($contact1 == null && $contact2 == null) {
            $receverId = $recever->id;
            $senderId = auth()->user()->id;

            $newInvitation = new Invitation;

            $newInvitation->sender_id = $senderId;
            $newInvitation->recever_id = $receverId;
            $newInvitation->invitationMessage = $this->invitationMessage;

            $newInvitation->save();

            session()->flash("newInvitationSentMessage", "Invitation envoyée avec succès🤩");

            // $this->dispatchBrowserEvent('hideContactModal');

            $this->emitTo('invitations-sent-component', 'refresh');

            $this->email = "";
            $this->invitationMessage = "";
        } else {
            session()->flash("newInvitationSentMessage", "Il est déjà dans tes contacts🤩");
        }
    }

    public function updateInvitation($invitation)
    {  //Ceci aussi est à reprendre
        // dd($invitation);
        // $invitation = Invitation::where('id' , '=' , $invitationId);

        $this->email = $invitation['recever']['email'];
        $this->invitationMessage = $invitation['invitationMessage'];
        $this->isEmailFielEditable = false;
        $this->submitButtonName = "Save changes";
        $this->invitationId = $invitation['id'];
    }

    public function updateInvitationSubmit()
    {   //C'est à revoir
        $this->validate(
            [
                "email" => "required|email|exists:users,email",
                "invitationMessage" => "required|string|max:255"
            ],
            [
                "email.required" => "Champ obligatoire",
                "email.email" => "Le format de l'email est invalide",
                "email.exists" => "Utilisateur non trouvé",
                "invitationMessage.required"  => "Veuillez ajouter un message d'invitation",
                "invitationMessage.string"  => "Le format du message n'est pas valide",
                "invitationMessage.max" => "Nombre max de caractères autorisé:255"
            ]
        );

        $invitation = Invitation::where('id', '=', $this->invitationId)->first();

        $invitation->invitationMessage = $this->invitationMessage;


        $invitation->save();

        // $this->emitTo("invitations-sent-component",'refresh');

        session()->flash("newInvitationSentMessage", "Invitation modifiée avec succès🤩");

        // $this->email = "";
        // $this->invitationMessage = "";
    }

    public function seeInvitation(Invitation $invitation)
    {

        $invitation->status = "seen";
        $invitation->save();

        $this->email = $invitation->sender->email;
        $this->invitationMessage = $invitation->invitationMessage;
        $this->isEmailFielEditable = false;
        $this->isMessageFielEditable = false;
        $this->submitButtonName = "Accepter";
        $this->invitationId = $invitation->id;
    }

    // public function accepter(){
    //     $user_id = auth()->user()->id;
    //     $invitation = Invitation::where('id' , '=' , $this->invitationId )->get();

    //     Invitation::where('recever_id' , '=' , $invitation->sender->id)->where('sender_id',$user_id)->delete();

    //     Contact::created([
    //         "user1_id" => $user_id,
    //         "user2_id" => $invitation->sender->id
    //     ]);

    //     $invitation->delete();
    // }

    public function acceptInvitation($invitationId)
    {

        try {
            $invitation = Invitation::where('id', '=', $invitationId)->first();

            // dd($invitation);
            $senderOfInvitation = $invitation->sender;
            // dd($senderOfInvitation);
            //         dump($senderOfInvitation);

            // dd($invitation);

            $invitation->delete();

            $user_id = auth()->user()->id;
            /**
             * @var \Illuminate\Support\Collection
             */
            $otherInvitation = Invitation::where('recever_id', '=', $senderOfInvitation->id)->where('sender_id', $user_id)->get();



            if ($otherInvitation->isNotEmpty()) {
                foreach ($otherInvitation as  $invit) {
                    $invit->delete();
                }
            }

            $otherInvitation = Invitation::where('recever_id', '=', $user_id)->where('sender_id', $senderOfInvitation->id)->get();



            if ($otherInvitation->isNotEmpty()) {
                foreach ($otherInvitation as  $invit) {
                    $invit->delete();
                }
            }

            $contact1 = Contact::where('user1_id', $senderOfInvitation->id)->where('user2_id', $user_id)->first();
            $contact2 = Contact::where('user1_id', $user_id)->where('user2_id', $senderOfInvitation->id)->first();

            // dump($contact1);
            // dd($contact2);
            // die();

            if ($contact1 == null && $contact2 == null) {
                Contact::create([
                    "user1_id" => $user_id,
                    "user2_id" => $senderOfInvitation->id
                ]);
            }
            $this->emitTo("invitations-sent-component", 'refresh');
            $this->emitTo("invitation-received-component", 'refresh');
            $this->emitTo("contact-component", 'refresh');
        } catch (Exception $e) {
        }
    }
}
