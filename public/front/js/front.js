$(document).ready(function () {
    //------------- Navbar dropdown menu start ------
    // Handle dropdown toggling
    $(".nav-item.dropdown").on("show.bs.dropdown", function () {
        $(this).find(".dropdown-menu").first().stop(true, true).slideDown(300);
    });

    $(".nav-item.dropdown").on("hide.bs.dropdown", function () {
        $(this).find(".dropdown-menu").first().stop(true, true).slideUp(200);
    });

    // Prevent hiding the dropdown when clicking inside
    $(".nav-item.dropdown .dropdown-menu").on("click", function (e) {
        e.stopPropagation();
    });

    // Show/hide submenus on click
    $(".nav-item.dropdown .dropdown-submenu > .dropdown-toggle").on(
        "click",
        function (e) {
            var $submenu = $(this).next(".dropdown-menu");

            // Close other submenus
            $(this)
                .closest(".dropdown-menu")
                .find(".dropdown-submenu .dropdown-menu")
                .not($submenu)
                .slideUp(200);

            // Toggle the clicked submenu
            $submenu.stop(true, true).slideToggle(200);

            // Prevent parent menu item from closing
            e.stopPropagation();
        }
    );

    // Initialize Popover for subsubmenus
    $(
        ".nav-item.dropdown .dropdown-submenu .dropdown-submenu > .dropdown-toggle"
    )
        .popover({
            // Set the container where the popover will be appended
            container: "body",
            // Define the content of the popover using a function
            content: function () {
                // Return the HTML content of the next dropdown-menu sibling
                return $(this).next(".dropdown-menu").html();
            },
            // Enable HTML content within the popover
            html: true,
            // Automatically determine the placement of the popover
            placement: "auto",
            // Set the trigger to manual, meaning it won't be triggered automatically
            trigger: "manual",
        })
        // Attach event handlers for mouse enter and leave
        .on("mouseenter", function () {
            // When mouse enters, show the popover
            var $popoverToggle = $(this);
            $popoverToggle.popover("show");
        })
        .on("mouseleave", function () {
            // When mouse leaves, hide the popover
            var $popoverToggle = $(this);
            $popoverToggle.popover("hide");
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
