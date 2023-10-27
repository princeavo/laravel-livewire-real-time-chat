window.addEventListener('resize', function () {
    console.log(window.innerWidth);
});
const d = document.createElement('div');

const h4 = document.querySelector('#messages #favourites h4');
const div = document.querySelector('#messages .message.active');

h4.insertAdjacentElement('afterend',div);

const searchField = document.querySelector('#searchContainer > input[type=text]');

searchField.addEventListener('keyup',(e)=>{
    document.querySelectorAll('#messages h3.nom').forEach((h3) => {
        if(! h3.innerHTML.toLowerCase().includes(e.target.value.toLowerCase())){
            h3.style.display = "none";
        }
    })
})

const fav = Array.from(document.querySelectorAll('#messages #favourites .message'));
let n = 0;

for(let f of fav){
    if(f.style.display === "none"){
        n++;
    }
}

if(n === fav.length){
    document.querySelector('#messages #favourites').style.display = "none";
}else{
    document.querySelector('#messages #favourites').style.display = "block";
}

// d.innerHTML




/*


<div class="conversationReceived">
    <div class="conversationSend">
        <div class="maxWidth">
            <div class="sendConversation">
                <div class="sendMessage">
                    Assumenda qui cumque mollitia vel illum minus. Quidem ducimus dolorem fugiat. Nisi nobis aperiam id non enim dolore corrupti. Atque sint blanditiis tenetur. Voluptatem quis rerum et occaecati quos ut qui quibusdam. Ut dicta sint commodi molestiae est. Autem vero maxime rerum perspiciatis mollitia unde debitis. Dolores enim eveniet nam et accusamus.
                </div>
                <div class="dropdown options option">
                    <button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
                    <div class="dropdown-menu">
                        <div class="dropdown-item "><i class="fa fa-reply"></i> Reply</div>
                        <div class="dropdown-item"> <i class="fa fa-share"></i> Forward
                        </div>
                        <div class="dropdown-item"><i class="fa fa-copy"></i> Copy</div>


                        <div class="dropdown-item" wire: click="addMessageToDiscussionBookMark(1600)">
                            <i class="fa fa-book-bookmark"></i>
                            Bookmark
                        </div>

                        <div class="dropdown-item" wire: click="deleteMessageToDiscussionBookMark(1600)">
                            <i class="fa fa-book-bookmark"></i>
                            Unsave
                        </div>


                        <div class="dropdown-item text-danger" wire: click="deleteDiscussionMessageForMe(1600)"><i class="fa fa-delete-left"></i> Delete for
                            me4
                        </div>

                        <div class="dropdown-item text-danger" wire: click="deleteDiscussionMessage(1600)"><i class="fa fa-delete-left"></i> Delete
                        </div>


                    </div>
                </div>
                <img src="http://127.0.0.1:8000/images/auth/favicon.png" alt="" class="emoji option">
            </div>
            <div class="heure">
                <time>vendredi à 09h25</time>

            </div>
        </div>
    </div>





</div>

*/
