<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>
<style><?php include '../../public/css/pages/admin-product.css'; ?></style>
    
<div id="product-header">
    <h1 id="product-title">Admin's Product</h1>
    <button id="product-create-btn" onclick="redirectToCreateProduct()">Create Product</button>
</div>
<div id="product-container"></div>
<div id="pagination-container"></div>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script type="text/javascript" src="/../../public/js/admin-product.js"></script>
