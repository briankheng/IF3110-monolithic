let urlParams = new URLSearchParams(window.location.search);
let id = urlParams.get("id");

window.onload = async () => {
  infoNavbarAdded();
  getProductById(id);
};

let getProductById = async (id) => {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        let res = JSON.parse(this.responseText);

        if (res["status"]) {
          let product = res["data"];
          let form = document.getElementById("product-form");

          form["name"].value = product.product_name;
          form["description"].value = product.description;
          form["price"].value = product.price;
          form["stock"].value = product.stock;
          
          setDropdownCategory(product.category_id);
        } else {
          alert("Failed to get product!");
        }
      } else {
        var errorData = JSON.parse(xhr.responseText);
        alert(errorData.message);
        window.location.href = errorData.location;
      }
    }

  xhr.open(
    "GET",
    `/api/ProductController/getProductById/${id}`,
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
  }
}

let setDropdownCategory = async (activeCategoryId) => {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        let res = JSON.parse(this.responseText);

        if (res["status"]) {
          let categories = res["data"];
          let categoryDropdown = document.getElementById("category-dropdown");
          let option = document.createElement("option");
          option.value = "";
          option.innerHTML = "--Please select a category--";
          option.className = "category-option";
          categoryDropdown.appendChild(option);

          for (let i = 0; i < categories.length; i++) {
            let category = categories[i];
            let option = document.createElement("option");
            option.value = category.id;
            option.innerHTML = category.name;
            option.className = "category-option";
            if (category.id == activeCategoryId) {
              option.selected = true;
            }
            categoryDropdown.appendChild(option);
          }
        } else {
          alert("Failed to get categories!");
        }
      } else {
        var errorData = JSON.parse(xhr.responseText);
        alert(errorData.message);
        window.location.href = errorData.location;
      }
    }

  xhr.open(
    "GET",
    "/api/CategoryController/getAllCategories",
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
  }
};

let editProduct = async (event) => {
  event.preventDefault();

  let confirmation = confirm("Are you sure you want to edit this product?");
  if (!confirmation) {
    return;  
  }

  let form = document.getElementById("product-form");
  let formData = new FormData(form);
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        let res = JSON.parse(this.responseText);

        if (res["status"]) {
          window.location.href = "/pages/admin-product";
        } else {
          let errorMessage = document.getElementById("error-message");
          errorMessage.textContent = res["data"];
        }
      } else {
        var errorData = JSON.parse(xhttp.responseText);
        alert(errorData.message);
        window.location.href = errorData.location;
      }
    }

  xhr.open(
    "POST",
    `/api/ProductController/editProduct/${id}`,
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
  }
};
