jQuery(document).ready(function () {
    
    /* ==============================================
     User Roles disable form fields
     =============================================== */
    jQuery('.disable-form-fields').find('input, textarea, button, select').attr('disabled','disabled');
    jQuery('.disable-check-box').attr('disabled','disabled').attr('checked',true);
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
    


    jQuery('a[name=\'modal\']').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        //Get the A tag
        //jQuery('.modal-popup').fadeIn(300);
        var id = jQuery(this).attr('href');
        
        // Get the window height and width
        var winH = jQuery(window).height();
        var winW = jQuery(window).width();
        console.log(winH);
        console.log(winW);
        console.log(id);
        //Set the popup window to center
        jQuery(id).css('top', winH / 2 - jQuery(id).height() / 2);
        jQuery(id).css('left', winW / 2 - jQuery(id).width() / 2);

        jQuery(id).fadeIn(500);
        jQuery('body').css('overflow-x', 'hidden');
        jQuery('html').css('position', 'fixed');
        jQuery('html').css('height', '100%');
        jQuery('html').css('width', '100%');     
    });
//if close button is clicked
    jQuery('.modal-popup .close_btn').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        jQuery('.modal-popup').fadeOut(300);
        jQuery('body').css('overflow-x', 'scroll');
        jQuery('html').css('position', 'static');
        jQuery('html').css('height', 'auto');
        jQuery('html').css('width', 'auto');
    });


    if (jQuery('.menu-item-has-children')) {
        jQuery('.menu-item-has-children > a').not("ul li ul li a").attr('href', 'javascript:void(0)');
    }

});