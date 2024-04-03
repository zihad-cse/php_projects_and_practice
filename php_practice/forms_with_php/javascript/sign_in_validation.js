
document.getElementById('signin-form').addEventListener('submit', function(event){
    event.preventDefault();

    var invalidInputMessage = 'Please Fill Out This Field';

    var email = document.getElementById('emailInput').value.trim();
    var password = document.getElementById('signInPass').value.trim();

    document.getElementById('emailError').textContent = '';
    document.getElementById('passError').textContent = '';

    if(!isValidInput(email)){
        document.getElementById('emailError').textContent = invalidInputMessage;
    }
    if(!isValidInput(password)){
        document.getElementById('passError').textContent = invalidInputMessage;
    }

    if(isValidInput(email) && isValidInput(password)){
        this.submit();
    }

});

var isValidInput = function(input){
    return input.trim() !== '';
}