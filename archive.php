<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mycitycard
 */
global $wpdb;
global $sitepress;
$currentLanguage = $sitepress->get_current_language();
get_header(); ?>
	<div class="container">

		<div id="sidebar">
			<?php get_sidebar(); ?>
		</div>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php 
			$city = 'all';
            if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All'){
                $city = (int) $_SESSION["my_cityz"];
            }
            $categoryPromo = get_queried_object()->term_id;
			$catP = get_queried_object()->parent;

			if($catP != 0){
				$categoryPromo = $catP;
			}
            $categoryPromo = icl_object_id($categoryPromo, 'business_cat', false, 'en');
            $query = "SELECT business_id FROM $wpdb->promotions WHERE promo_city = '$city' AND promo_area='$categoryPromo'";
            $res = $wpdb->get_results($query);

            if(!empty($res)):
            	?>
            	<div class="category-items">
            	<?php
            	foreach($res as $row):
	                $res = (int) $row->business_id;
	                $promoLink = get_permalink($res);
                        if($currentLanguage == 'he'){
                            $promoLink = str_replace('/business/', '/he/business/', $promoLink);
                        }
	                $promoTitle = get_the_title($res);
	                $promoLogo = get_field("logo", $res);
	                if(is_numeric($promoLogo)){
	                  $promoLogo = wp_get_attachment_image_src($promoLogo)[0];
	                }else{
	                  $promoLogo = $promoLogo["url"];
	                }
	                $promoCity = get_post_meta($res, 'bcity', true);
	                $promoCity = get_the_title($promoCity);
		?>
		
				
				  <div class="category-item">
					<div class="discount-preview">
					  <div class="discount-preview-container">
						<div class="discount-preview-image">
						  <a href="<?=$promoLink ?>"><img src="<?=$promoLogo ?>"></a>
						</div>
						<div class="discount-preview-footer">
						  <div class="discount-preview-title">
							<a href="<?=$promoLink ?>"><?=$promoTitle ?></a>
						  </div>
						  <div class="discount-preview-location">
							<a href="<?=$promoLink ?>"><?=$promoCity; ?></a>
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				 
			<?php endforeach;?> 
			</div><!-- category-items -->
			<?php endif; ?>
				<?php
if( is_tax() ) {
        global $wp_query;
        $term = $wp_query->get_queried_object();
        $iclId = (int) icl_object_id($term->term_id, 'business_cat', true, 'en');
        if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All') {
                $args = array(
                        'post_type' => 'business',
                        'post_status' => 'publish', 
                        'tax_query' => array(
                                array(
                                        'taxonomy' => 'business_cat',
                                        'field' => 'id',
                                        'terms' => $iclId
                                ),
                        ),
                        'meta_query' => array(
                                array(
                                        'key'   => 'bcity',
                                        'value' => $_SESSION["my_cityz"],
                                ),
                                array(
                                        'key'     => 'visibility',
                                        'value'   => "1",
                                ),
                        ),
                        'meta_key' => 'benefit_created_at',
                        'orderby'  => 'meta_value_num',
                        'order'    => 'DESC'
                );
        } else {
                $args = array(
                        'post_type' => 'business',
                        'post_status' => 'publish', 
                        'tax_query' => array(
                                array(
                                        'taxonomy' => 'business_cat',
                                        'field' => 'id',
                                        'terms' => $iclId
                                )
                        ),
                        'meta_query' => array(
                                array(
                                        'key'     => 'visibility',
                                        'value'   => "1",
                                ),
                        ),
                        'meta_key' => 'benefit_created_at',
                        'orderby'  => 'meta_value_num',
                        'order'    => 'DESC'
                );
        }
}
			$my_query = new WP_Query($args);

			if ( $my_query->have_posts() ) : ?>

				<header class="page-header">
					<?php
						single_cat_title( '<h1 class="page-title">', '</h1>' );
					?>
				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>

				<?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
					<?php

						$lang = get_bloginfo('language');
						if($lang == "en-US") {
							get_template_part( 'content', 'business_category_en');
						} elseif ($lang == "he-IL") {
							get_template_part( 'content', 'business_category_he');
						}
					?>

				<?php endwhile; ?>

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
			if ( is_active_sidebar( 'ads-widgets' ) ) { ?>
			<div id="ads">
				<?php dynamic_sidebar( 'ads-widgets' ); ?>
			</div>
		<?php } ?>
	</div>
<script>
jQuery(document).ready(function($) {
	//Update likes button
	$(".like_allow").on('click', function() {
		business_id = $(this).attr("rel");
		thisBiz = $(this);
		$.ajax({
			url: ajaxurl + "?action=update_business_likes",
			type: 'POST',
			data: { "bid" : business_id },
			success: function(data) {

				if(data.success == true) {
					thisBiz.removeClass("like_allow");
					thisBiz.addClass("like_disable");
					if(thisBiz.html() == "Be the first to like it") {
						thisBiz.html("<span>1</span> People like it");
					} else {
						current_count = thisBiz.find("span").html();
						thisBiz.html("<span>"+ ++current_count +"</span> People like it");
					}
				}
			},
			error: function(data) {
				console.log("FAILED");
			}
		});
	});
});
</script>
<?php get_footer(); ?>
