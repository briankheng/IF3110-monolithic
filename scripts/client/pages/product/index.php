<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="product">
    <div class="pageTitle">
        <h1>Product page</h1>
    </div>
    <div class="queryCt">
        <div class="queryMenu">
            <div class="filterCollapse">
                <div class="filterParent">Filter</div>
                <div class="filterDrop">
                    <!-- List of category -->
                </div>
            </div>
            <div class="filterCollapse">
                <div class="filterParent">Sort</div>
                <div class="filterDrop">
                    <div class="filterChild" id="sortnamaASC">Name (A to Z)</div>
                    <div class="filterChild" id="sortnamaDESC">Name (Z to A)</div>
                    <div class="filterChild" id="sorthargaASC">Price (Lowest First)</div>
                    <div class="filterChild" id="sorthargaDESC">Price (Highest First)</div>
                </div>
            </div>
            <div class="filterCollapse">
                <div class="filterParent" type="button" onclick="queryProduct()">Apply Filter</div>
            </div>
        </div>
        <div class="listTitle">List of Products</div>
        <div id="queryResultProduct" class="queryResultProduct"></div>
        <div class="pagination" id="pagenumProduct"></div>
	</div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
	/* required scripts */
	<?php include '../../public/js/product.js'; ?>
</script>