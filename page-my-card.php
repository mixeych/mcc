<?php 
/*
* Template Name: My card
*/
global $current_user;
check_user_auth();
if(!in_array('subscriber', $current_user->roles)){
	wp_redirect( home_url() );
}


get_header(); ?>
<div class="container">	
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>
	<div id="primary" class="content-area">
		<main id="main" class="" role="main">
	<!-- .page-header -->
		<?php 
			$userName = $current_user->display_name;
			$userCityID = get_user_meta($current_user->ID, 'city', true);
			$post = get_post($userCityID);
			$userCity = $post->post_title;
			$isActiveCity = get_post_meta($userCityID, 'active_city', true);
			if(empty($isActiveCity)){
				$userCity = 'GENERAL';
			}
			$cityTerms = wp_get_post_terms($userCityID, 'countries');
			if(!empty($cityTerms)){
				$userCountry = $cityTerms[0]->name;
			}else{
				$userCountry = 'Israel';
			}
			

			$userNumber = get_user_meta($current_user->ID, 'card', true);
			$userNumber = str_replace('_', ' ', $userNumber);
		?>
		<div class="my-citycard">
			<div class="main-info">
				<div class="row-card">
					<div class="user-country"><?php echo $userCountry ?></div>
				</div>
				<p class="slogan">My <span class="city-title">City</span> Card <span class="city"><?php echo $userCity ?></span><br>
				<span class="dop-city-ifo">Because in my city i deserve more</span>
				</p>
				<div class="card-number">
					<span><?php echo $userNumber ?></span><br>
					<span><?php echo $userName ?></span>
				</div>
			</div>
			<div class="card-bottom">
				<span class="sponsored-by">Sponsored by:</span>
				<?php echo do_shortcode('[advertising id=1482]') ?>

				<img src="<?php bloginfo('template_url') ?>/images/barcode.png" />
			</div>
		</div>

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
