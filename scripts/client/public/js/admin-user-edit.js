let urlParams = new URLSearchParams(window.location.search);
let id = urlParams.get("id");

window.onload = function () {
  infoNavbarAdded();
  getUserById(id);
};

let getUserById = async (id) => {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        let res = JSON.parse(this.responseText);

        if (res["status"]) {
          let user = res["data"];
          let form = document.getElementById("user-form");

          form["username"].value = user.username;
          form["name"].value = user.name;
          form["balance"].value = user.balance;
        } else {
          alert("Failed to get user!");
        }
      } else {
          var errorData = JSON.parse(xhr.responseText);
          alert(errorData.message);
          window.location.href = errorData.location;
      }
    }
  };

  xhr.open("GET", `/api/UserController/getUserById/${id}`, true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};

let editUser = async (event) => {
  event.preventDefault();

  let confirmation = confirm("Are you sure you want to edit this user?");
  if (!confirmation) {
    return;
  }

  let form = document.getElementById("user-form");
  let formData = new FormData(form);
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        let res = JSON.parse(this.responseText);

        if (res["status"]) {
          window.location.href = "/pages/admin-user";
        } else {
          let errorMessage = document.getElementById("error-message");
          errorMessage.textContent = res["data"];
        }
      } else {
        var errorData = JSON.parse(xhr.responseText);
        alert(errorData.message);
        window.location.href = errorData.location;
      }
    }
  };

  xhr.open("POST", `/api/UserController/editUser/${id}`, true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
};
