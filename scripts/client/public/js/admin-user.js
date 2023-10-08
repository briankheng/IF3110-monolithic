const ROWS_PER_PAGE = 8;
const INITIAL_PAGE = 1;

window.onload = function() {
    infoNavbarAdded();
    getUsersByPage(INITIAL_PAGE);
    setPagination(INITIAL_PAGE);
}

let getUsersByPage = async (page) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    let users = res['data'];
                    let userContainer = document.getElementById('user-container');
                    userContainer.innerHTML = '';
                    for (let i = 0; i < users.length; i++) {
                        let user = users[i];

                        let userCard = document.createElement('div');
                        userCard.className = 'user-card';
                        userCard.innerHTML = `
                            <div class="user-info">
                                <div class="user-user">
                                    <img src="/public/images/user.png" alt="User Icon" class="user-icon">
                                    <p>${user.username}</p>
                                </div>
                                <div class="user-balance">
                                    <img src="/public/images/amount.png" alt="Balance Icon" class="balance-icon">
                                    <p>${user.balance.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</p>
                                </div>
                            </div>
                            <div class="user-action">
                                <a href="/pages/admin-user-edit?id=${user.id}" class="user-action-item">Edit</a>
                                <a href="#" onclick="deleteUser(${user.id})" class="user-action-item">Delete</a>
                            </div>
                            `;
                        userContainer.appendChild(userCard);
                    }
                } else {
                    alert('Failed to get Users!');
                }
            } else {
                var errorData = JSON.parse(xhr.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    }
    
    xhr.open('GET', `/api/UserController/getUsersByPage/${page}`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let setPagination = async (page) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            if (res['status']) {
                let paginationContainer = document.getElementById('pagination-container');
                paginationContainer.innerHTML = '';
                let totalPage = Math.ceil(res['data'].length / ROWS_PER_PAGE);
                let paginationList = document.createElement('ul');
                paginationList.className = 'pagination-list';
                for (let i = 0; i < totalPage; i++) {
                    let pageItem = document.createElement('li');
                    pageItem.className = 'pagination-item';
                    if (i + 1 == page) {
                        pageItem.className += ' active';
                    }
                    pageItem.innerHTML = `<a href="#" onclick="handlePaginationClick(${i + 1})">${i + 1}</a>`;
                    paginationList.appendChild(pageItem);
                }
                paginationContainer.appendChild(paginationList);
            } else {
                alert('Failed to get pagination!');
            }
        }
    }
    
    xhr.open('GET', `/api/UserController/getAllUsers`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let handlePaginationClick = async (page) => {
    getUsersByPage(page);
    setPagination(page);
}

let deleteUser = async (id) => {
  let confirmation = confirm("Are you sure you want to delete this User?");
  if (!confirmation) {
    return;  
  }

  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
        if (this.status == 200) {
            let res = JSON.parse(this.responseText);

            if (res["status"]) {
                window.location.href = "/pages/admin-user";
            } else {
                alert("Failed to delete user!");
            }
        } else {
            var errorData = JSON.parse(xhr.responseText);
            alert(errorData.message);
            window.location.href = errorData.location;
        }
    }
  };

  xhr.open("DELETE", `/api/UserController/deleteUser/${id}`, true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};
