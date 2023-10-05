<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<style>
    <?php include '../../public/css/pages/history.css'; ?>
</style>

<section id="history">
    <div class="history-ctn">
        <div class="history-title">History</div>
        <hr class="separator">
        <div class="buy-history">
            <div class="buy-history-title">Buy History</div>
            <div id="buy-history-grid">
                <div class="col-name">Date</div>
                <div class="col-name">Total</div>
            </div>
        </div>
        <hr class="table-separator">
        <div class="topup-history">
            <div class="topup-history-title">Top Up</div>
            <div id="topup-history-grid">
                <div class="col-name">Date</div>
                <div class="col-name">Amount</div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
    <?php include '../../public/js/history.js'; ?>
</script>
