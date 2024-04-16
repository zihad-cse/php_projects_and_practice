document.getElementById('recruitRegistration').addEventListener('submit', function (event) {
    console.log('Form Submitted');
    event.preventDefault();

    var userName = document.getElementById('recruitUsername').value.trim();
    var pass = document.getElementById('pass').value.trim();
    var passRepeat = document.getElementById('passRepeat').value.trim();
    var companyName = document.getElementById('companyName').value.trim();
    var companyYear = document.getElementById('companyYear').value.trim();
    var companySize = document.getElementById('companySize').value.trim();
    var companyCategory = document.getElementById('companyCategory').value.trim();
    var companyAddCountry = document.getElementById('companyAddCountry').value.trim();
    var companyAddDistrict = document.getElementById('companyAddDistrict').value.trim();
    var companyAddThana = document.getElementById('companyAddThana').value.trim();
    var companyAddDetails = document.getElementById('companyAddDetails').value.trim();
    var companyAddDetailsBD = document.getElementById('companyAddDetailsBD').value.trim();
    var companyUrl = document.getElementById('companyUrl').value.trim();
    var contactPersonName = document.getElementById('contactPersonName').value.trim();
    var contactPersonNumber = document.getElementById('contactPersonNumber').value.trim();
    var contactPersonEmail = document.getElementById('contactPersonEmail').value.trim();

    var errorMessage = 'Please fill out all of the required fields';

    document.getElementById('errorMessage').textContent = '';
    document.getElementById('passError').textContent = '';
    document.getElementById('phnError').textContent = '';

    if (!isValidInput(userName)) {
        document.getElementById('errorMessage').textContent = errorMessage;
        return;
    }

    if (!isValidPhoneNumber(contactPersonNumber)) {
        document.getElementById('phnError').textContent = 'Invalid Phone Number';
        return;
    }
    if (pass !== passRepeat) {
        document.getElementById('passError').textContent = "Passwords don't match";
        return;
    }

    if (
        isValidInput(userName) && 
        isValidInput(pass) && 
        isValidInput(companyName) && 
        isValidInput(companyYear) && 
        isValidInput(companyAddCountry) && 
        isValidInput(companyAddDistrict) && 
        isValidInput(companyAddThana) && 
        isValidInput(companyCategory) && 
        isValidInput(companyAddDetails) && 
        isValidInput(contactPersonName) && 
        isValidPhoneNumber(contactPersonNumber)
    ) {
        document.getElementById('recruitRegistration').submit();
    } else {
        document.getElementById('errorMessage').textContent = errorMessage;
    }
})

 function isValidInput(input) {
    return input.trim() !== '';
}
 function isValidPhoneNumber(phoneNumber) {
    var phoneNumberPattern = /^\d{10}$/;
    return phoneNumberPattern.test(phoneNumber);
}
