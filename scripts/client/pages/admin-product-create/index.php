<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>
<style><?php include '../../public/css/pages/admin-product-create.css'; ?></style>

<section id="create-product">
    <div class="create-product-container">
        <div class="create-product-title">Create New Product!</div>
        <div class="create-product-form-container">
            <form id="product-form" enctype="multipart/form-data" onsubmit="createProduct(event)">
                <label for="name">Product Name <span class="required-field">*</span></label>
                <input type="text" name="name" required>

                <label for="description">Description <span class="required-field">*</span></label>
                <textarea name="description" required></textarea>
                
                <label for="price">Price <span class="required-field">*</span></label>
                <input type="number" name="price" required>

                <label for="stock">Stock <span class="required-field">*</span></label>
                <input type="number" name="stock" required>

                <!-- Dropdown Category -->
                <label for="idCategory">Category <span class="required-field">*</span></label>
                <select name="idCategory" id="category-dropdown" required></select>

                <!-- Image/ Video -->
                <label for="image">Image/ Video</label>
                <input type="file" name="image" accept="image/*, video/mp4">

                <!-- Error Message -->
                <div id="error-message"></div>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script type="text/javascript" src="/../../public/js/admin-product-create.js"></script>