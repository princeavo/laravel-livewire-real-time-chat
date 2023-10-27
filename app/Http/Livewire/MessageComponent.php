<?php

namespace App\Http\Livewire;

use App\Models\Discussion;
use App\Models\GroupesMessages;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class MessageComponent extends Component
{
    protected $listeners = ["newMessageSent" => "refresh","refresh"];


    public function render()
    {
        // dd(auth()->user()->discussions()->with(["lastMessage", "user1","user2"])->get()->filter(function($discussion){
        //     return $discussion->isFavorite;
        // }));

        // dd( auth()->user()->discussions()->with(['lastMessage', "user1","user2"])->addSelect([
        //     'message' => Message::whereColumn('id' , '=' , 'discussions.id')->orderBy('created_at','desc')->select('contenu')->limit(1)
        // ])->get());

        // $discussionUser1 = User::whereColumn('id','=','discussions.user1_id');
        // $discussionUser2 = User::whereColumn('id','=','discussions.user2_id');


        return view('livewire.message-component', [
            "groupes" => auth()->user()->groupes()->addSelect([
                "nombreMembres" => DB::table('groupe_user')->whereColumn('groupe_id','=','groupes.id')->select(DB::raw("count(groupe_id)")),
                'favorite' => DB::table('groupes_favorites')->whereColumn('groupe_id' , '=' , 'groupes.id')->where('user_id' , '=' , auth()->user()->id)->select('user_id'),
                'lastMessageDate' => GroupesMessages::whereColumn('groupe_id','=','groupes.id')->orderBy('created_at','desc')->select('created_at')->limit(1)
            ])->get()->sort(function($groupe1,$groupe2){
                return $groupe1->lastMessageDate < $groupe2->lastMessageDate;
            }),
            "discussions" => auth()->user()->discussions()->has('messages')->addSelect([
                'message' => Message::whereColumn('discussion_id' , '=' , 'discussions.id')->orderBy('created_at','desc')->select('contenu')->limit(1),
                'created_at' => Message::whereColumn('discussion_id' , '=' , 'discussions.id')->orderBy('created_at','desc')->select('created_at')->limit(1),
                'utilisateur1Id' => User::whereColumn('id','=','discussions.user1_id')->select('id'),
                'utilisateur1FirstName' => User::whereColumn('id','=','discussions.user1_id')->select('firstname'),
                'utilisateur1LastName' => User::whereColumn('id','=','discussions.user1_id')->select('lastname'),
                'utilisateur1Photo' => User::whereColumn('id','=','discussions.user1_id')->select('profile_photo'),
                'utilisateur2Id' => User::whereColumn('id','=','discussions.user2_id')->select('id'),
                'utilisateur2FirstName' => User::whereColumn('id','=','discussions.user2_id')->select('firstname'),
                'utilisateur2LastName' => User::whereColumn('id','=','discussions.user2_id')->select('lastname'),
                'utilisateur2Photo' => User::whereColumn('id','=','discussions.user2_id')->select('profile_photo'),
                'numberUnreadMessages' => Message::whereColumn('discussion_id' , '=' , 'discussions.id')->where('messages.read','0')->where('messages.receiver_id',auth()->user()->id)->select(DB::raw("count( id)")),
                'favorite' => DB::table('discussions_favorites')->whereColumn('discussion_id' , '=' , 'discussions.id')->where('user_id' , '=' , auth()->user()->id)->select('user_id')
            ])->get()->sort(function($disc1,$disc2){
                return $disc1->created_at < $disc2->created_at;
            })

            // "discussionsFavorites" =>
        ]);

    }
    public function refresh(){
        $this->render();
        // $a = collect();
        // $a->sort(function($disc1,$disc2){
        //     return $disc1->created_at > $disc2->created_at;
        // });
    }
    // now()->longAbsoluteDiffForHumans

}
