window.onload = function () {
  infoNavbarAdded();
  setDropdownCategory();
  validateAdmin();
}

function validateAdmin() {
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
  xhttp.send();
}

let setDropdownCategory = async () => {
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
            categoryDropdown.appendChild(option);
          }
        } else {
          alert("Failed to get categories!");
        }
      }
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

let createProduct = async (event) => {
  event.preventDefault();

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
      }
    } else {
      var errorData = JSON.parse(xhr.responseText);
      alert(errorData.message);
      window.location.href = errorData.location;
    }
  };

  xhr.open(
    "POST",
    "/api/ProductController/createProduct",
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
};
