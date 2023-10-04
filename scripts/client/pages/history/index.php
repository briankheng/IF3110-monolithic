<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="history">
    <div class="history-ctn">
        <div class="history-title">History</div>
        <hr class="separator">
        <div>
            <div id="history-grid">
                <div class="col-name">Date</div>
                <div class="col-name">Nominal</div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
    <?php include '../../public/js/history.js'; ?>
</script>
