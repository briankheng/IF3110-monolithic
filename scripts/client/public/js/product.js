const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var query = urlParams.get('query');
var order_by_name = urlParams.get('order_by_name');
var order_by_price = urlParams.get('order_by_price');
var filter_category = null;
var filter_price = null;
var totalPageProduct = null;
var currentPageProduct = null;

window.onload = function() {
    // Setup the query
    document.getElementById("queryproduct").value = query;

    // Filter mechanism
    if (urlParams.get('filter_category') == null) {
        setCategory('None');
    } else {
        setCategory(urlParams.get('filter_category'));
        document.querySelector("#catlast").value = urlParams.get('filter_category');
    }

    if (urlParams.get('filter_price') == null) {
        setPrice('None');
    } else {
        setPrice(urlParams.get('filter_price'));
        document.querySelector("#prilast").value = urlParams.get('filter_price');
    }

    // Order mechanism
    if (order_by_name != null) {
        setOrder('nama', order_by_name);
        if (order_by_name == 'ASC') {
            document.querySelector("#sortip").value = 'Name (A to Z)';
        } else {
            document.querySelector("#sortip").value = 'Name (Z to A)';
        }
    } else if (order_by_price != null){
        setOrder('harga', order_by_price);
        if (order_by_price == 'ASC') {
            document.querySelector("#sortip").value = 'Price (Lowest First)';
        } else {
            document.querySelector("#sortip").value = 'Price (Highest First)';
        }
    } else {
        setOrder("nama", "ASC");
    }
    infoNavbarAdded();
    selectProduct(1);
}

function queryProduct() {
    param = '';
    query = document.getElementById("queryproduct").value;
    if (query != null && query != '') {
        param += 'query='+query+'&';
    }
    
    if (order_by_name != null && order_by_name != '' ){
        param += 'order_by_name='+order_by_name+'&';
    }
    if (order_by_price != null && order_by_price != '') {
        param += 'order_by_price='+order_by_price+'&';
    }
    if (filter_category != null && filter_category != 'None') {
        param += 'filter_category='+filter_category+'&';
    }
    if (filter_price != null && filter_price != 'None') {
        param += 'filter_price='+filter_price+'&';
    }
    window.location.href = "http://localhost:8000/pages/home?" + param;
}

const debouncedSearchQuery = debounce(queryProduct, 300);
document.getElementById('startquery').addEventListener('click', debouncedSearchQuery);

function selectProduct(numPage) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            currentPageProduct = numPage;
            if (res['status']) {
                console.log(res['data']['total']);
                products = res['data'];
                document.querySelector("#numsofObj").value = String(res['data']['total']);
                totalPageProduct = res['data']['pages'];
                clearProduct();
                appendData(products['products'], "queryResultProduct");
            } else {
                clearProduct();
            };
        }
    };

    let data = {
        "query" : query,
        "order_by_price": order_by_price,
        "filter_category": filter_category,
        "order_by_name": order_by_name,
        "filter_price": filter_price
    };
    xhttp.open("POST","http://localhost:8000/api/productcontroller/queryproduct/"+numPage+"/8/",true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.withCredentials = true;
    xhttp.send(JSON.stringify(data));
}

function clearProduct() {
    let qAchild = document.getElementById("queryResultProduct");
    while (qAchild.firstChild) {
        qAchild.removeChild(qAchild.firstChild);
    }
    document.getElementById("queryResultProduct").innerHTML = "";
    var pageProductContainer = document.getElementById("pagenumProduct");
    while (pageProductContainer.firstChild) {
        pageProductContainer.removeChild(pageProductContainer.firstChild);
    }
    document.getElementById("pagenumProduct").innerHTML = "";
}

function showFilterCategory(value) {
    document.querySelector(".filter-category").value = value;
    setCategory(value);
}

function showFilterPrice(value) {
    document.querySelector(".filter-price").value = value;
    setPrice(value);
}

