<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="topup">
    <div class="topupContainer">
        <div class="historyTopupSec">
            <div class="toupUpReq">
                <div class="topuptitle">Pending</div>
                <div class="topupgrid1">
                    <div class="col-name">Date</div>
                    <div class="col-name">Amount</div>
                </div>
            </div>
            <div class="toupUpAcc">
                <div class="topuptitle">History</div>
                <div class="topupgrid2">
                    <div class="col-name">Date</div>
                    <div class="col-name">Status</div>
                    <div class="col-name">Amount</div>
                </div>
            </div>
        </div>
        <div class="mainTopupSec">
            <div class="topuplogo"></div>
            <div class="toupUpSec">
                <div class="topupSectitle">Insert the amount</div>
                <div class="topupinput"></div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
	/* required scripts */
	<?php include '../../public/js/topup.js'; ?>
</script>