<body onload="initPage()">
    <nav class="navbar">
        <div class="navCt" id="navCt">
            <div class="navLeft">
                <div class="navLogoSide">
                    <img class="navLogo" src="../../public/images/logo.png" onclick="redirectToHome()"/>
                    <h1 class="navTitle">&nbsp;KBL</h1>
                </div>
                <div class="navSearch">
                    <img class="navSearchIcon" id="productqueryimg" src="../../public/images/search-black.png"/>
                    <input class="navSearchInput" type="text" id="queryproduct" placeholder="&nbsp;Search for products or categories" >
                </div>
            </div>
            <div class="navRight">
                <div class="navItems" onclick="redirectToProduct()">
                    <img class="navIcon" src="../../public/images/product.png"/>
                    <span class="navText">Product</span>
                </div>
                <div class="navItems" onclick="redirectToHistory()">
                    <img class="navIcon" src="../../public/images/history.png"/>
                    <span class="navText">History</span>
                </div>
                <div class="navItems" onclick="redirectToTopup()">
                    <img class="navIcon" src="../../public/images/topup.png"/>
                    <span class="navText">Topup</span>
                </div>
                <div class="navCollapse">
                    <div class="navItems">
                        <img class="navIcon" src="../../public/images/user.png"/>
                        <span class="navText" id="unameuser"></span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <div class="navDrop">
                        <div class="navChild" onclick="logout()" id="logout">Log out</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navCtAdmin" id="navCtAdmin">
            <div class="navLeft">
                <div class="navLogoSide">
                    <img class="navLogo" src="../../public/images/logo.png" onclick="redirectToHome()"/>
                    <h1>&nbsp;KBL</h1>
                </div>
                <div class="navSearch">
                    <img class="navSearchIcon" id="productqueryimg" src="../../public/images/search-black.png"/>
                    <input class="navSearchInput" type="text" id="queryproduct" placeholder="&nbsp;Search for products or categories" >
                </div>
            </div>
            <div class="navRight">
                <div class="navItems" onclick="redirectToEditProduct()">
                    <img class="navIcon" src="../../public/images/edit-product.png"/>
                    <span class="navText">Edit Product</span>
                </div>
                <div class="navItems" onclick="redirectToHandleTopup()">
                    <img class="navIcon" src="../../public/images/topup.png"/>
                    <span class="navText">Handle Topup</span>
                </div>
                <div class="navItems" onclick="redirectToListUsers()">
                    <img class="navIcon" src="../../public/images/user-manage.png"/>
                    <span class="navText">Users</span>
                </div>
                <div class="navCollapse">
                    <div class="navItems">
                        <img class="navIcon" src="../../public/images/user.png"/>
                        <span class="navText" id="unameadmin"></span>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <div class="navDrop">
                        <div class="navChild" onclick="logout()" id="logout">Log out</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>