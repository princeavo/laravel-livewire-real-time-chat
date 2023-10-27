document.querySelector('#logoutLink').addEventListener('click',function(event){
    event.preventDefault();
    if(confirm('Etes vous sûr de vous déconnecter?'))
        document.querySelector('#logoutForm').submit();
});
