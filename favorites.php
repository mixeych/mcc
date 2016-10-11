<?php
/*
Template Name: Favorites
*/
check_user_auth();
get_header(); 
global $current_user;

?>
	<div class="container">

		<div id="sidebar">
			<?php get_sidebar(); ?>
		</div>

		<div id="primary" class="content-area">
			<main id="main">
				<div class="choose-fav-type">
							<?php 
                                    global $sitepress;
                                    $current_language = $sitepress->get_current_language();
                                    if($current_language === 'en'): 
                                    ?>
										<a href="javascript:void(0)" class="biz active-tab">Favorite Businesses</a>
					<a href="javascript:void(0)" class="ben">Favorite Benefits</a>
					
                                    <?php else: ?>
                                     <a href="javascript:void(0)" class="biz active-tab">עסקים מועדפים</a>
					<a href="javascript:void(0)" class="ben">הטבות מועדפות</a>
                                    <?php endif; ?>
					


					
				</div>

				<?php 
				$favorites = get_favorite_businesses($current_user->ID);
				?>
				<?php
				if(!empty($favorites)){
					echo "<div class='favorite-bizs clearfix'>";
						foreach ($favorites as $favorite) {
							$business_id = $favorite->business_id;

							if($favorite->business_id){
								$post = get_post($business_id);
								if($post){
									$permalink = get_post_permalink($business_id);
									$logo = get_field("logo", $business_id);
									if(is_numeric($logo)){
										$logo =  wp_get_attachment_image_src($logo)[0];
									}else{
										$logo = $logo["url"];
										
									}
									$cityId = get_field('bcity', $business_id);
                                                                        $iclCityId = icl_object_id($cityId, 'city', true);
									$city = get_the_title($iclCityId);
                                                                        $iclBizId = icl_object_id($business_id, 'city', true);
									$link = get_permalink($business_id);
                                                                        if($current_language === 'he'){
                                                                            $link = str_replace('/business/', '/he/business/', $link);
                                                                            
                                                                        }
									$description = get_field("short_description", $business_id);
									?>
										<div class="category-item">
											<div class="discount-preview">
											  <div class="discount-preview-container">
												<div class="discount-preview-image">
												  <a href="<?=$link ?>"><img src="<?=$logo?>"></a>
												</div>
												<div class="discount-preview-footer">
												<div class="discount-preview-star">
													<a href="javascript:void(0)" class="delFavBusiness" rel="<?=$business_id?>"><img src="<?php bloginfo('template_url') ?>/images/delete_icon.png" /></a>
												  </div>
												  <div class="discount-preview-title">
													<a href="<?=$link ?>"><?php echo $post->post_title; ?></a>
												  </div>
												  <div class="discount-preview-location">
													<a href="<?php echo $link ?>"><?php echo $city; ?></a>
												  </div>
												  
												</div>
											  </div>
											</div>
										</div>
								<?php
								}
								
							}
						}
					echo "</div>";
					?>
					
					<?php
				}
				?>
				<div class='favorite-bens' style='display:none'>
				</div>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
			if ( is_active_sidebar( 'ads-widgets' ) ) { ?>
			<div id="ads">
				<?php dynamic_sidebar( 'ads-widgets' ); ?>
			</div>
		<?php } ?>
	</div>
<?php get_footer(); ?>
