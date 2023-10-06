<?php require_once __DIR__ . "/../template/header.php" ?>
<?php require_once __DIR__ . "/../template/navbar.php" ?>

<section id="product">
    <div class="queryCt">
        <div class="productMenu">
            <div class="pageTitle">List of Products</div>
            <div class="queryMenu">
                <div class="dropdown1">
                    <input class="filter-category" id="catlast" type="text" placeholder="Select filter category" readonly>
                    <div class="options" id="categoryFilter">
                        <!-- List of category -->
                    </div>
                </div>
                <div class="dropdown2">
                    <input class="filter-price" id="prilast" type="text" placeholder="Select filter price" readonly>
                    <div class="options">
                        <div onclick="showFilterPrice('< 5K')">< 5K</div>
                        <div onclick="showFilterPrice('5K - 30K')">5K - 30K</div>
                        <div onclick="showFilterPrice('30K - 100K')">30K - 100K</div>
                        <div onclick="showFilterPrice('> 100K')">> 100K</div>
                    </div>
                </div>
                <div class="dropdown3">
                    <input class="sort-type" id="sortip" type="text" placeholder="Select sort method" readonly>
                    <div class="options">
                        <div onclick="showSort('Name (A to Z)')">Name (A to Z)</div>
                        <div onclick="showSort('Name (Z to A)')">Name (Z to A)</div>
                        <div onclick="showSort('Price (Lowest First)')">Price (Lowest First)</div>
                        <div onclick="showSort('Price (Highest First)')">Price (Highest First)</div>
                    </div>
                </div>
                <div class="filterCollapse">
                    <div class="filterParent" id="startquery" type="button">Apply Filter</div>
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
            url: 'http://localhost:8000/api/CategoryController/showAllcategories',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Assuming the response data is an array of category names
                var categoryDropdown = $('#categoryFilter');
                
                // Clear existing divs
                categoryDropdown.empty();

                // Populate the dropdown with category names
                $.each(data.data, function (index, category) {
                    categoryDropdown.append($('<div>', {
                        text: category.name,
                        click: function () {
                            showFilterCategory(category.name);
                        }
                    }));
                });
            },
            error: function (error) {
                console.error('Error fetching categories: ' + error.statusText);
            }
        });
    }

    // Call the function to populate the category dropdown when the page loads
    $(document).ready(function () {
        populateCategoryDropdown();
    });
</script>