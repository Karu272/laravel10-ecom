$(document).ready(function () {
    // Handle dropdown toggling
    $('.nav-item.dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
    });

    $('.nav-item.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
    });

    // Prevent hiding the dropdown when clicking inside
    $('.nav-item.dropdown .dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });

    // Show/hide submenus on click
    $('.nav-item.dropdown .dropdown-submenu > .dropdown-toggle').on('click', function (e) {
        var $submenu = $(this).next('.dropdown-menu');

        // Close other submenus
        $(this).closest('.dropdown-menu').find('.dropdown-submenu .dropdown-menu').not($submenu).slideUp(200);

        // Toggle the clicked submenu
        $submenu.stop(true, true).slideToggle(200);

        // Prevent parent menu item from closing
        e.stopPropagation();
    });

    // Initialize Popover for subsubmenus
    $('.nav-item.dropdown .dropdown-submenu .dropdown-submenu > .dropdown-toggle').popover({
        container: 'body',
        content: function () {
            return $(this).next('.dropdown-menu').html();
        },
        html: true,
        placement: 'auto',
        trigger: 'manual'
    }).on('mouseenter', function () {
        var $popoverToggle = $(this);
        $popoverToggle.popover('show');
    }).on('mouseleave', function () {
        var $popoverToggle = $(this);
        $popoverToggle.popover('hide');
    });
});

