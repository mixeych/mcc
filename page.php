<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package mycitycard
 */
if(is_user_logged_in()&&is_page(2921)){
    wp_redirect(site_url());
    die();
}
get_header(); ?>
			<div class="container">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							echo 12354;
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>
			</div>

<?php// get_sidebar(); ?>
<?php get_footer(); ?>
