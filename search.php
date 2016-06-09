<?php
/**
 * The template for displaying search results pages.
 *
 * @package mycitycard
 */
global $wpdb;
global $search;

get_header(); 
?>
<div class="container">	
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>
	<div id="primary" class="content-area">
		<main id="main" class="" role="main">
		<?php 
				$city = 'all';
	            if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All'){
	                $city = (int) $_SESSION["my_cityz"];
	            }
				$search = trim(strip_tags($_GET['s']));

					$query = "SELECT post_id FROM $wpdb->postmeta INNER JOIN $wpdb->posts ON {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID 
						WHERE {$wpdb->postmeta}.meta_value LIKE '%{$search}%'
						AND ({$wpdb->postmeta}.meta_key LIKE '%benefit_title' OR {$wpdb->postmeta}.meta_key LIKE '%benefit_description')
						AND {$wpdb->posts}.post_status = 'publish'
						GROUP BY post_id";
				
				
				$res = $wpdb->get_results($query);
				if(!empty($res)){
					$ids = array();
					foreach ($res as $obj){
						$ids[] = $obj->post_id;
					}
					$args = array(
							'post_type' => 'business',
							'post__in' => $ids,
							'showposts' => -1,
							'meta_key' => 'visibility',
							'meta_value' => "1",
						);
					$businesses = new WP_Query ($args);
				}
		if ( !empty($res) && isset($businesses) && $businesses->have_posts() )  : ?>
			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'mycitycard' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( $businesses->have_posts() ) : $businesses->the_post(); ?>
				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

			<?php //the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php
			if ( is_active_sidebar( 'ads-widgets' ) ) { ?>
			<div id="ads">
				<?php dynamic_sidebar( 'ads-widgets' ); ?>
			</div>
		<?php } ?>
<?php get_footer(); ?>
