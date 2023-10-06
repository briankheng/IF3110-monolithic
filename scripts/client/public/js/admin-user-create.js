window.onload = function () {
  infoNavbarAdded();
};

let createUser = async (event) => {
  event.preventDefault();

  let form = document.getElementById("user-form");
  let formData = new FormData(form);
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);

      if (res["status"]) {
        window.location.href = "/pages/admin-user";
      } else {
        let errorMessage = document.getElementById("error-message");
        errorMessage.textContent = res["data"];
      }
    }
  };

  xhr.open("POST", "/api/UserController/createUser", true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
};
