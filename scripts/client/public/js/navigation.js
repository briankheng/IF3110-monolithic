function putNavbar(userRole) {
    // Create an object to store navigation data for different roles
    const navData = {
        user: [
            { text: "History", icon: "history.png", alt: "history", onClick: "http://localhost:8000/pages/history" },
            { text: "Topup", icon: "topup.png", alt: "topup", onClick: "http://localhost:8000/pages/topup" }
        ],
        admin: [
            { text: "Edit Product", icon: "edit-product.png", alt: "editpro", onClick: "http://localhost:8000/pages/admin-product" },
            { text: "Handle Topup", icon: "topup.png", alt: "topup", onClick: "http://localhost:8000/pages/admin-top-up" },
            { text: "Users", icon: "user-manage.png", alt: "user", onClick: "http://localhost:8000/pages/admin-user" }
        ],
        guest : [],
    };

    // Queryselector
    const navRight = document.querySelector('.navRight');

    if (userRole != "guest") {
        const roleNavData = navData[userRole];
        function createNavItem(item) {
            navRight.innerHTML += `
            <div class="navItems" onclick="window.location.href='${item.onClick}'">
                <img class="navIcon" src="../../public/images/${item.icon}" alt="${item.alt}"/>
                <span class="navText">${item.text}</span>
            </div>`;
        }

        roleNavData.forEach(createNavItem);
    }

    navRight.innerHTML += 
        '<div class="navCollapse"> \
            <div class="navItems"> \
                <img class="navIcon" src="../../public/images/user.png" alt="profile"/> \
                <span class="navText" id="unameuser"></span> \
                <i class="fa fa-caret-down"></i> \
            </div> \
            <div class="navDrop"> \
                <div class="navChild" onclick="redirectToSettings()" id="set">Settings</div> \
                <div class="navChild" onclick="logout()" id="logout">Log out</div> \
            </div> \
        </div>';
}

function redirectToHome() {
    window.location.href = "http://localhost:8000/pages/home";
}

function redirectToSettings() {
    window.location.href = "http://localhost:8000/pages/settings";
}

function redirectToCreateProduct() {
    window.location.href = "http://localhost:8000/pages/admin-product-create";
}

function redirectToEditProduct(id) {
    window.location.href = "http://localhost:8000/pages/admin-product-edit?id=" + id;
}

function redirectToCreateTopUp() {
    window.location.href = "http://localhost:8000/pages/admin-top-up-create";
}

function redirectToCreateUser() {
    window.location.href = "http://localhost:8000/pages/admin-user-create";
}

function redirectToEditUser(id) {
    window.location.href = "http://localhost:8000/pages/admin-user-edit?id=" + id;
}