var products;

function initPage() {
    infoNavbarAdded();
}

function infoNavbarAdded() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            uname = document.getElementById("unameadmin");
            if (res['status']) {
                if (res['data'].isAdmin) {
                    document.getElementById("unameadmin").innerHTML = res['data'].username;
                } else {
                    document.getElementById("unameuser").innerHTML = res['data'].username;
                }
                putNavbar(res['data'].isAdmin);
            } else {
                uname.innerHTML = "Guest";
                document.getElementById("logout").innerHTML = "Login";
                putNavbar(false);
            }
        }
    };
    xhttp.open("GET","http://localhost:8000/api/auth/info",true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.withCredentials = true;
    xhttp.send();
}

function logout() {
    if (document.getElementById("logout").innerHTML == "Login") {
        window.location.href = "http://localhost:8080/pages/login/login.html";
    } else {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    window.location.href = "http://localhost:8080/pages/home/home.html";
                }
            }
        };
        xhttp.open("POST","http://localhost:8000/api/auth/logout",true);
        xhttp.setRequestHeader("Accept", "application/json");
        xhttp.withCredentials = true;
        xhttp.send();
    }
}