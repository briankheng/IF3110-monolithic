<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>image</th>
                    <th>description</th>
                    <th>category</th>
                    <th>price</th>
                    <th>stock</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody id="productList"></tbody>
        </table>
    </div>

    <button onclick="redirectToCreateProduct()">Create Product</button>
</body>

<script type="text/javascript" src="../../../public/js/admin/product/product.js"></script>
<script type="text/javascript" src="../../../../public/js/navigation.js"></script>

</html>