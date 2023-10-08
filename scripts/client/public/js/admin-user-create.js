window.onload = function () {
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
};

let createUser = async (event) => {
  event.preventDefault();

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
      }
    }
  };

  xhr.open("POST", "/api/UserController/createUser", true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
};
