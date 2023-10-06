<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>
<style><?php include '../../public/css/pages/admin-top-up.css'; ?></style>

<div id="top-up-header">
    <h1 id="top-up-title">Admin's Top Up</h1>
    <button id="top-up-create-btn" onClick="redirectToCreateTopUp()">Create Top Up</button>
</div>
<div id="top-up-container"></div>
<div id="pagination-container"></div>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script type="text/javascript" src="/../../public/js/admin-top-up.js"></script>
