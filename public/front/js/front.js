$(document).ready(function () {
     //------------- Sort ------
     var baseUrl = "{{ url('/') }}";
     $('#sort').on('change', function () {
        var selectedSort = $(this).val();

        // Make an AJAX request
        $.ajax({
            url: baseUrl + '/ajax-listing', // Use the baseUrl variable to construct the URL
            type: 'GET',
            data: { sort: selectedSort },
            success: function (response) {
                // Check if 'catIDs' key is present in the response
                if ('catIDs' in response) {
                    // Your existing logic here
                } else {
                    // Handle the case where 'catIDs' key is not present
                    console.error('Category not found in the response');
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
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
