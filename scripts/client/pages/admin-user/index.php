<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>
<style><?php include '../../public/css/pages/admin-user.css'; ?></style>

<div id="user-header">
    <h1 id="user-title">Admin's User</h1>
    <button id="user-create-btn" onClick="redirectToCreateUser()">Create User</button>
</div>
<div id="user-container"></div>
<div id="pagination-container"></div>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script type="text/javascript" src="/../../public/js/admin-user.js"></script>
