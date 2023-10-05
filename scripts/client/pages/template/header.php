<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/../public/images/logo.png">

    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        /* global css part */
        <?php include '../../public/css/globals.css'; ?>
        <?php include '../../public/css/colors.css'; ?>
        <?php include '../../public/css/typography.css'; ?>
        <?php include '../../public/css/animations.css'; ?>

        /* components css part */
        <?php include '../../public/css/components/navbar.css'; ?>

        /* page css part */
        <?php include '../../public/css/pages/product.css'; ?>
        <?php include '../../public/css/pages/detailProduct.css'; ?>
        <?php include '../../public/css/pages/topup.css'; ?>
    </style>

    <title><?= $data['title'] ?? "KBL" ?></title>
</head>

<body>