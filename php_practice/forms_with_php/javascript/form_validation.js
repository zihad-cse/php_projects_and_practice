
document.getElementById('signup-form').addEventListener('submit', function(event) {
    event.preventDefault();     // Makes sure it doesn't reload after form submission even if the form is empty.

    var invalidInputMessage = 'Please Fill Out This Field';

    var email = document.getElementById('emailInput').value.trim();
    var password = document.getElementById('password1Input').value.trim();
    var passwordRepeat = document.getElementById('password2Input').value.trim();    // Trims the values inserted into the form
    var tosCheck = document.getElementById('tosCheck').checked;

    document.getElementById('emailError').textContent = '';
    document.getElementById('passWordError').textContent = '';  // Empties the values of the error variables everytime the page is reloaded.
    document.getElementById('tosCheckError').textContent = '';

    if (!isValidInput(email)) {
        document.getElementById('emailError').textContent = invalidInputMessage;    // Displays error message if the input field is empty.
    }

    if (!isValidInput(password) || !isValidInput(passwordRepeat)) {
        document.getElementById('passWordError').textContent = invalidInputMessage;
    } else if (password !== passwordRepeat) {
        document.getElementById('passWordError').textContent = "Passwords do not match";    // Displays error message if the passwords don't match.
    }

    var passwordsMatch = password === passwordRepeat;   // Defines a variable where it compares the two passwords returning either True or False.

    if (!tosCheck) {
        document.getElementById('tosCheckError').textContent = "You must agree to Terms and Conditions";
    }

    if (isValidInput(email) && isValidInput(password) && isValidInput(passwordRepeat) && tosCheck && passwordsMatch) {  // This checks for empty fields. if all the fields are not empty the form gets submitted.
        this.submit();
    }
});

var isValidInput = function(input) {
    return input.trim() !== '';     //This Function makes sure the input fields are not empty.
};