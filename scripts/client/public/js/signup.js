document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var name = document.getElementById('name').value;

    var errorMessage = document.getElementById('error-message');
    var submitButton = document.querySelector('#register-form button[type=submit]');

    // Clear previous messages
    errorMessage.textContent = '';

    // Check if the username is at least 6 characters long
    if (username.length < 6) {
        errorMessage.textContent = 'Username must be at least 6 characters.';
        event.preventDefault();
        return;
    }

    // Check if the password is at least 6 characters long and contains both letters and numbers
    if (password.length < 6 || !/[A-Za-z]/.test(password) || !/[0-9]/.test(password)) {
        errorMessage.textContent = 'Password must be at least 6 characters long and contain both letters and numbers.';
        event.preventDefault();
        return;
    }

    // Check if the name is empty
    if (name.length === 0) {
        errorMessage.textContent = 'Name cannot be empty.';
        event.preventDefault();
        return;
    }

    // Show loading text
    submitButton.textContent = 'Loading...';


    // Determine role based on username
    var role =  username.startsWith('adm-') ? 'admin' : 'user';

    let form = document.getElementById("register-form");
    let formData = new FormData(form);

    formData.append('role', role);

    var xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            console.log(res);
            if (res["status"]) {
                alert("Account created!");
                window.location.href = "http://localhost:8000/client/pages/login";
            } else {
                alert("Failed to create account!");
            }
        }
    };

    xhr.open(
        "POST",
        "http://localhost:8000/api/auth/signup",
        true
    );
    xhr.setRequestHeader("Accept", "application/json");
    xhr.withCredentials = true;
    xhr.send(formData);

    // Reset the form
    event.target.reset();
});
