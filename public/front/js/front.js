$(document).ready(function () {
    //------------- Details size ajax ------
    $(".getPrice").change(function () {
        var size = $(this).val();
        var product_id = $(this).attr("product-id");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/get-attribute-price",
            type: "POST",
            data: { size: size, product_id: product_id },
            success: function (data) {
                if(data['discount'] > 0){
                    $(".getAttributePrice").html("<h1 class='mb-0' style='color: orange'>"+ data['final_price'] +"Kr</h1><span class='d-flex align-items-end'>&nbsp;&nbsp;&nbsp;<p class='mb-0 mr-3' style='color: orange'>("+ data['discount'] +"% off)</p></span><span class='d-flex align-items-end'><p class='mb-0 mr-3' style='text-decoration: line-through;'>"+ data['product_price'] +"</p></span>");
                } else {
                    $(".getAttributePrice").html("<h1 class='mb-0' style='color: orange'>"+ data['final_price'] +"Kr</h1>");
                }
            },
            error: function () {
                alert("error");
            },
        });
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
