var username = undefined;

function infoNavbar(){
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

function putNavbar(isAdmin) {
    if (isAdmin) {
        document.getElementById("navCtAdmin").style.display = "flex";
        document.getElementById("navCt").style.display = "none";
    } else {
        document.getElementById("navCtAdmin").style.display = "none";
        document.getElementById("navCt").style.display = "flex";
    }
}

function redirectToHome(){
    window.location.href = "http://localhost:8080/pages/home";
}

function redirectToProduct() {
    window.location.href = "http://localhost:8080/pages/product";
}

function redirectToHistory() {
    window.location.href = "http://localhost:8080/pages/history";
}

function redirectToTopup() {
    window.location.href = "http://localhost:8080/pages/topup";
}

function redirectToEditProduct() {
    window.location.href = "http://localhost:8080/pages/admin/edit-product";
}

function redirectToHandleTopup() {
    window.location.href = "http://localhost:8080/pages/admin/handle-top-up";
}

function redirectToEditUser() {
    window.location.href = "http://localhost:8080/pages/admin/edit-user";
}