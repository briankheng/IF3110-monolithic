<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<style>
    <?php include '../../public/css/pages/login.css'; ?>
</style>

<section id="login">
    <div class="lgn-ctn">
        <div class="lgn-title">Welcome Back!</div>
        <div class="lgn-sub-title">We're excited to see you again!</div>
        <div class="lgn-form-ctn">
            <form id="login-form" method="post" action="index.php" role="form">
                <label for="username">USERNAME <span class="required-field">*</span></label>
                <input type="text" id="username" name="username" aria-required="true">

                <label for="password">PASSWORD <span class="required-field">*</span></label>
                <input type="password" id="password" name="password" aria-required="true">
                
                <div class="space"></div>
                
                <button type="submit">Login</button>
            </form>
        </div>

        <div class="reg-link-ctn">
            <p>Need an account? <a href="../signup/index.php" class="reg-link">Signup</a></p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
	<?php include '../../public/js/login.js'; ?>
</script>