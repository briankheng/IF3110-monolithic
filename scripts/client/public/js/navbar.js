var products;

function initPage() {
    infoNavbarAdded();
}

function infoNavbarAdded() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            uname = document.getElementById("unameuser");
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
        window.location.href = "http://localhost:8000/pages/login";
    } else {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    window.location.href = "http://localhost:8000/pages/home";
                }
            }
        };
        xhttp.open("POST","http://localhost:8000/api/auth/logout",true);
        xhttp.setRequestHeader("Accept", "application/json");
        xhttp.withCredentials = true;
        xhttp.send();
    }
}

function searchProducts() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            products = JSON.parse(this.responseText);
            appendData(products['data']);
        }
    };
    xhttp.open("GET","http://localhost:8000/api/productapi/showAllproducts",true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.withCredentials = true;
    xhttp.send();
}

function searchProducts() {
    query = document.getElementById("queryproduct").value;
    window.location.href = "http://localhost:8000/pages/product?query=" + query;
}

// debounce
function debounce(func, delay) {
    let timeoutId;

    return function() {
        clearTimeout(timeoutId);

        timeoutId = setTimeout(() => {
            func.apply(this, arguments);
        }, delay);
    };
}

// Create a debounced version of searchProducts
const debouncedSearchProducts = debounce(searchProducts, 300);
// Call debouncedSearchProducts when the search icon is clicked
document.getElementById('productqueryimg').addEventListener('click', debouncedSearchProducts);

document.getElementById("queryproduct")
    .addEventListener("keyup", function(event) {
    // console.log("searching");
    event.preventDefault();
    // If the user presses the "Enter" key on the keyboard
    if (event.keyCode == 13) {
        // Trigger the button element with a click
        document.getElementById("productqueryimg").click();
    }
});