$(document).ready(function () {
     //------------- Sort ------
     $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#sort").on("change", function() {
        this.form.submit();
    });


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
