const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var query = urlParams.get('query');
var order_by_name = urlParams.get('order_by_name');
var order_by_price = urlParams.get('order_by_price');
var order_by = null;
var order_type = null;
var filter_category = null;
var product = null;
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
    }

    // Order mechanism
    if (order_by_name != null) {
        setOrder('nama', order_by_name);
    } else if (order_by_price != null){
        setOrder('harga', order_by_price);
    } else {
        setOrder("nama", "ASC");
    }
    infoNavbar();
    selectProduct(1);
}

function queryProduct() {
    param = '';
    query = document.getElementById("queryproduct").value;
    if (query != "" && query != null) {
        param += 'query='+query+'&';
    } else {
        query = document.getElementById("queryproduct2").value;
        if (query != null && query != '') {
            param += 'query='+query+'&';
        }
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
    window.location.href = "http://localhost:8080/pages/product?" + param;
}

function selectProduct(numPage) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            currentPageAlbum = numPage;
            if (res['status']) {
                products = res['data'];
                totalPageProduct = res['data']['pages'];
                clearProduct();
                appendData(products['product'], "queryResultProduct");
            } else {
                clearProduct();
                appendData(productNotFound, "queryResultProduct");
            };
        }
    };

    let data = {
        "query" : query,
        "order_by_price": order_by_price,
        "filter_category": filter_category,
        "order_by_name": order_by_name,
    };
    xhttp.open("POST","http://localhost:8000/api/productapi/queryproduct/"+numPage+"/8/",true);
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

function appendData(data, target) {
    var mainContainer = document.getElementById(target);
    for (var i = 0; i < data.length; i++) {
        if (data[i].name == null) {
            data[i].name = "-";
        }
        if (data[i].category == null) {
            data[i].category = "-";
        }
        if (data[i].image == null) {
            data[i].image = "";
        }
        if (target=='queryResultProduct') {
            mainContainer.innerHTML += 
                '<div class="card" id='+ data[i].id+' onclick="rerouteproduct(this.id)"> \
                    <img src="' + data[i].image + '" class="cardImage"> \
                    <div class="productTitle">' + data[i].name + '</div> \
                    <div class="price">' + data[i].price + '</div> \
                    <div class="stockCategory"> \
                        <div class="stock">' + data[i].stock + '</div> \
                        <div class="category">' + data[i].category + '</div> \
                    </div> \
                </div>';
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
    window.location.href = "http://localhost:8080/pages/detailProduct?product_id="+id;
}

function paginationProduct() {
    var pageProductContainer = document.getElementById("pagenumProduct");
    for (i = 0; i < totalPageProduct; i++) {
        if (i == currentPageAlbum-1) {
            pageProductContainer.innerHTML += '<div class="pageCurr" style="background-color: #282828; color: white;">' + (i+1) + '</div>';
        }
        else {
            pageProductContainer.innerHTML += '<div class="page" onclick="selectProduct(' + (i+1) + ')">' + (i + 1) + '</div>';
        }
    }
}

function setCategory(inputCategory) {
    if (inputCategory == filter_category) {
        filter_category = null;
        document.getElementById("filter"+inputCategory).style.backgroundColor = "#282828";
        document.getElementById("filterNone").style.backgroundColor = "green";
    } else {
        if (filter_category != null) {
            document.getElementById("filter"+filter_category).style.backgroundColor = "#282828";
        }
        // document.getElementById("filterNone").style.backgroundColor = "#282828";
        // document.getElementById("filter"+inputCategory).style.backgroundColor = "green";
        filter_category = inputCategory;
    }
}

function setOrder(type, order) {
    if (order_by_price != null && order_by_price != '') {
        if (type == "nama") {
            document.getElementById("sortharga"+order_by_price).style.backgroundColor = "#282828";
            document.getElementById("sortnama"+order).style.backgroundColor = "green";
            order_by_price = null;
            order_by_name = order;
        } else {
            document.getElementById("sortharga"+order_by_price).style.backgroundColor = "#282828";
            document.getElementById("sortharga"+order).style.backgroundColor = "green";
            order_by_price = order;
        }
    } else if (order_by_name!=null && order_by_name != '') {
        if (type=="nama") {
            document.getElementById("sortnama"+order_by_name).style.backgroundColor = "#282828";
            document.getElementById("sortnama"+order).style.backgroundColor = "green";
            order_by_name = order;
        } else {
            document.getElementById("sortnama"+order_by_name).style.backgroundColor = "#282828";
            document.getElementById("sortharga"+order).style.backgroundColor = "green";
            order_by_price = order;
            order_by_name = null;
        }
    } else {
        order_by_name = "ASC";
        document.getElementById("sortnamaASC").style.backgroundColor = "green";
    }
}

// Filter event handler


// Sorting event handler
document.getElementById("sortnamaASC")
    .addEventListener("click", function () {
    setOrder("nama","ASC");
});
document.getElementById("sortnamaDESC")
    .addEventListener("click", function () {
    setOrder("nama","DESC");
});
document.getElementById("sorthargaASC")
    .addEventListener("click", function () {
    setOrder("harga","ASC");
});
document.getElementById("sorthargaDESC")
    .addEventListener("click", function () {
    setOrder("harga","DESC");
});

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