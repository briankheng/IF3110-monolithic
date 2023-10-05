function putNavbar(userRole) {
    // Create an object to store navigation data for different roles
    const navData = {
        user: [
            { text: "History", icon: "history.png", onClick: "http://localhost:8000/pages/history" },
            { text: "Topup", icon: "topup.png", onClick: "http://localhost:8000/pages/topup" }
        ],
        admin: [
            { text: "Edit Product", icon: "edit-product.png", onClick: redirectToEditProduct },
            { text: "Handle Topup", icon: "topup.png", onClick: redirectToHandleTopup },
            { text: "Users", icon: "user-manage.png", onClick: redirectToEditUsers }
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
                <img class="navIcon" src="../../public/images/${item.icon}"/>
                <span class="navText">${item.text}</span>
            </div>`;
        }

        roleNavData.forEach(createNavItem);
    }

    navRight.innerHTML += 
        '<div class="navCollapse"> \
            <div class="navItems"> \
                <img class="navIcon" src="../../public/images/user.png"/> \
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

function redirectToEditUsers() {
    window.location.href = "http://localhost:8000/pages/admin/edit-user";
}