import Echo from 'laravel-echo';
    // window.io = require('socket.io-client');
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001' // this is laravel-echo-server host
    });
    window.Echo.channel('user.2')
        .listen('NewMessageSent',(data)=>{
            alert(data)
        });
    window.Echo.channel(`discussion-message.${userId}`)
                .listen('NewDiscussionMessage',(data)=>{
                    // console.log(data);
                    Livewire.emitTo('test-component',"newMessageSentFromADiscussionJs",data); // après je vais ajouter l'id de la discussion au nom de l'event
                    Livewire.emitTo('received-discussion-broadcoasting',"newMessageSentFromADiscussionJs",data);
                    // dispatchEvent(new CustomEvent('moveActiveDiscussion'));
                })
                .listen('ReadAllDiscussionMessage',(data)=>{
                    Livewire.emitTo('message-sent-component','markRead' + data.message_id);
                })
                .listen('DeleteDiscussionMessageEvent',(data)=>{
                    // alert("ok");
                    Livewire.emitTo('message-receved-component','delete' + data.message_id);
                    Livewire.emitTo('message-sent-component','delete' + data.message_id);
                })
                .listen('MarkAllDiscussionMessageRead',()=>{
                    // alert("MarkAllDiscussionMessageRead");
                    Livewire.emitTo('message-sent-component','markRead');
                });
