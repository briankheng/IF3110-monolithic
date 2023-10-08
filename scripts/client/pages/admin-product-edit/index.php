<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>
<style><?php include '../../public/css/pages/admin-product-edit.css'; ?></style>

<section id="edit-product">
    <div class="edit-product-container">
        <div class="edit-product-header">
            <div class="edit-product-title">Edit Product</div>
            <svg onclick="window.location.href = '/pages/admin-product'" height="25px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="25px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M443.6,387.1L312.4,255.4l131.5-130c5.4-5.4,5.4-14.2,0-19.6l-37.4-37.6c-2.6-2.6-6.1-4-9.8-4c-3.7,0-7.2,1.5-9.8,4  L256,197.8L124.9,68.3c-2.6-2.6-6.1-4-9.8-4c-3.7,0-7.2,1.5-9.8,4L68,105.9c-5.4,5.4-5.4,14.2,0,19.6l131.5,130L68.4,387.1  c-2.6,2.6-4.1,6.1-4.1,9.8c0,3.7,1.4,7.2,4.1,9.8l37.4,37.6c2.7,2.7,6.2,4.1,9.8,4.1c3.5,0,7.1-1.3,9.8-4.1L256,313.1l130.7,131.1  c2.7,2.7,6.2,4.1,9.8,4.1c3.5,0,7.1-1.3,9.8-4.1l37.4-37.6c2.6-2.6,4.1-6.1,4.1-9.8C447.7,393.2,446.2,389.7,443.6,387.1z"/></svg>               
        </div>
        <div class="edit-product-form-container">
            <form id="product-form" enctype="multipart/form-data" onsubmit="editProduct(event)">
                <label for="name">Product Name <span class="required-field">*</span></label>
                <input type="text" name="name" required>

                <label for="description">Description <span class="required-field">*</span></label>
                <textarea name="description" required></textarea>
                
                <label for="price">Price <span class="required-field">*</span></label>
                <input type="number" name="price" required min="0">

                <label for="stock">Stock <span class="required-field">*</span></label>
                <input type="number" name="stock" required min="0">

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

<script type="text/javascript" src="/../../public/js/admin-product-edit.js"></script>