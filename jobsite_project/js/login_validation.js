document.getElementById('login').addEventListener('submit', function(event){
    console.log('Form Submitted');
    event.preventDefault();

    var invalidInputMessage = 'Please fill out this field';

    var phn = document.getElementById('phn').value.trim();
    var pass = document.getElementById('pass').value.trim();

    document.getElementById('phnError').textContent='';
    document.getElementById('passError').textContent='';

    if (!isValidPhoneNumber(phn)) {
        document.getElementById('phnError').textContent = 'Invalid Phone number';
    }

    if (!isValidInput(pass)) {
        document.getElementById('passError').textContent = invalidInputMessage;
    }

    if (isValidPhoneNumber(phn) && isValidInput(pass)) {
        document.getElementById('login').submit();
    }

})

var isValidInput = function(input){
    return input.trim() !== '';
}

var isValidPhoneNumber = function(phoneNumber){
    var phoneNumberPattern = /^\d{10}$/;
    return phoneNumberPattern.test(phoneNumber);
}