let createProduct = async (event) => {
  event.preventDefault();

  let form = document.getElementById("createProductForm");
  let formData = new FormData(form);
  let xhr = new XMLHttpRequest();

  // TODO: sanitize input

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);

      if (res["status"]) {
        alert("Product created!");
        window.location.href = "http://localhost:8080/pages/admin/product";
      } else {
        alert("Failed to create product!");
      }
    }
  };

  xhr.open(
    "POST",
    "http://localhost:8000/api/ProductController/createProduct",
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
};
