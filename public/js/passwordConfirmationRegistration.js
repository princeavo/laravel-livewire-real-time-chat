const passwordField = document.querySelector("input[name='password']");

const passwordErrorDiv = document.createElement('div');
passwordErrorDiv.innerText = "The password field must be at least 8 characters.";





passwordErrorDiv.className = "invalid-feedback";



passwordField.addEventListener('keyup',function(){
    if(this.value.length < 8){
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');

        this.parentElement.appendChild(passwordErrorDiv);
    }else{
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');

        this.parentElement.removeChild(passwordErrorDiv);
    }
});

const password_confirmationField = document.querySelector("input[name='password_confirmation']");


const passwordErrorDivConfirmation = document.createElement('div');
passwordErrorDivConfirmation.className = "invalid-feedback";

const p1 = document.createElement('p');
p1.innerText = "The password confirmation field must be at least 8 characters.";

const p2 = document.createElement('p');
p2.innerText = "The password field confirmation does not match.";

// passwordErrorDivConfirmation.appendChild(p1);



password_confirmationField.addEventListener('keyup',function(){
    if(this.value !== passwordField.value){
        passwordErrorDivConfirmation.appendChild(p2);
    }else{
        passwordErrorDivConfirmation.removeChild(p2);
    }
    if(this.value.length < 8){
        passwordErrorDivConfirmation.appendChild(p1);



    }else{
        passwordErrorDivConfirmation.removeChild(p1);



    }
    if(passwordErrorDivConfirmation.children.length != 0){
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');

        this.parentElement.appendChild(passwordErrorDivConfirmation);
    }else{
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');

        this.parentElement.removeChild(passwordErrorDivConfirmation);
    }
});
