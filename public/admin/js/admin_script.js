$(document).ready(function () {


    // Check Admin Password is correct or not
    $("#current_pwd").keyup(function () {
        var current_pwd = $("#current_pwd").val();
        //alert(current_pwd);
        $.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            type: "post",
            url: "/admin/check-current-password",
            data: { current_password:current_pwd },
            success: function (resp) {
                if (resp === "false") {
                    $("#chkCurrentPwd").html(
                        "<font color='red'>Current Password is incorrect</font>"
                    );
                } else if (resp === "true") {
                    $("#chkCurrentPwd").html(
                        "<font color='green'>Current Password is correct</font>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update Section Status
    $(document).on("click", ".updateSectionStatus", function () {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        $.ajax({
            type: "post",
            url: "/admin/update-section-status",
            data: { status: status, section_id: section_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#section-" + section_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#section-" + section_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update ENG Section Status
    $(document).on("click", ".updateSectionEngStatus", function () {
        var status = $(this).children("i").attr("status");
        var sectionEng_id = $(this).attr("sectionEng_id");
        $.ajax({
            type: "post",
            url: "/admin/update-sectionEng-status",
            data: { status: status, sectionEng_id: sectionEng_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#sectionEng-" + sectionEng_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#sectionEng-" + sectionEng_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update Category Status
    $(document).on("click", ".updateCategoryStatus", function () {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            type: "post",
            url: "/admin/update-category-status",
            data: { status: status, category_id: category_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#category-" + category_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#category-" + category_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update ENG Category Status
    $(document).on("click", ".updateCategoryEngStatus", function () {
        var status = $(this).children("i").attr("status");
        var categoryEng_id = $(this).attr("categoryEng_id");
        $.ajax({
            type: "post",
            url: "/admin/update-categoryEng-status",
            data: { status: status, categoryEng_id: categoryEng_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#categoryEng-" + categoryEng_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#categoryEng-" + categoryEng_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Append Categories Level
    $("#section_id").change(function () {
        var section_id = $(this).val();
        $.ajax({
            type: "post",
            url: "/admin/append-categories-level",
            data: { section_id: section_id },
            success: function (resp) {
                $("#appendCategoriesLevel").html(resp);
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Append ENG Categories Level
    $("#sectionEng_id").change(function () {
        var sectionEng_id = $(this).val();
        $.ajax({
            type: "post",
            url: "/admin/append-categoriesEng-level",
            data: { sectionEng_id: sectionEng_id },
            success: function (resp) {
                $("#appendCategoriesEngLevel").html(resp);
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update Product Status
    $(document).on("click", ".updateProductStatus", function () {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            type: "post",
            url: "/admin/update-product-status",
            data: { status: status, product_id: product_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#product-" + product_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#product-" + product_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update ENG Product Status
    $(document).on("click", ".updateProductStatus", function () {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            type: "post",
            url: "/admin/update-productEng-status",
            data: { status: status, product_id: product_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#product-" + product_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#product-" + product_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update Index page setup Status
    $(document).on("click", ".updateinimgtxtStatus", function () {
        var status = $(this).children("i").attr("status");
        var inimgtxt_id = $(this).attr("inimgtxt_id");
        $.ajax({
            type: "post",
            url: "/admin/update-inimgtxt-status",
            data: { status: status, inimgtxt_id: inimgtxt_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#inimgtxt-" + inimgtxt_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#inimgtxt-" + inimgtxt_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // Update ENGLISH Index page setup Status
    $(document).on("click", ".updateinimgtxtStatus", function () {
        var status = $(this).children("i").attr("status");
        var inimgtxt_id = $(this).attr("inimgtxt_id");
        $.ajax({
            type: "post",
            url: "/admin/update-engIndexPage-status",
            data: { status: status, inimgtxt_id: inimgtxt_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#inimgtxt-" + inimgtxt_id).html(
                        "<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"
                    );
                } else if (resp["status"] == 1) {
                    $("#inimgtxt-" + inimgtxt_id).html(
                        "<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    // confirm delete with sweetalert
    $(document).on("click", ".confirmDelete", function () {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            width: 600,
            padding: "3em",
            backdrop: `rgba(0,0,123,0.4) url("https://sweetalert2.github.io/images/nyan-cat.gif") left top no-repeat`,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    "/admin/delete-" + record + "/" + recordid;
            }
        });
    });

    // Products Attributes Add/Remove Script
    var maxField = 10; //Input fields increment limitation
    var addButton = $(".add_button"); //Add button selector
    var wrapper = $(".field_wrapper"); //Input field wrapper
    var fieldHTML =
        '<div ><div style="height:10px;"></div><input type="text" name="size[]" style="width:120px" placeholder="Size" />&nbsp;<input type="text" name="sku[]" style="width:120px" placeholder="SKU" />&nbsp;<input type="text" name="price[]" style="width:120px" placeholder="Price" />&nbsp;<input type="text" name="stock[]" style="width:120px" placeholder="Stock" />&nbsp;<a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on("click", ".remove_button", function (e) {
        e.preventDefault();
        $(this).parent("div").remove(); //Remove field html
        x--; //Decrement field counter
    });
});
