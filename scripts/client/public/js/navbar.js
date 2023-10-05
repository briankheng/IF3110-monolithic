function initPage() {
    infoNavbarAdded();
}

function infoNavbarAdded() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            if (res['status']) {
                // Role-based navbar
                if (res['data'].role == 'admin') {
                    putNavbar("admin");
                } else {
                    putNavbar("user");
                }
                document.getElementById("unameuser").innerHTML = res['data'].name;
            } else {
                putNavbar("guest");
                document.getElementById("unameuser").innerHTML = "Guest";
                document.getElementById("logout").innerHTML = "Login";
                document.getElementById("set").style.display = "none";
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