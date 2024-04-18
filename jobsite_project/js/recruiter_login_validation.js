document.getElementById('recruit_login').addEventListener('submit', function (event) {
    console.log('Form Submitted');
    event.preventDefault();

    var userName = document.getElementById('userName').value.trim();
    var pass = document.getElementById('pass').value.trim();
    var invalidInputMessage = 'Please fill out all the fields';
    document.getElementById('userName_error').textContent = '';
    document.getElementById('passError').textContent = '';

    if (!isValidInput(userName)) {
        document.getElementById('userName_error').textContent = invalidInputMessage;
        return;
    }

    if (!isValidInput(pass)) {
        document.getElementById('passError').textContent = invalidInputMessage;
        return;
    }

    if (isValidInput(userName) && isValidInput(pass)) {
        document.getElementById('recruit_login').submit();
    }
})

var isValidInput = function (input) {
    return input.trim() !== '';
}