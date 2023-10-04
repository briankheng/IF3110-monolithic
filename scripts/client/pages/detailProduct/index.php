<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="detailProduct">
    <div class="productImage"></div>
    <div class="productInfo">
        <div class="productName"></div>
        <div class="productStockCategory">
            <div class="productStock"></div>
            <div class="productCategory"></div>
        </div>
        <div class="productPrice"></div>
        <div class="productDesc"></div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
	/* required scripts */
	<?php include '../../public/js/detailProduct.js'; ?>
</script>