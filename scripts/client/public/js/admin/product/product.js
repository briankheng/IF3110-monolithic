window.onload = function () {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);

      if (res["status"]) {
        let products = res["data"];
        let table = document.getElementById("productList");
        let tableContent = "";

        for (let i = 0; i < products.length; i++) {
          tableContent += `<tr>
                                <td>${products[i].id}</td>
                                <td>${products[i].name}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>${products[i].description}</td>
                                <td>${products[i].idCategory}</td>
                                <td>${products[i].price}</td>
                                <td>${products[i].stock}</td>
                                <td>
                                    <button class="btn btn-primary" onclick="redirectToEditProduct(${products[i].id})">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteProduct(${products[i].id})">Delete</button>
                                </td>
                            </tr> <br>`;
        }

        table.innerHTML = tableContent;
      } else {
        alert("Failed to get products!");
      }
    }
  };

  xhr.open(
    "GET",
    "http://localhost:8000/api/ProductController/getAllProducts",
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};

let deleteProduct = async (id) => {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);

      if (res["status"]) {
        alert("Product deleted!");
        window.location.href = "http://localhost:8080/pages/admin/product";
      } else {
        alert("Failed to delete product!");
      }
    }
  };

  xhr.open(
    "DELETE",
    `http://localhost:8000/api/ProductController/deleteProduct/${id}`,
    true
  );
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};
