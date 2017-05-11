<?php
/**
 * Template Name: Dealer 2-Column Page (Dealer Only)
 * The template used for displaying page content in page.php
 *
 * @author Matthias Thom | http://upplex.de
 * @package upBootWP 0.1
 */
?>
<?php get_header(); ?>
<div id="primary" class="content-area">
    <div id="main" class="site-main">
        <?php if ($GLOBALS['role_flag'] === 1) : ?>
            <?php
            if (have_posts()) {
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="row-container">	
                            <div class="the_content grid_12 page_featured_img">
                                <header class="entry-header">
                                    <h1 class="entry-title"><?php the_title(); ?></h1>
                                </header>
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('large', array('class' => 'img-responsive'));
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row-container">	
                            <div class="the_content grid_6 omega">
                                <?php the_field('left_column'); ?>
                            </div>
                            <div class="the_content grid_6 omega">
                                <?php the_field('right_column'); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php } ?>
        <?php else: ?>
            <h2>Sorry, This page is for our dealers only.</h2>
            <p>Please <a href="/my-account/" title="Account Login">Login Now</a> and then return to this page.
        <?php endif; ?>


    </div>
</div>
<?php get_footer(); ?>