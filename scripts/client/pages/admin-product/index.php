<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>
<style><?php include '../../public/css/pages/admin-product.css'; ?></style>
    
<button class="btn" onclick="redirectToCreateProduct()"><img src="/public/images/edit-product.png" alt="create-product" class="create-product-icon">Create Product</button>
<div id="product-container"></div>
<div id="pagination-container"></div>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script type="text/javascript" src="/../../public/js/admin-product.js"></script>
