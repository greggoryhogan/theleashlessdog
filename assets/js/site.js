(function($) {
	$(document).ready(function() {
        $('.nav-toggle').click(function() {
            $(this).toggleClass('is-active');
            $('#site-navigation').toggleClass('is-active');
            
        });
    });
})(jQuery); // Fully reference jQuery after this point.