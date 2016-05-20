<?php

register_nav_menus(array(
		'account' => 'Account Menu',
		'search' => 'Search Menu',
		'main' => 'Main Menu',
		'subfooter' => 'Sub-footer Menu'
));

register_sidebar(array(
		'name'          => 'Footer Area',
		'id'            => 'footer',
		'before_widget' => '<div id="%1$s" class="widget %2$s grid_3">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
));
add_action('widgets_init', 'register_widgets');

function register_widgets(){
	register_widget('Ortlieb_LatestPost');
}

require_once('vernacular/bootstrap.php');

class Ortlieb_LatestPost extends VernacularWidget {
	function Ortlieb_LatestPost() {
		$this->title = 'Latest Post';
		$this->id = 'ortlieb-latest';

		$this->setup();
	}

	function widget($args, $instance) {
		$this->render_template($args, $instance, 'latest_post.php');
	}

	function form($instance) {
		$this->setup_form($instance);

		$this->textfield('title', 'Title');
	}
}

$dealers = new VernacularPostType('dealer');
$dealers->labels('Dealer', 'Dealers');
$dealers->register();

define(DEALER_API_ENDPOINT, '/index.php/?json=get_recent_posts&post_type=dealer&count=-1&include=id,title,custom_fields');

add_filter('json_api_encode', 'json_api_encode_acf');
function json_api_encode_acf($response) {
	if (isset($response['posts'])) {
		foreach ($response['posts'] as $post) {
			json_api_add_acf($post); // Add specs to each post
		}
	}
	else if (isset($response['post'])) {
		json_api_add_acf($response['post']); // Add a specs property
	}

	return $response;
}

function json_api_add_acf(&$post){
	$post->custom_fields = get_fields($post->id);
}

register_nav_menus( array(
		'footer_menu' => 'Footer Menu',
) );

add_action( 'wp_enqueue_scripts', 'store_enqueue_styles' );
function store_enqueue_styles() {
	wp_enqueue_style( 'parent_name-odometerstyle', get_template_directory_uri() . '-child/css/font-awesome.min.css', array(), '' );
}

add_action( 'wp_enqueue_scripts', 'store_enqueue_scripts' );
function store_enqueue_scripts() {
	wp_enqueue_script('cycle', get_template_directory_uri().'-child/js/jquery.cycle.all.min.js', array(),'20130905',true);
	
	wp_register_script('dealer-locator-a', get_template_directory_uri() . '-child/js/underscore-min.js',array(), filemtime(get_template_directory().'-child/js/underscore-min.js' ),true);
	wp_enqueue_script('dealer-locator-a');
	
	if (is_page('dealer-locator')) :
	wp_register_script('dealer-locator', get_template_directory_uri() . '-child/js/dealer_locator.js',array(), filemtime(get_template_directory().'-child/js/dealer_locator.js' ),true);
	wp_enqueue_script('dealer-locator');
	endif;
	
	wp_register_script('maximage', get_template_directory_uri() . '-child/js/jquery.maximage.min.js',array(), filemtime(get_template_directory().'-child/js/jquery.maximage.min.js' ));
	wp_enqueue_script('maximage');
	
	wp_register_script('main-js', get_template_directory_uri() . '-child/js/ortlieb.js',array(), filemtime(get_template_directory().'-child/js/ortlieb.js' ));
	wp_enqueue_script('main-js');
}

/*********************************************************
 * 
 * Overriding storefront_primary_navigation()
 * 
 ********************************************************/

if ( ! function_exists( 'storefront_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false">
			<span class="sr-only"><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'primary',
					'container_class'	=> 'primary-navigation',
					)
			);

			wp_nav_menu(
				array(
					'theme_location'	=> 'handheld',
					'container_class'	=> 'handheld-navigation',
					)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

/*********************************************************
 *
 * New function - storefront_site_svg()
 *
 ********************************************************/

if ( ! function_exists( 'storefront_site_svg' ) ) {
	/**
	 * Display Site SVG Logo
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_site_svg() {
		if ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
			jetpack_the_site_logo();
		} else { ?>
			<div class="site-branding">
				<div class="logo">
					<?php get_template_part('inc/logo-svg') ?>
				</div>
				<div class="company-name">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php if ( '' != get_bloginfo( 'description' ) ) { ?>
						<p class="site-description"><?php echo bloginfo( 'description' ); ?></p>
					<?php } ?>
				</div>
			</div>
	<?php }
	}
}

/*********************************************************
 *
 * New function - store credit alt()
 *
 ********************************************************/

if ( ! function_exists( 'storefront_credit_alt' ) ) {
	function storefront_credit_alt() {
		?>
		<div class="site-info">
		<?php 
			wp_nav_menu(
				array(
						'theme_location'	=> 'footer_menu',
						'container_class'	=> 'col-full',
						'menu_class' => 'footer-aux-navigation',
					)
				);
			?>
			<p><?php echo esc_html( apply_filters( 'storefront_copyright_text<', $content = ' &copy;' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) ); ?></p>
		</div><!-- .site-info -->
		<?php
	}
}

add_action( 'init', 'custom_remove_footer_credit', 10 );

function custom_remove_footer_credit () {
	remove_action( 'storefront_footer', 'storefront_credit', 20 );
	add_action( 'storefront_footer_alt', 'storefront_credit_alt', 20 );
}

add_action( 'init' , 'myyy_remove' , 15 );
function myyy_remove() {
	remove_action( 'storefront_header', 'storefront_skip_links', 				0 );
	remove_action( 'storefront_header', 'storefront_site_branding',			20 );
	remove_action( 'storefront_header', 'storefront_secondary_navigation',		30 );
	remove_action( 'storefront_header', 'storefront_primary_navigation',		50 );
	remove_action( 'storefront_header', 'storefront_product_search',			40 );
	remove_action( 'storefront_header', 'storefront_header_cart',			60 );
}

add_action( 'init' , 'myyy_add');
function myyy_add() {

	add_action( 'storefront_svg', 'storefront_site_svg', 				0 );
	add_action( 'storefront_logo', 'storefront_site_branding', 				0 );
	add_action( 'storefront_main_nav', 'storefront_primary_navigation',		5 );
	add_action( 'storefront_skippy', 'storefront_skip_links', 				0 );
	add_action( 'storefront_searchy', 'storefront_product_search',			0 );
	
	add_action( 'storefront_util_nav', 'storefront_secondary_navigation',	0 );
	add_action( 'storefront_kart', 'storefront_header_cart',				0 );
}

?>
<?php
/*--------------------------------------*/
/* Add SVG Support to media library
 /*--------------------------------------*/

function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );
// Add SVG Thumbnails to media library grid

function custom_admin_head() {
	$css = '';
	$css = 'td.media-icon img[src$=".svg"] { width: 100% !important; height: auto !important; }';
	echo '<style type="text/css">'.$css.'</style>';
}
?>
