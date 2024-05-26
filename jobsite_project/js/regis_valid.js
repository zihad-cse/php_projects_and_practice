document.addEventListener('DOMContentLoaded', function (){

    document.getElementById('registration').addEventListener('submit', function (event) {
        console.log('Form submitted');
        event.preventDefault();

        var invalidInputMessage = 'Please fill out this field.';

        var email = document.getElementById('email').value.trim();
        var user = document.getElementById('user').value.trim();
        var pass1 = document.getElementById('pass1').value.trim();
        var pass2 = document.getElementById('pass2').value.trim();
        var phn = document.getElementById('phn').value.trim();


        document.getElementById('emailError').textContent = '';
        document.getElementById('userError').textContent = '';
        document.getElementById('passError').textContent = '';
        document.getElementById('phnError').textContent = '';


        if (!isValidInput(email)) {
            document.getElementById('emailError').textContent = invalidInputMessage;
        }
        if (!isValidUsername(user)) {
            document.getElementById('userError').textContent = "Invalid username, Please make sure there aren't any spaces or special characters in the name.";
        }
        else if (!isValidInput(user)) {
            document.getElementById('userError').textContent = invalidInputMessage;
        }

        if (!isValidInput(pass1) || !isValidInput(pass2)) {
            document.getElementById('passError').textContent = 'Please fill out these fields';
        } else if (pass1 !== pass2) {
            document.getElementById('passError').textContent = 'Passwords do not match.'
        }

        var matchedPass = pass1 === pass2;

        if (!isValidPhoneNumber(phn)) {
            document.getElementById('phnError').textContent = 'Invalid phone number. Please enter a 10-digit phone number.';
        }

        if (isValidInput(email) && isValidInput(user) && isValidUsername(user) && isValidInput(pass1) && isValidInput(pass2) && isValidPhoneNumber(phn) && matchedPass) {
            document.getElementById('registration').submit();
        }


    });

    var isValidInput = function (input) {
        return input.trim() !== '';
    }

    var isValidPhoneNumber = function (phoneNumber) {
        var phoneNumberPattern = /^\d{10}$/;
        return phoneNumberPattern.test(phoneNumber);
    }

    function isValidUsername(user) {
        var regex = /^[a-zA-Z0-9]+$/;
        return regex.test(user);
    }
    
})