const ROWS_PER_PAGE = 8;
const INITIAL_PAGE = 1;
const TOP_UP_STATUS = {
    0: 'Pending',
    1: 'Approved',
    2: 'Rejected'
}

window.onload = function() {
    infoNavbarAdded();
    getTopUpsByPage(INITIAL_PAGE);
    setPagination(INITIAL_PAGE);
}

let getTopUpsByPage = async (page) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    let topUps = res['data'];
                    let topUpContainer = document.getElementById('top-up-container');
                    topUpContainer.innerHTML = '';
                    for (let i = 0; i < topUps.length; i++) {
                        let topUp = topUps[i];
                        topUp.status = TOP_UP_STATUS[topUp.status];

                        let topUpCard = document.createElement('div');
                        topUpCard.className = 'top-up-card';
                        topUpCard.innerHTML = `
                            <div class="top-up-info">
                                <div class="top-up-user">
                                    <img src="/public/images/user.png" alt="User Icon" class="user-icon">
                                    <p>${topUp.username}</p>
                                </div>
                                <div class="top-up-date">
                                    <img src="/public/images/date.png" alt="Date Icon" class="date-icon">
                                    <p>${topUp.date}</p>
                                </div>
                                <div class="top-up-amount">
                                    <img src="/public/images/amount.png" alt="Amount Icon" class="amount-icon">
                                    <p>${topUp.amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</p>
                                </div>
                                <div class="top-up-status">
                                    <img src="/public/images/status.png" alt="Status Icon" class="status-icon">
                                    <p>${topUp.status}</p>
                                </div>
                            </div>
                            <div class="top-up-action">
                                ${topUp.status == 'Pending' ?
                                `<a href="#" onclick="handleApproveClick(${topUp.top_up_id})" class="top-up-action-item">Approve</a>
                                <a href="#" onclick="handleRejectClick(${topUp.top_up_id})" class="top-up-action-item">Reject</a>` : ''}
                                <a href="#" onclick="deleteTopUp(${topUp.top_up_id})" class="top-up-action-item">Delete</a>
                            </div>
                            `;
                        topUpContainer.appendChild(topUpCard);
                    }
                } else {
                    alert('Failed to get Top Ups!');
                }
            } else {
                var errorData = JSON.parse(xhr.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    };
    
    xhr.open('GET', `/api/TopUpController/getTopUpsByPage/${page}`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let setPagination = async (page) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
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
    };
    
    xhr.open('GET', `/api/TopUpController/getAllTopUps`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let handlePaginationClick = async (page) => {
    getTopUpsByPage(page);
    setPagination(page);
}

let handleApproveClick = async (id) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                let res = JSON.parse(this.responseText);

                if (res['status']) {
                    window.location.href = '/pages/admin-top-up';
                } else {
                    alert('Failed to approve top up!');
                }
            } else {
                var errorData = JSON.parse(xhr.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    };

    xhr.open('PUT', `/api/TopUpController/approveTopUp/${id}`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let handleRejectClick = async (id) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                let res = JSON.parse(this.responseText);

                if (res['status']) {
                    window.location.href = '/pages/admin-top-up';
                } else {
                    alert('Failed to reject top up!');
                }
            } else {
                var errorData = JSON.parse(xhr.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    };

    xhr.open('PUT', `/api/TopUpController/rejectTopUp/${id}`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.withCredentials = true;
    xhr.send();
}

let deleteTopUp = async (id) => {
  let confirmation = confirm("Are you sure you want to delete this Top Up?");
  if (!confirmation) {
    return;  
  }

  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4) {
        if (this.status == 200) {
            let res = JSON.parse(this.responseText);

            if (res["status"]) {
                window.location.href = "/pages/admin-top-up";
            } else {
                alert("Failed to delete top up!");
            }
        } else {
            var errorData = JSON.parse(xhr.responseText);
            alert(errorData.message);
            window.location.href = errorData.location;
        }
    }
  };

  xhr.open("DELETE", `/api/TopUpController/deleteTopUp/${id}`, true);
  xhr.setRequestHeader("Accept", "application/json");
  xhr.withCredentials = true;
  xhr.send();
};
