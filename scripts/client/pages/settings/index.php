<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<style>
    <?php include '../../public/css/pages/settings.css'; ?>
</style>

<section id="settings">
    <div class="acct-ctn">
        <div class="acct-title">Account</div>
        <hr class="separator">
        <div class="acct-form-ctn">
            <form id="settings-form" method="post" action="index.php" class="grid-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" readonly disabled>

                <label for="name">Name</label>
                <input type="text" id="name" name="name">

                <label for="password">Password</label>
                <input type="password" id="password" name="password">

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password">

                <label for="balance">Balance</label>
                <input type="text" id="balance" name="balance" readonly disabled>

                <button type="submit">Save</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>
    
<script>
	<?php include '../../public/js/settings.js'; ?>
</script>
