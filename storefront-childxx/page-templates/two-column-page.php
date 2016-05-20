<<?php
/**
 * Template Name: Two Column Page
 * The template used for displaying page content in page.php
 *
 * @author Matthias Thom | http://upplex.de
 * @package upBootWP 0.1
 */
?>
<? get_header(); ?>
<div id="main">

<? if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <h1><? the_title(); ?></h1>

  <? if ( has_post_thumbnail() ) {
    the_post_thumbnail();
  } ?>

  <div class="the_content grid_6 alpha">
    <? the_field('left_column'); ?>
  </div>

  <div class="the_content grid_6 omega">
    <? the_field('right_column'); ?>
  </div>
<? endwhile; ?>

</div>

<? get_footer(); ?>
