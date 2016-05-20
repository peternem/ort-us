<? get_header(); ?>

<div id="primary" class="content-area">
	<div id="main" class="site-main news">
	
  		<article id="post-<?php the_ID(); ?>" <?php post_class("row-container"); ?>>
  			<header class="entry-header">
  				<h1 class="entry-title"><? the_title(); ?> - What's Happening</h1>
  			</header>
			<div class="row">
			<section class="posts grid_9 omega">
			
			<?php 
			// the pager
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			// the query
			query_posts(
					$args = array(
					'post_type' => 'post',
					'posts_per_page' =>5,
					'paged' => $paged,
					'post_status' => 'publish',
					
				)
			);
			$the_query = new WP_Query( $args ); ?>
			
			<?php if ( $the_query->have_posts() ) : ?>
			
			<!-- pagination here -->
			
			<!-- the loop -->
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h2><?php the_title(); ?></h2>
					</header>
					<div class="entry-content">
					<?php the_content(); ?>
					</div>
					<footer class="entry-footer">
						<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article>
			<?php endwhile; ?>
			<!-- end of the loop -->
			
			<!-- pagination here -->
			<div class="pagination">
				<ul class="pager">
			    	<li><?php previous_posts_link('&laquo; Previous') ?></li>
		    		<li><?php next_posts_link('More &raquo;') ?></li>
			  	</ul>
		    </div>
			<?php wp_reset_postdata(); ?>
			
			<?php else : ?>
				<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>	
			</section>
			<aside class="grid_3 alpha twitty">
				<a class="twitter-timeline" href="https://twitter.com/OrtliebUSA" data-widget-id="299315673065209857">Tweets by @OrtliebUSA</a>
			    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</aside>
		   	</div>
		</article>
	</div>
</div>

<? get_footer(); ?>
