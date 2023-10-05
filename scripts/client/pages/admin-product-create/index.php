<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
</head>

<body>
    <form id="createProductForm" enctype="multipart/form-data" onsubmit="createProduct(event)">
        <label for="name">Name</label>
        <input type="text" name="name">
        <label for="price">Price</label>
        <input type="text" name="price">
        <label for="description">Description</label>
        <input type="text" name="description">
        <label for="stock">Stock</label>
        <input type="text" name="stock">
        <!-- TODO: dropdown category -->
        <label for="idCategory">Category</label>
        <input type="text" name="idCategory">
        <label for="image">Image/ Video</label>
        <input type="file" name="image">
        <input type="submit">
    </form>
</body>

<script type="text/javascript" src="../../../../public/js/admin/product/create-product.js"></script>

</html>