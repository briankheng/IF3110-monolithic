document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    let form = document.getElementById("login-form");
    let formData = new FormData(form);
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (this.responseText == "Login successful.") {
                alert("Login success!");
                window.location.href = "http://localhost:8000/client/pages/home";
            } else {
                alert("Invalid username or password. Please try again.");
                window.location.href = "http://localhost:8000/client/pages/login";
            }
        }
    };

    xhr.open(
        "POST",
        "http://localhost:8000/api/auth/login",
        true
    );
    xhr.setRequestHeader("Accept", "application/json");
    xhr.withCredentials = true;
    xhr.send(formData);
});