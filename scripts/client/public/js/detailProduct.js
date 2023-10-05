const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var product_id = urlParams.get('product_id');
var product = null;

window.onload = function() {
    infoNavbarAdded();
    getProduct();
}

function getProduct(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let products = JSON.parse(this.responseText);
            if (products["status"]) {
                product = products["data"];  
                console.log(product);             
                appendData(products["data"]);
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
    div1.src = "/../public/assets/images/" + productDetail.image;
    div1.style.objectFit = "cover";

    var div2 = document.getElementById("productName");
    div2.innerHTML += productDetail.product_name;

    var div3 = document.getElementById("productCategory");
    div3.innerHTML += productDetail.category_name;

    var div4 = document.getElementById("productStock");
    div4.innerHTML += productDetail.stock;

    var div6 = document.getElementById("productPrice");
    div6.innerHTML += productDetail.price.toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR",
    });;

    var div7 = document.getElementById("productDesc");
    div7.innerHTML += productDetail.description;
}