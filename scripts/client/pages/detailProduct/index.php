<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="detailProduct">
    <div class="detailContainer">
        <div class="detailImage">
            <img id="productImage"></img>
        </div>
        <div class="productInfo">
            <div id="productName"></div>
            <div class="productStockCategory">
                <div class="categorySec">
                    <img src="/public/images/category.png" class="detailIcon">
                    <div id="productCategory"></div>
                </div>
                <div class="stockSec">
                    <img src="/public/images/quantity.png" class="detailIcon">
                    <div id="productStock"></div>
                </div>
            </div>
            <div id="productPrice"></div>
            <div id="productDesc"></div>
            <div class="buySection">
                <div class="amountsec">
                    <div type="button" class="buttonOp" onclick="subsAmount()">-</div>
                    <input type="text" id="numberamount" name="Amount" aria-required="true">
                    <div type="button" class="buttonOp" onclick="addAmount()">+</div>
                </div>
                <div type="button" class="buttonSec" onclick="buyProduct()">Buy</div>
            <div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
	/* required scripts */
	<?php include '../../public/js/detailProduct.js'; ?>
</script>