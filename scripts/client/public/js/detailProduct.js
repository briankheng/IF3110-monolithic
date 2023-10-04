const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var product_id = urlParams.get('product_id');
var product = null;

window.onload = function() {
    infoNavbarAdded();
    getSong();
}

function getSong(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let products = JSON.parse(this.responseText);
            if (products["status"]) {
                product = products["data"];               
                appendData([products["data"]]);
                playMusic();
            } else {
                console.log("kosonkkkkk");
            }
        }
    };
    xhttp.open("GET", "http://localhost:8000/api/productapi/getproduct?product_id="+product_id, true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.withCredentials = true;
    xhttp.send();
}

function appendData(productDetail) {
    var div1 = document.getElementById("productImage");
    div1.src = productDetail[0].image;
    div1.style.width = "15vw";
    div1.style.height = "15vw";
    div1.style.objectFit = "cover";

    var div2 = document.getElementById("productName");
    div2.innerHTML += productDetail[0].product_name;
    div2.style.width = "50vw";

    var div3 = document.getElementById("productCategory");
    div3.innerHTML += productDetail[0].category_name;
    div3.style.color = "#FFFFFF";
    div3.style.width = "max-content";

    var div4 = document.getElementById("productStock");
    div4.innerHTML += productDetail[0].stock;
    div4.style.color = "#FFFFFF";
    div4.style.width = "max-content";

    var div6 = document.getElementById("productPrice");
    div6.innerHTML += productDetail[0].price;
    div6.style.color = "#6C6C6C";
    div6.style.width = "max-content";

    var div7 = document.getElementById("productDesc");
    div7.innerHTML += productDetail[0].description;
    div7.style.fontSize = "16px";
    div7.style.color = "#B3B3B3";
    div7.style.marginBottom = "0.5vh";
}