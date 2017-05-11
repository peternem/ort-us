<?php get_header(); ?>
<div id="teaser_wrapper">
	<div id="teaser_wrapper_inner" class="container">
		<div id="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php if( have_rows('background_images') ): ?>
		 <section id="slides">
		<?php while( have_rows('background_images') ): the_row(); 
			$image = get_sub_field('image');
		?>
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" class="img-responsive" />
		<?php endwhile; ?>
		</section>
	<?php endif; ?>
	<?php if( have_rows('teaser_boxes') ): ?>
		 <section id="teaser_boxes" class="boxes">
		 	<div class="boxes-inner">
		<?php while( have_rows('teaser_boxes') ): the_row(); ?>
			<div class="grid_4 box">
		        <div class="inner">
		          <h3><a href="<? the_sub_field('link'); ?>"><?php the_sub_field('headline'); ?> <i class="fa fa-angle-double-right"></i></a></h3>
		          <div class="teaser_copy">
		            <?php the_sub_field('teaser_copy'); ?>
		          </div>
		        </div>
		      </div>
		<?php endwhile; ?>
			</div>
		</section>
	<?php endif; ?>
  
<?php endwhile; ?>

		</div>
	</div>
</div>
<?php get_footer(); ?>
