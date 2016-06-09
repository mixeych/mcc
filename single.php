<?php
/**
 * The template for displaying all single posts.
 *
 * @package mycitycard
 */

get_header(); ?>

	
	<div class="container">

		<div id="sidebar">
			<?php get_sidebar(); ?>
		</div>
		<div id="primary" class="business_page">
			<main id="main" class="site-main business_page_warp" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div>
	

<?php get_footer(); ?>
