window.onload = function() {
    infoNavbarAdded();
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost:8000/api/auth/getInfo', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(this.responseText);
            var data = JSON.parse(xhr.responseText);
            document.getElementById('username').value = data.username;
            document.getElementById('name').value = data.name;
            document.getElementById('balance').value = data.balance;
        }
    };
    xhr.send();
};

document.getElementById('settings-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var name = document.getElementById('name').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;

    if (name.length === 0) {
        alert('Name cannot be empty.');
        return;
    }

    if (password.length < 6 || !/[A-Za-z]/.test(password) || !/[0-9]/.test(password)) {
        alert('Password must be at least 6 characters long and contain both letters and numbers.');
        return;
    }
    
    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }

    var formData = new FormData(event.target);
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost:8000/api/auth/changeAccSettings', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var responseText = xhr.responseText;
            alert($_SESSION['user_id']);
            if (responseText.trim() === '') {
                window.location.href = 'http://localhost:8000/client/pages/login';
            }
        }
    };
    xhr.send(formData);
});
