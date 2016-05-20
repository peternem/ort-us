<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */
?><!DOCTYPE html>
<!--[if !IE]>
<html class="no-js non-ie" <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <?php wp_head(); ?>
        <?php if (is_page('dealer-locator')) : ?>
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?&amp;libraries=geometry&amp;key=AIzaSyDbrSoAyjBsYv9NG20HQHumDAk-wR11AUY"></script>
        <?php endif; ?>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body <?php body_class(); ?>>

        <div id="page" class="hfeed site">
            <?php do_action('storefront_before_header'); ?>

            <header id="masthead" class="site-header" <?php if (get_header_image() != '') {
                echo 'style="background-image: url(' . esc_url(get_header_image()) . ');"';
            } ?>>
                <div class="col-outer grey header-a">
                    <div class="col-full">&nbsp;</div>
                </div>
                <div class="col-outer orange header-b">
                    <div class="col-full">
                        <?php do_action('storefront_svg'); ?>
                        <?php do_action('storefront_logo'); ?>
                        <?php do_action('storefront_main_nav'); ?>

                    </div>
                </div>
                <div class="col-outer grey header-c">
                    <div class="col-full">
                        <?php //do_action('storefront_util_nav'); ?>
                        <?php //do_action('storefront_skippy'); ?>
                        <?php do_action('storefront_searchy'); ?>
                        <?php do_action('storefront_ort_cart_do'); ?>   
                    </div>
                </div>
                <!--		<div class="col-full">-->

                <?php
                /**
                 * @hooked storefront_skip_links - 0
                 * @hooked storefront_social_icons - 10
                 * @hooked storefront_site_branding - 20
                 * @hooked storefront_secondary_navigation - 30
                 * @hooked storefront_product_search - 40
                 * @hooked storefront_primary_navigation - 50
                 * @hooked storefront_header_cart - 60
                 */
                //do_action( 'storefront_header' ); 
                ?>

                <!--		</div>-->
            </header><!-- #masthead -->

            <?php
            /**
             * @hooked storefront_header_widget_region - 10
             */
            do_action('storefront_before_content');
            ?>

            <div id="content" class="site-content" tabindex="-1">
                <!-- 		<div class="col-full"> -->

                <?php
                /**
                 * @hooked woocommerce_breadcrumb - 10
                 */
                do_action('storefront_content_top');
                ?>
