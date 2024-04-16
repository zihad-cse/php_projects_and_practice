document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('registration').addEventListener('submit', function(event){
        console.log('Form submitted');
        event.preventDefault();
    
        var invalidInputMessage = 'Please fill out this field.';
    
        var email = document.getElementById('email').value.trim();
        var fname = document.getElementById('fname').value.trim();
        var pass1 = document.getElementById('pass1').value.trim();
        var pass2 = document.getElementById('pass2').value.trim();
        var phn = document.getElementById('phn').value.trim();
        var gender = document.getElementById('gender').value.trim();
        var dob = document.getElementById('dob').value.trim();
    
        document.getElementById('emailError').textContent = '';
        document.getElementById('fnameError').textContent = '';
        document.getElementById('passError').textContent = '';
        document.getElementById('phnError').textContent = '';
        document.getElementById('genderError').textContent = '';
        document.getElementById('dobError').textContent = '';
        
        if (!isValidInput(email)) {
            document.getElementById('emailError').textContent = invalidInputMessage;
        }
        
        if (!isValidInput(fname)) {
            document.getElementById('fnameError').textContent = invalidInputMessage;
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
    
        if (!isValidGender(gender)) {
            document.getElementById('genderError').textContent = 'Invalid gender selected. Please select a valid gender.';
        }
    
        if (!isValidDateOfBirth(dob)) {
            document.getElementById('dobError').textContent = 'Invalid date of birth. Please enter a valid date in the past.';
        }
    
        if (isValidInput(email) && isValidInput(fname) && isValidInput(pass1) && isValidInput(pass2) && isValidPhoneNumber(phn) && isValidGender(gender) && isValidDateOfBirth(dob) && matchedPass) {
            document.getElementById('registration').submit();
        }
    
    
    });
    
    var isValidInput = function(input){
        return input.trim() !== '';
    }
    
    var isValidPhoneNumber = function(phoneNumber) {
        var phoneNumberPattern = /^\d{10}$/;
        return phoneNumberPattern.test(phoneNumber);
    }
    
    var isValidGender = function(gender) {
        var validGenders = ["Male", "Female", "Other"];
        return validGenders.includes(gender);
    }
    
    var isValidDateOfBirth = function(dob) {
        var currentDate = new Date();
        var selectedDate = new Date(dob);
        return selectedDate < currentDate;
    }
})