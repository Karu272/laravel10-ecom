$(document).ready(function () {
    //------------- Sort  ------
 // Handle change event on the select element
 $('#sort').on('change', function() {
    // Get the selected sort option
    var selectedSort = $(this).val();

    // Sort the products based on the selected option
    sortProducts(selectedSort);
});

// Function to sort products based on the selected option
function sortProducts(sortOption) {
    var container = $('#products-listing-container');

    // Clone the product cards
    var products = container.find('.category-product').clone();

    // Sort the cloned products based on the selected option
    if (sortOption === 'product_latest') {
        products.sort(function(a, b) {
            return parseInt($(b).data('product-id')) - parseInt($(a).data('product-id'));
        });
    } else if (sortOption === 'lowest_price') {
        products.sort(function(a, b) {
            return parseFloat($(a).data('product-price')) - parseFloat($(b).data('product-price'));
        });
    } else if (sortOption === 'best_selling') {
        // Add your logic for best selling sorting
        // ...
    } else if (sortOption === 'highest_price') {
        // Add your logic for highest price sorting
        // ...
    }

    // Empty the container and append the sorted products
    container.empty().append(products);
}
    // --------------- END --------------

    // ------- product card start -------

    // Function to show products based on the selected category
    function showProducts(category) {
        // Hide all product cards
        $(".category-product").hide();

        // Show product cards based on the selected category
        $(".category-product[data-category='" + category + "']").show();
    }

    // Event listener for category buttons
    $(".category-btn").click(function () {
        var category = $(this).data("category");
        showProducts(category);
    });

    // Load default products when the page loads
    showProducts("all");

    // --------------- END -------------
});
