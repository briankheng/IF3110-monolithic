const ROWS_PER_PAGE = 8;
const INITIAL_PAGE = 1;

window.onload = function() {
    infoNavbarAdded();

    // Check role
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                console.log(this.responseText);
            } else {
                var errorData = JSON.parse(xhttp.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    };

    xhttp.open("GET","http://localhost:8000/api/Auth/isAdmin",true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.withCredentials = true;
    xhttp.send();

    getProductsByPage(INITIAL_PAGE);
    setPagination(INITIAL_PAGE);
}

let getProductsByPage = async (page) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    let products = res['data'];
                    let productContainer = document.getElementById('product-container');
                    productContainer.innerHTML = '';
                    for (let i = 0; i < products.length; i++) {
                        let product = products[i];
                        let productCard = document.createElement('div');
                        productCard.className = 'product-card';
                        productCard.innerHTML = `
                            <div class="product-image">
                                ${product.image.includes('.mp4') ? 
                                `<video src="/public/assets/videos/${product.image}" alt="Product Image" autoplay loop muted></video>` :
                                `<img src="/public/assets/images/${product.image}" alt="Product Image">`
                                }
                            </div>
                            <div class="product-info">
                                <div class="product-category-stock">
                                    <div class="product-category">
                                        <img src="/public/images/category.png" alt="Category Icon" class="category-icon">
                                        <p>${product.category_name}</p>
                                    </div>
                                    <div class="product-stock">
                                        <img src="/public/images/quantity.png" alt="Stock Icon" class="stock-icon">
                                        <p>${product.stock}</p>
                                    </div>
                                </div>
                                <div class="product-name">
                                <h3>${product.product_name}</h3>
                                </div>
                                <div class="product-price">
                                <h3>${product.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</h3>
                                </div>
                                <div class="product-action">
                                <a href="/pages/admin-product-edit?id=${product.product_id}">Edit</a>
                                <a href="#" onclick="deleteProduct(${product.product_id})">Delete</a>
                                </div>
                            </div>
                            `;
                        productContainer.appendChild(productCard);
                    }
                } else {
                    alert('Failed to get products!');
                }
            }
        }
    }
    
    xhr.open('GET', `/api/ProductController/getProductsByPage/${page}`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let setPagination = async (page) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    let paginationContainer = document.getElementById('pagination-container');
                    paginationContainer.innerHTML = '';
                    let totalPage = Math.ceil(res['data'].length / ROWS_PER_PAGE);
                    let paginationList = document.createElement('ul');
                    paginationList.className = 'pagination-list';
                    for (let i = 0; i < totalPage; i++) {
                        let pageItem = document.createElement('li');
                        pageItem.className = 'pagination-item';
                        if (i + 1 == page) {
                            pageItem.className += ' active';
                        }
                        pageItem.innerHTML = `<a href="#" onclick="handlePaginationClick(${i + 1})">${i + 1}</a>`;
                        paginationList.appendChild(pageItem);
                    }
                    paginationContainer.appendChild(paginationList);
                } else {
                    alert('Failed to get pagination!');
                }
            }
        }
    }
    
    xhr.open('GET', `/api/ProductController/getAllProducts`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let handlePaginationClick = async (page) => {
    getProductsByPage(page);
    setPagination(page);
}

let deleteProduct = async (id) => {
  let confirmation = confirm("Are you sure you want to delete this product?");
  if (!confirmation) {
    return;  
  }

  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
        if (this.status == 200) {
            let res = JSON.parse(this.responseText);

            if (res["status"]) {
                window.location.href = "/pages/admin-product";
            } else {
                alert("Failed to delete product!");
            }
        } else {
            var errorData = JSON.parse(xhttp.responseText);
            alert(errorData.message);
            window.location.href = errorData.location;
        }
    }
  };

  xhr.open("DELETE", `/api/ProductController/deleteProduct/${id}`, true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};
