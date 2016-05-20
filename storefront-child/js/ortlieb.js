jQuery(document).ready(function () {
    /* ==============================================
     Older browser support - Removes Modernd CSS3 Styling - SVG, CSS Animation, CSS Transform
     =============================================== */

    if (!Modernizr.svg) {
        jQuery(".logo a").find(".svg-logo").remove();
        jQuery(".logo a").html('<img src="http://step7consulting.com.tempwebsite.net/stepcons/wp-content/themes/storefront-child/images/logo-ortlieb.jpg">')
    }


    jQuery('#slides').maximage({
        fillElement: '#wrapper',
        cycleOptions: {
            speed: 2000,
            timeout: 8000
        }
    });


});

