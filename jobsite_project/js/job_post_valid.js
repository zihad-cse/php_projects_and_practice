document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('job-post').addEventListener('submit', function (event) {
        console.log('Posted');
        event.preventDefault();

        var invalidInputMessage = 'Please fill out all fields.';
        var invalidPhoneNumber = 'Please enter a valid phone number';
        var errorMessageBox = document.getElementById('error-message-box');
        var phoneErrorMessageBox = document.getElementById('phone-error-message-box');

        var jobTitle = document.getElementById('jobTitle').value.trim();
        var jobCategory = document.getElementById('jobCategory').value.trim();
        var workArea = document.getElementById('workArea').value.trim();
        var dutySkilledUExp = document.getElementById('dutySkilledUExp').value.trim();
        var salary = document.getElementById('salary').value.trim();
        var endDate = document.getElementById('endDate').value.trim();
        var conEmail = document.getElementById('conEmail').value.trim();
        var conPhone = document.getElementById('conPhone').value.trim();

        document.getElementById('error-message').textContent = '';
        document.getElementById('phone-error-message').textContent = '';


        if (!isValidInput(jobTitle) || !isValidInput(jobCategory) || !isValidInput(workArea) || !isValidInput(dutySkilledUExp) || !isValidInput(salary) || !isValidInput(endDate) || !isValidInput(conEmail) || !isValidInput(conPhone)) {
            document.getElementById('error-message').textContent = invalidInputMessage;
            errorMessageBox.style.display = "block";
            phoneErrorMessageBox.style.display = "none";
        } else if(!isValidPhoneNumber(conPhone)) {
            document.getElementById('phone-error-message').textContent = invalidPhoneNumber;
            phoneErrorMessageBox.style.display = "block";
            errorMessageBox.style.display = "none";
        } else {
            phoneErrorMessageBox.style.display = "none";
            errorMessageBox.style.display = "none";
        }

        if (isValidInput(jobTitle) && isValidInput(jobCategory) && isValidInput(workArea) && isValidInput(dutySkilledUExp) && isValidInput(salary) && isValidInput(endDate) && isValidInput(conEmail) && isValidInput(conPhone) &&isValidPhoneNumber(conPhone)) {
            document.getElementById('job-post').submit();
        }
    });

    var isValidInput = function (input) {
        return input.trim() !== '';
    };

    var isValidPhoneNumber = function (phoneNumber) {
        var phoneNumberPattern = /^\d{11}$/;
        return phoneNumberPattern.test(phoneNumber);
    };
});
