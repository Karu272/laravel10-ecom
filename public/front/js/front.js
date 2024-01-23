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
                if (data["discount"] > 0) {
                    $(".getAttributePrice").html(
                        "<h1 class='mb-0' style='color: orange'>" +
                            data["final_price"] +
                            "Kr</h1><span class='d-flex align-items-end'>&nbsp;&nbsp;&nbsp;<p class='mb-0 mr-3' style='color: orange'>(" +
                            data["discount"] +
                            "% off)</p></span><span class='d-flex align-items-end'><p class='mb-0 mr-3' style='text-decoration: line-through;'>" +
                            data["product_price"] +
                            "</p></span>"
                    );
                } else {
                    $(".getAttributePrice").html(
                        "<h1 class='mb-0' style='color: orange'>" +
                            data["final_price"] +
                            "Kr</h1>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });
    // --------------- END --------------

    //------------- Plus minus Btn in cart ------
    $(document).on("click", ".updateCartItem", function () {
        if ($(this).hasClass("qtyPlus")) {
            //Get Qty
            var quantity = $(this).data("qty");
            // Increase by 1
            new_qty = parseInt(quantity) + 1;
        }

        if ($(this).hasClass("qtyMinus")) {
            //Get Qty
            var quantity = $(this).data("qty");
            // Check if it has atleast 1
            if (quantity <= 1) {
                alert("Item Quantaty can not be less than 1");
                return false;
            }
            // Increase by 1
            new_qty = parseInt(quantity) - 1;
        }

        var cartid = $(this).data("cartid");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: { cartid: cartid, qty: new_qty },
            url: "/update-cart-item-qty",
            type: "post",
            success: function (resp) {
                $(".totalCartItems").html(resp.totalCartItems);
                if (resp.status == false) {
                    alert(resp.message);
                }
                $("#appendCartItems").html(resp.view);
            },
            error: function () {
                alert("This is the Error");
            },
        });
    });

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
                if (data.status == true) {
                    $(".totalCartItems").html(data["totalCartItems"]);
                    $(".print-success-msg").show();
                    $(".print-success-msg").delay(3000).fadeOut("slow");
                    $(".print-success-msg").html(
                        "<div class='alert alert-success' role='alert'><strong>Success!! </strong>" +
                            data.message +
                            "</div>"
                    );
                } else {
                    $(".print-error-msg").show();
                    $(".print-error-msg").delay(3000).fadeOut("slow");
                    $(".print-error-msg").html(
                        "<div class='alert alert-danger' role='alert'><strong>Error!! </strong>" +
                            data.message +
                            "</div>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });
    // -------------- END ----------------

    // ----------- Delete cart item -----------
    $(document).on("click", ".deleteCartItem", function () {
        var cartid = $(this).data("cartid");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: { cartid: cartid },
            url: "/delete-cart-item",
            type: "post",
            success: function (resp) {
                $(".totalCartItems").html(resp.totalCartItems);
                $("#appendCartItems").html(resp.view);
            },
            error: function () {
                alert("This is the Error");
            },
        });
    });

    // -------------- END ----------------

    // --------------- Empty cart --------
    $(document).on("click", ".emptyCart", function () {
        var result = confirm("Are you sure want to clear cart?");
        if (result) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "/empty-cart",
                type: "post",
                success: function (resp) {
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                },
                error: function () {
                    alert("This is the Error");
                },
            });
        }
    });
    // -------------- END ----------------

    // ----------- Register user -----------
    // Hide the submit button initially
    $("#submitBtn").hide();

    // Add change event listener to the checkbox
    $("#checkbox").change(function () {
        if ($(this).prop("checked")) {
            // If the checkbox is checked, show the submit button
            $("#submitBtn").show();
        } else {
            // If the checkbox is not checked, hide the submit button
            $("#submitBtn").hide();
        }
    });

    $("#registerForm").submit(function () {
        var formData = $("#registerForm").serialize();
        $.ajax({
            url: "/register",
            type: "POST",
            data: formData,
            success: function (data) {
                if (data.type == "validation") {
                    $.each(data.errors, function (i, error) {
                        $("#register-" + i).attr("style", "color:red");
                        $("#register-" + i).html(error);
                        setTimeout(function () {
                            $("#register-" + i).css({ display: "none" });
                        }, 3000);
                    });
                } else if (data.type == "success") {
                    $("#register-success").attr("style", "color:green");
                    $("#register-success").html(data.message);
                }
            },
            error: function () {
                alert("This is the Error");
            },
        });
    });

    // -------------- END ----------------

    // ----------- Login user -----------

    // -------------- END ----------------
});
