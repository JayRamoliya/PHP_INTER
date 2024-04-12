
function validateEmail() {
    const email = document.getElementById('email').value.trim();
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        emailError.textContent = 'Field cannot be empty';
    }
    else if (!emailRegex.test(email)) {
        emailError.textContent = 'Please enter a valid email address';
    } else {
        emailError.textContent = '';
    }
}

function validatePassword() {
    const password = document.getElementById('password').value.trim();
    const passwordError = document.getElementById('passwordError');
    if (password === '') {
        passwordError.textContent = 'Field cannot be empty';
    }
    else if (password.length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters long';
    } else {
        passwordError.textContent = '';
    }
}

function validateForm() {
    let isValid = true;

    // Validate Email
    const email = document.getElementById('email').value.trim();

    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        emailError.textContent = 'email cannot be blank.';
    }
    else if (!emailRegex.test(email)) {
        emailError.textContent = 'Please enter a valid email address.';
        isValid = false;
    } else {
        emailError.textContent = '';
    }

    // Validate Password
    const password = document.getElementById('password').value.trim();
    const passwordError = document.getElementById('passwordError');
    if (password === '') {
        passwordError.textContent = 'password cannot be blank.';
    }
    else if (password.length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters long.';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }

    return isValid;
}



