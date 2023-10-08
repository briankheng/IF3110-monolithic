const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var product_id = urlParams.get('product_id');
var product = null;
let stock = 0;
let nums = 1;
let price = 0;

window.onload = function() {
    infoNavbarAdded();
    getProduct();
}

function getProduct() {
    document.getElementById("numberamount").value = 1;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let products = JSON.parse(this.responseText);
            if (products["status"]) {
                product = products["data"];  
                console.log(product);             
                appendData(products["data"]);
                stock = products["data"].stock;
                price = products["data"].price;
            }
        }
    };
    xhttp.open("GET", "http://localhost:8000/api/ProductController/getProduct?product_id="+product_id, true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.withCredentials = true;
    xhttp.send();
}

function appendData(productDetail) {
    var imageTag = document.getElementById("imageTag");
    var videoTag = document.getElementById("videoTag");

    if (productDetail.image.includes('.mp4')) {
        videoTag.src = "/../public/assets/videos/" + productDetail.image;
        videoTag.style.display = "block";
        imageTag.style.display = "none";
    } else {
        imageTag.src = "/../public/assets/images/" + productDetail.image;
        imageTag.style.display = "block";
        videoTag.style.display = "none";
    }

    imageTag.style.objectFit = "cover";
    videoTag.style.objectFit = "cover";

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
    });

    var div7 = document.getElementById("productDesc");
    div7.innerHTML += productDetail.description;
}

function subsAmount() {
    if (parseInt(document.getElementById("numberamount").value) > 1) {
        document.getElementById("numberamount").value = parseInt(document.getElementById("numberamount").value) - 1;
    }
}

function addAmount() {
    if (parseInt(document.getElementById("numberamount").value) < stock) {
        document.getElementById("numberamount").value = parseInt(document.getElementById("numberamount").value) + 1;
    }
}

function buyProduct() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4) {
            if (this.status == 200) {
                console.log(this.responseText);
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    alert("Item successfully purchased!");
                    window.location.href = "http://localhost:8000/pages/home";
                } else {
                    alert(res['data']);
                }
            } else {
                var errorData = JSON.parse(xhttp.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    };

    let nums = parseInt(document.getElementById("numberamount").value);

    let data = {
        "product_id": product_id,
        "amount": nums,
        "total": price
    };
    xhttp.open("POST","http://localhost:8000/api/ProductController/buyProduct",true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.withCredentials = true;
    xhttp.send(JSON.stringify(data));
}