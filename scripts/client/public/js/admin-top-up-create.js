const TOP_UP_STATUS = ["Pending", "Approved", "Rejected"];

window.onload = async function () {
  infoNavbarAdded();
  setDropdownStatus();
};

let setDropdownStatus = async () => {
  let statusDropdown = document.getElementById("status-dropdown");
  let option = document.createElement("option");
  option.value = "";
  option.innerHTML = "--Please select a status--";
  option.className = "status-option";
  statusDropdown.appendChild(option);

  for (let i = 0; i < TOP_UP_STATUS.length; i++) {
    let option = document.createElement("option");
    option.value = i;
    option.innerHTML = TOP_UP_STATUS[i];
    option.className = "status-option";
    statusDropdown.appendChild(option);
  }
};

let createTopUp = async (event) => {
  event.preventDefault();

  let form = document.getElementById("top-up-form");
  let formData = new FormData(form);
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        let res = JSON.parse(this.responseText);

        if (res["status"]) {
          window.location.href = "/pages/admin-top-up";
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

  xhr.open("POST", "/api/TopUpController/createTopUp", true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send(formData);
};
