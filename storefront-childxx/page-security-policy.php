<? // Template Name: Template Two-column Page ?>
<? get_header(); ?>
<div id="primary" class="content-area">
	<div id="main" class="site-main">
		
<? if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="row-container">
			<div class="the_content grid_12 page_featured_img">
	  			<header class="entry-header">
	  				<h1 class="entry-title"><? the_title(); ?></h1>
	  			</header>
	  			<? if ( has_post_thumbnail() ) {
				    the_post_thumbnail('large', array('class' => 'img-responsive'));
				  } ?>
			</div>
		</div>
		<div class="row-container">	
			<div class="the_content grid_6 omega">
			    <? the_field('left_column'); ?>
			</div>
			<div class="the_content grid_6 omega">
	    		<? the_field('right_column'); ?>
			</div>
		</div>
	</article>
<? endwhile; ?>
		</div>
	</div>
</div>

<? get_footer(); ?>
