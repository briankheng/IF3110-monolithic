<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="product">
    <div class="queryCt">
        <div class="productMenu">
            <div class="pageTitle">Product page</div>
            <div class="queryMenu">
                <div class="filterCollapse">
                    <div class="filterParent">Filter</div>
                    <div class="filterDrop" id="categoryFilter">
                        <!-- List of category -->
                    </div>
                </div>
                <div class="filterCollapse">
                    <div class="filterParent">Sort</div>
                    <div class="filterDrop" id="sortAttribute">
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
        </div>
        <div class="listTitle">Showing 14 items...</div>
        <div id="queryResultProduct" class="queryResultProduct"></div>
        <div class="pagination" id="pagenumProduct"></div>
	</div>
</section>

<?php require_once __DIR__ . "/../template/footer.php" ?>

<script>
	/* required scripts */
	<?php include '../../public/js/product.js'; ?>
</script>

<script>
    // Function to populate the category dropdown
    function populateCategoryDropdown() {
        $.ajax({
            url: 'http://localhost:8000/api/productapi/showAllcategories',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Assuming the response data is an array of category names
                var categoryDropdown = $('#categoryFilter');
                
                // Clear existing divs
                categoryDropdown.empty();

                // Populate the dropdown with category names
                $.each(data.data, function (index, category) {
                    var categoryId = 'filter' + category.name;
                    categoryDropdown.append($('<div>', {
                        class: 'filterChild',
                        id: categoryId,
                        text: category.name
                    }));

                    // Create event listener for filter
                    createFilterEventListener(category.name);
                });
            },
            error: function (error) {
                console.error('Error fetching categories: ' + error.statusText);
            }
        });
    }

    function createFilterEventListener(categoryId) {
    document.getElementById('filter'+categoryId)
        .addEventListener('click', function () {
            setCategory(categoryId);
        });
    }

    // Call the function to populate the category dropdown when the page loads
    $(document).ready(function () {
        populateCategoryDropdown();
    });
</script>