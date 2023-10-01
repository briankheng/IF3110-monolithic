<?php require_once __DIR__ . "/header.php" ?>
<?php require_once __DIR__ . "/navbar.php" ?>

<div class="layout-container">
    <div class="content-container">
        <div class="content">
            <?= $this->fetch($data) ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/footer.php" ?>