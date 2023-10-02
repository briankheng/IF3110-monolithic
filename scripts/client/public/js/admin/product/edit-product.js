let urlParams = new URLSearchParams(window.location.search);
let id = urlParams.get("id");

window.onload = () => {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);

      if (res["status"]) {
        let product = res["data"];
        let form = document.getElementById("editProductForm");

        form["name"].value = product.name;
        form["price"].value = product.price;
        form["description"].value = product.description;
        form["stock"].value = product.stock;
        form["idCategory"].value = product.idCategory;
        form["image"].value = product.image;
        form["video"].value = product.video;
      } else {
        alert("Failed to get product!");
      }
    }
  };

  xhr.open(
    "GET",
    `http://localhost:8000/api/ProductController/getProductById/${id}`,
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};

let editProduct = async (event) => {
  event.preventDefault();

  let form = document.getElementById("editProductForm");
  let formData = new FormData(form);
  let xhr = new XMLHttpRequest();

  // TODO: sanitize input

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);

      if (res["status"]) {
        alert("Product Edited!");
        window.location.href = "http://localhost:8080/pages/admin/product";
      } else {
        alert("Failed to edit product!");
      }
    }
  };

  xhr.open(
    "POST",
    `http://localhost:8000/api/ProductController/editProduct/${id}`,
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
};
