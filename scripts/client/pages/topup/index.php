<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="topup">
    <div class="topupContainer">
        <div class="historyTopupSec">
            <div class="toupUpReq">
                <div class="topuptitle">Pending</div>
                <div class="col-name1">
                    <div>Date</div>
                    <div>Amount</div>
                </div>
                <div class="topupgrid1" id="pending-grid">
                </div>
            </div>
            <div class="toupUpAcc">
                <div class="topuptitle">History</div>
                <div class="col-name2">
                    <div>Date</div>
                    <div>Status</div>
                    <div>Amount</div>
                </div>
                <div class="topupgrid2" id="historytopup-grid">
                </div>
            </div>
        </div>
        <div class="mainTopupSec">
            <div class="topuplogo">
                <img class="mainlogo" src="/../public/images/topup.png" alt="topuplogo"></img>
            </div>
            <div class="topupSec">
                <div class="topupSectitle">Top up Page</div>
                <label for="amount" class="amountlabel">Insert the amount</label>
                <input type="number" id="amount" name="amount" min="1" value="1" oninput="validity.valid||(value='');">
                <div type="button" class="buttonTopup" onclick="requestTopup()">Request Topup</div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
	/* required scripts */
	<?php include '../../public/js/topup.js'; ?>
</script>