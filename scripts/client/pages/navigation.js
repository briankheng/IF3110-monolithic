var username = undefined;

function infoNavbar(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            uname = document.getElementById("uname");
            if(res['status']){
                if(res['data'].isAdmin){
                    document.getElementById("uname").innerHTML = res['data'].username;
                }else{
                    document.getElementById("unameuwu").innerHTML = res['data'].username;
                }
                putNavbar(res['data'].isAdmin);
            }
            else {
                uname.innerHTML = "Guest";
                document.getElementById("loginout").innerHTML = "Login";
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
        document.getElementById("navCtAdmin").style.display = "block";
        document.getElementById("navCt").style.display = "none";
    }
    else {
        document.getElementById("navCtAdmin").style.display = "none";
        document.getElementById("navCt").style.display = "block";
    }
}

function redirectToHome(){
    window.location.href = "http://localhost:8080/pages/home/home.html";
}

function redirectToProduct() {
    window.location.href = "http://localhost:8080/pages/product/product.html";
}

function redirectToHistory() {
    window.location.href = "http://localhost:8080/pages/history/history.html";
}

function redirectToTopup() {
    window.location.href = "http://localhost:8080/pages/topup/topup.html";
}

function redirectToEditProduct() {
    window.location.href = "http://localhost:8080/pages/editproduct/editproduct.html";
}

function redirectToHandleTopup() {
    window.location.href = "http://localhost:8080/pages/handletopup/handletopup.html";
}

function redirectToListUsers() {
    window.location.href = "http://localhost:8080/pages/listusers/listusers.html";
}