function showSort(value) {
    document.querySelector(".sort-type").value = value;
    if (value === 'Name (A to Z)') {
        setOrder('nama', 'ASC');
    } else if (value === 'Name (Z to A)') {
        setOrder('nama', 'DESC');
    } else if (value === 'Price (Lowest First)') {
        setOrder('harga', 'ASC');
    } else {
        setOrder('harga', 'DESC');
    }
}
  
let dropdown1 = document.querySelector(".dropdown1")
dropdown1.onclick = function() {
    dropdown1.classList.toggle("active")
}

let dropdown2 = document.querySelector(".dropdown2")
dropdown2.onclick = function() {
    dropdown2.classList.toggle("active")
}

let dropdown3 = document.querySelector(".dropdown3")
dropdown3.onclick = function() {
    dropdown3.classList.toggle("active")
}

function appendData(data, target) {
    var mainContainer = document.getElementById(target);
    for (var i = 0; i < data.length; i++) {
        if (data[i].product_name == null) {
            data[i].product_name = "-";
        }
        if (data[i].category_name == null) {
            data[i].category_name = "-";
        }
        if (data[i].image == null) {
            data[i].image = "";
        }
        if (target=='queryResultProduct') {
            mainContainer.innerHTML += 
                `<div class="card" onclick="rerouteproduct(${data[i].product_id})"> \
                    <div class="cardImage"> \
                        ${data[i].image.includes('.mp4') ? 
                        `<video src="/public/assets/videos/${data[i].image}" alt="Product Image" autoplay loop muted></video>` :
                        `<img src="/public/assets/images/${data[i].image}" alt="Product Image">`
                        }
                    </div> \
                    <div class="productdesc"> \
                        <div class="stockCategory"> \
                            <div class="category"> \
                                <img src="/public/images/category.png" class="cardIcon">
                                ${data[i].category_name}
                            </div> \
                            <div class="stock"> \
                                <img src="/public/images/quantity.png" class="cardIcon"> 
                                ${data[i].stock} 
                            </div> \
                        </div> \
                        <div class="productTitle"> ${data[i].product_name} </div> \
                        <div class="price"> ${data[i].price.toLocaleString("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        })}</div> \
                    </div> \
                </div>`;
        }
    }
    mainContainer.style.display = "flex";
    mainContainer.style.flexDirection = "row";
    mainContainer.style.flexWrap = "wrap";
    mainContainer.style.justifyContent = "center";
    mainContainer.style.alignItems = "flex-start";
    mainContainer.style.color = "white";

    paginationProduct();
};

function rerouteproduct(id){
    window.location.href = "http://localhost:8000/pages/detailProduct?product_id="+id;
}

function paginationProduct() {
    var pageProductContainer = document.getElementById("pagenumProduct");
    for (i = 0; i < totalPageProduct; i++) {
        if (i == currentPageProduct-1) {
            pageProductContainer.innerHTML += '<div class="pageCurr">' + (i+1) + '</div>';
        }
        else {
            pageProductContainer.innerHTML += '<div class="page" onclick="selectProduct(' + (i+1) + ')">' + (i + 1) + '</div>';
        }
    }
}

function setCategory(inputCategory) {
    if (inputCategory == filter_category) {
        filter_category = null;
    } else {
        filter_category = inputCategory;
    }
}

function setPrice(inputPrice) {
    if (inputPrice == filter_price) {
        filter_price = null;
    } else {
        filter_price = inputPrice;
    }
}

// Add an event listener to the select element
function setOrder(type, order) {
    if (order_by_price != null && order_by_price != '') {
        if (type == "nama") {
            order_by_price = null;
            order_by_name = order;
        } else {
            order_by_price = order;
        }
    } else if (order_by_name != null && order_by_name != '') {
        if (type=="nama") {
            order_by_name = order;
        } else {
            order_by_price = order;
            order_by_name = null;
        }
    } else {
        order_by_name = "ASC";
    }
}

// Enter key
document.getElementById("queryproduct")
    .addEventListener("keyup", function(event) {
    event.preventDefault();
    // Enter
    if (event.keyCode == 13) {
        // Click
        document.getElementById("productqueryimg").click();
    }
});