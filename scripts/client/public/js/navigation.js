function putNavbar(isAdmin) {
    if (isAdmin == "admin") {
        document.getElementById("navCtAdmin").style.display = "flex";
        document.getElementById("navCt").style.display = "none";
    } else if (isAdmin == "user") {
        document.getElementById("navCtAdmin").style.display = "none";
        document.getElementById("navCt").style.display = "flex";
    } else {
        document.getElementById("navCtAdmin").style.display = "none";
        document.getElementById("navCt").style.display = "flex";
        document.getElementById("set").style.display = "none";
        var elements = document.querySelectorAll(".checkges");
        elements.forEach(function(element) {
            element.style.display = "none";
        });
    }
}

function redirectToHome() {
    window.location.href = "http://localhost:8000/pages/home";
}

function redirectToSettings() {
    window.location.href = "http://localhost:8000/pages/settings";
}

function redirectToHistory() {
    window.location.href = "http://localhost:8000/pages/history";
}

function redirectToTopup() {
    window.location.href = "http://localhost:8000/pages/topup";
}

function redirectToAdminProduct() {
    window.location.href = "http://localhost:8000/pages/admin-product";
}

function redirectToCreateProduct() {
    window.location.href = "http://localhost:8000/pages/admin-product-create";
}

function redirectToEditProduct(id) {
    window.location.href = "http://localhost:8000/pages/admin-product-edit?id=" + id;
}

function redirectToHandleTopup() {
    window.location.href = "http://localhost:8000/pages/admin/handle-top-up";
}

function redirectToEditUser() {
    window.location.href = "http://localhost:8000/pages/admin/edit-user";
}