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

    //------------- Details stock update depending on size ------

    // --------------- END --------------

    // ------------- Details plus and minus button
    $(".minusBtn").click(function () {
        // Get the current value
        var currentValue = parseInt($(".quantity").val());

        // Check if the current value is greater than the minimum
        if (currentValue > parseInt($(".quantity").data("min"))) {
            // Decrease the value
            $(".quantity").val(currentValue - 1);
        }
    });

    $(".plusBtn").click(function () {
        // Get the current value
        var currentValue = parseInt($(".quantity").val());

        // Check if the current value is less than the maximum
        if (currentValue < parseInt($(".quantity").data("max"))) {
            // Increase the value
            $(".quantity").val(currentValue + 1);
        }
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

    // ----------- Add to cart -----------
    $("#addToCart").submit(function () {
        var formData = $(this).serialize();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/add-to-cart",
            type: "POST",
            data: formData,
            success: function (data) {
                if(data.status == true){
                    $('.print-success-msg').show();
                    $('.print-success-msg').delay(3000).fadeOut('slow');
                    $('.print-success-msg').html("<div class='alert alert-success' role='alert'><strong>Success!! </strong>"+ data.message +"</div>");
                } else {
                    $('.print-error-msg').show();
                    $('.print-error-msg').delay(3000).fadeOut('slow');
                    $('.print-error-msg').html("<div class='alert alert-danger' role='alert'><strong>Error!! </strong>"+ data.message +"</div>");
                }
            }, error: function () {
                alert("error");
            }
        })
    });
    // -------------- END ----------------

});

