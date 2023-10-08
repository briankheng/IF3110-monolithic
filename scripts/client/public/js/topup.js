window.onload = function() {
    infoNavbarAdded();
    loadTopupdata();
}

function loadTopupdata() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (xhttp.readyState == 4) {
            if (xhttp.status == 200) {
                let res = JSON.parse(this.responseText);
                data = res['data'];
                var grid = document.getElementById('pending-grid'); 
                data.forEach(topup => {
                    var divDate = document.createElement('div');
                    divDate.textContent = topup.date;
                    divDate.className = 'grid-value';
                    grid.appendChild(divDate);

                    var divTotalPrice = document.createElement('div');
                    divTotalPrice.textContent = topup.amount.toLocaleString("id-ID", {
                        style: "currency",
                        currency: "IDR",
                    });
                    divTotalPrice.className = 'grid-value';
                    grid.appendChild(divTotalPrice);
                });
            } else {
                var errorData = JSON.parse(xhttp.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    };
    xhttp.open("GET", "http://localhost:8000/api/topupcontroller/getTopUpRequested", true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.withCredentials = true;
    xhttp.send();

    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function(){
        if (xhttp1.readyState == 4 && xhttp1.status == 200) {
            let res = JSON.parse(this.responseText);
            if (res['status']) {
                data = res['data'];
                var grid = document.getElementById('historytopup-grid'); 
                data.forEach(topup => {
                    var divDate = document.createElement('div');
                    divDate.textContent = topup.date;
                    divDate.className = 'grid-value';
                    grid.appendChild(divDate);

                    var divStatus = document.createElement('div');
                    if (topup.status == 1) {
                        divStatus.textContent = 'Success';
                    } else {
                        divStatus.textContent = 'Failed';
                    }
                    divStatus.className = 'grid-value';
                    grid.appendChild(divStatus);

                    var divTotalPrice = document.createElement('div');
                    divTotalPrice.textContent = topup.amount.toLocaleString("id-ID", {
                        style: "currency",
                        currency: "IDR",
                    });
                    divTotalPrice.className = 'grid-value';
                    grid.appendChild(divTotalPrice);
                });
            };
        }
    };
    xhttp1.open("GET", "http://localhost:8000/api/topupcontroller/getTopUpHistory", true);
    xhttp1.setRequestHeader("Accept", "application/json");
    xhttp1.withCredentials = true;
    xhttp1.send();
}

function requestTopup() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4) {
            if (this.status == 200) {
                console.log(this.responseText);
                let res = JSON.parse(this.responseText);
                if (res['status']) {
                    alert("Topup successfully requested!");
                    window.location.href = "http://localhost:8000/pages/topup";
                } else {
                    alert(res['data']);
                }
            } else {
                var errorData = JSON.parse(xhttp.responseText);
                alert(errorData.message);
                window.location.href = errorData.location;
            }
        }
    };

    let nums = parseInt(document.getElementById("amount").value);

    let data = {
        "amount": nums
    };
    xhttp.open("POST", "http://localhost:8000/api/topupcontroller/createTopUpRequest",true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.withCredentials = true;
    xhttp.send(JSON.stringify(data));
}