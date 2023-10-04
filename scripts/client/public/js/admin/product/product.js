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
                                <td>${products[i].product_id}</td>
                                <td>${products[i].product_name}</td>`;

          if (products[i].image.includes(".mp4")) {
            tableContent += `<td><video width="250px" height="250px" controls><source src="/public/assets/videos/${products[i].image}" type="video/mp4"></video></td>`;
          } else {
            tableContent += `<td><img src="/public/assets/images/${products[i].image}" width="250px" height="250px"></td>`;
          }

          tableContent += `
                           <td>${products[i].description}</td>
                           <td>${products[i].category_name}</td>
                           <td>${products[i].price}</td>
                           <td>${products[i].stock}</td>
                           <td>
                               <button class="btn btn-primary" onclick="redirectToEditProduct(${products[i].product_id})">Edit</button>
                               <button class="btn btn-danger" onclick="deleteProduct(${products[i].product_id})">Delete</button>
                           </td>
                       </tr> <br>`;
        }

        table.innerHTML = tableContent;
      } else {
        alert("Failed to get products!");
      }
    }
  };

  xhr.open("GET", "/api/ProductController/getAllProducts", true);
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
        window.location.href = "/pages/admin/product";
      } else {
        alert("Failed to delete product!");
      }
    }
  };

  xhr.open("DELETE", `/api/ProductController/deleteProduct/${id}`, true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};
