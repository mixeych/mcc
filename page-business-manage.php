<?php
/*
* Template Name: ניהול עסק
*/
global $wpdb;
global $current_user;

check_user_auth();

if(is_user_logged_in()&&$current_user->caps['subscriber']){
	wp_redirect(home_url());
}

get_header();

$args = array(
	'author' => $current_user->ID,
	'posts_per_page'   => 1,
	'post_type'        => 'business'
);
$business = get_posts( $args ); 

$benefitStatus;
$business_pack = get_field("business_pack", $business[0]->ID);
$post_term = wp_get_post_terms($business[0]->ID, 'business_cat');
$postTermId = $post_term[0]->term_id;
if(empty($business_pack)) {
	get_template_part("template", "packages-choice");
} else {
	$logo = get_field("logo", $business[0]->ID);

	$ltd = get_field("field_5547749c3e294", $business[0]->ID);
	$first_name = get_field("field_554774c73e296", $business[0]->ID);
	$last_name = get_field("field_554775223e297", $business[0]->ID);
	$phone = get_field("field_5547753a3e298", $business[0]->ID);
	$address = get_field("address", $business[0]->ID);
	$email = get_field("field_554775513e299", $business[0]->ID);
	$short_desc = get_field("field_554775a23e29e", $business[0]->ID);
	$business_role = get_field("business_role", $business[0]->ID);
	$business_phone = get_field("business_phone", $business[0]->ID);
	$business_phone_2 = get_field("business_phone_2", $business[0]->ID);
	$add_info = get_field("additional_info", $business[0]->ID);
	$main_photo = get_field("main_photo", $business[0]->ID);
	$benefitStatus = get_post_meta($business[0]->ID, 'benefits_0_benefit_status', true);
	
	$bizCityId = get_post_meta($business[0]->ID, 'bcity', true);
	$isActive = get_post_meta($bizCityId, 'active_city', true);
	if(empty($isActive)){
            update_post_meta($business[0]->ID, 'visibility', 0);
            delete_visible_post($business[0]->ID, $postTermId);
		?>
		<div class="container">
			<div id="primary" class="content-area" style="width: 100%;">
		  		<main id="main" class="site-main" role="main" style="float: none;">
					<div class="warning">
						My City Card <?php echo get_the_title($bizCityId) ?> is not active - cant edit business information
					</div>
				</main>
			</div>
		</div>
		<?php
	}else{
		if( have_rows('benefits', $business[0]->ID) ){
			while (have_rows('benefits', $business[0]->ID)){
				the_row();
				$benefitType = get_sub_field('benefit_type');
				if($benefitType == 'Main Benefit'){
					$benefitStatus = get_sub_field('benefit_status');
				}
			}
		}
	if(!empty($ltd) and !empty($first_name) and !empty($last_name) and !empty($phone) and !empty($address) and !empty($email) and !empty($business_phone) and !empty($short_desc) and !empty($benefitStatus) and !empty($main_photo) and !empty($logo) and !empty($post_term) and !empty($isActive)){
		//add_current_city_to_list($business[0]->ID);
		update_post_meta($business[0]->ID, 'visibility', 1);
		add_visible_post($business[0]->ID, $postTermId);
	}else{
		//remove_current_city_form_list($business[0]->ID);
		update_post_meta($business[0]->ID, 'visibility', 0);
		delete_visible_post($business[0]->ID, $postTermId);
	}
	//$mycredits = intval(mycred_get_users_cred($business->post_author));
	?>

	  <div class="container">
		<div id="primary" class="content-area" style="width: 100%;">
		  <main id="main" class="site-main" role="main" style="float: none;">
		  	<?php 
		  	$vis = get_post_meta($business[0]->ID, 'visibility', true);
		  	?>
		  	<div class="notification">
		  		<?php
			  	if(empty($vis)):
			  	?>
				<div class="warning">
					Your business does not appear in the website and app. You must complete some details to appear.
				</div>
				<?php else: ?>
				<div class="note">
					Your business is visible.
				</div>
				<?php endif; ?>
			</div>
			<div class="accordion">
				<div class="accordion-section">
					<?php 
						if(!empty($ltd) and !empty($first_name) and !empty($last_name) and !empty($phone) and !empty($address) and !empty($email) and !empty($business_phone) and !empty($short_desc) ){
							$class = '';
						}else{
							$class= 'err';
						}
					?>
					<a class="accordion-section-title <?php echo $class; ?> <?php if(isset($_COOKIE['active']) && $_COOKIE['active'] == 2){echo 'active';} ?>" href="" title="1" style="background: #d28b26;">
						Business Details
					</a>
					 
                                    <div id="accordion-1" class="accordion-section-content" <?php if(isset($_COOKIE['active']) && $_COOKIE['active'] == 2){echo 'style="display:block"';} ?> data-bizrole="<?=$business_role ?>">
						<div class="accordion-section-padding">
							<?php echo do_shortcode("[gravityform id=2 title=false description=false ajax=true field_values='business_name={$business[0]->post_title}&ltd={$ltd}&first_name={$first_name}&last_name={$last_name}&phone={$phone}&address={$address}&email={$email}&business_role={$business_role}&business_phone={$phone}&business_phone_2={$business_phone_2}&short_desc={$short_desc}']"); ?>

							<label class="main-logo" data-logo="<?php if(!empty($logo)){ echo "1"; }else{ echo "0"; } ?>" >Logo<input type="file" ></label>
							<a href="<?php echo get_permalink($business[0]->ID); ?>" target="_blank" id="preview_business_page">Preview Business Page</a>
							<?php 
								$cityId = get_user_meta($current_user->ID, 'city', true);
								$city = get_post($cityId);
							?>
							<input class="user-city" type="hidden" value="<?php echo $city->post_title ?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="accordion">
				<div class="accordion-section">

					<a class="accordion-section-title <?php if(isset($_COOKIE['active']) && ($_COOKIE['active'] == 3||$_COOKIE['active']==10)){echo 'active';}  if(empty($main_photo)||empty($logo)||empty($post_term)){echo 'err'; } ?>" href="" title="2" style="background: #eda43c;">
						Business Page
					</a>
					 
					<div id="accordion-2" class="accordion-section-content" <?php if(isset($_COOKIE['active']) && ($_COOKIE['active'] == 3||$_COOKIE['active']==10)){echo 'style="display:block"';} ?> data-category="<?php if(empty($post_term)){echo "0";}else{echo "1";} ?>">
						<div class="accordion-section-padding">
							<?php 
								if($business_pack == 'Premium') { 
									echo do_shortcode('[gravityform id=10 title=false description=false ajax=true]');
								} else {
									echo do_shortcode('[gravityform id=3 title=false description=false ajax=true]');
								}
							?>
						</div>
						<div class="section-border"></div>
						<div class="accordion-section-padding">
							<div class="logo-choose">

								</div>

								<div class="logo_preview">
								<?php 
									if(!empty($logo)):
										if(is_numeric($logo)){
											$logoSrc = wp_get_attachment_image_src($logo)[0];
										}else{
											$logoSrc = $logo["url"];
										}
								?>
									<img src="<?php echo $logoSrc ?>" />
								<?php 
									endif;
								?>
								</div>
							<div class="section-border"></div>
							<div id="main_photo_block" data-photo=<?php if(!empty($main_photo)){ echo "1"; }else{ echo "0"; } ?>>
								
								<div class="business_gallery_image">

									<span id="business_main_photo"><strong>Main Photo</strong><span class="gfield_required" style="color:#790000;">*</span><br />At least 480x300 pixels</span>
									<?php 

										if($main_photo): 
												if(is_numeric($main_photo))
													$main_photo = wp_get_attachment_image_src($main_photo)[0];
												else 
													$main_photo = $main_photo["url"];

									?>
										<div class="add_cover_photo_button general-button" rel="main_photo">Change Main Photo</div>
										<input type="file" id="main_photo" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
										<a href="<?=$main_photo?>" target="_blank">Click HERE to preview main photo</a>
										<img src="<?=$main_photo?>" alt="" style="width: 170px;float: left;clear: both;" />
									<?php else: ?>
										<div class="add_cover_photo_button general-button" rel="main_photo">Add Main Photo</div>
										<input type="file" id="main_photo" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
									<?php endif; ?>
								</div>

							</div>
						</div>
						<div class="section-border"></div>
						<?php if($business_pack != 'Free') { ?>
							<div class="accordion-section-padding">

								<div id="add_cover_photo">
									<h2 class="add-photo-title">Additional photos</h2>
										<div class="col-md-12 pull-left">
										<div class="business_gallery_image">
											<?php $photo_1 = get_field("photo_1", $business[0]->ID);
											if(!empty($photo_1)){
												if(is_numeric($photo_1)){
													$photo_1 = wp_get_attachment_image_src($photo_1)[0];
												}else{
													$photo_1 = $photo_1['url'];
												}
											}
											if($photo_1): ?>
												<div class="add_cover_photo_button general-button" rel="photo_1">Change Photo #1</div>
												<input type="file" id="photo_1" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
												<img src="<?=$photo_1?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_1?>" target="_blank">Click HERE to preview Photo #1</a>
												<span class="add-photo-remove" data-id="1" data-biz="<?php echo $business[0]->ID ?>" >remove</span>
												
											<?php else: ?>
												<div class="add_cover_photo_button general-button" rel="photo_1">Upload Photo #1</div>
												<input type="file" id="photo_1" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
											<?php endif; ?>
										</div>
										<div class="business_gallery_image">
											<?php $photo_2 = get_field("photo_2", $business[0]->ID);
											if(!empty($photo_2)){
												if(is_numeric($photo_2)){
													$photo_2 = wp_get_attachment_image_src($photo_2)[0];
												}else{
													$photo_2 = $photo_2['url'];
												}
											}
											if($photo_2): ?>
												<div class="add_cover_photo_button general-button" rel="photo_2">Change Photo #2</div>
												<input type="file" id="photo_2" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
												<img src="<?=$photo_2?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_2?>" target="_blank">Click HERE to preview Photo #2</a>
												<span class="add-photo-remove" data-id="2" data-biz="<?php echo $business[0]->ID ?>">remove</span>
												
											<?php else: ?>
												<div class="add_cover_photo_button general-button" rel="photo_2">Upload Photo #2</div>
												<input type="file" id="photo_2" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
											<?php endif; ?>
										</div>
										<div class="business_gallery_image">
											<?php $photo_3 = get_field("photo_3", $business[0]->ID);
											if(!empty($photo_3)){
												if(is_numeric($photo_3)){
													$photo_3 = wp_get_attachment_image_src($photo_3)[0];
												}else{
													$photo_3 = $photo_3['url'];
												}
											}
											if($photo_3): ?>
												<div class="add_cover_photo_button general-button" rel="photo_3">Change Photo #3</div>
												<input type="file" id="photo_3" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
												<img src="<?=$photo_3?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_3?>" target="_blank">Click HERE to preview Photo #3</a>
												<span class="add-photo-remove" data-id="3" data-biz="<?php echo $business[0]->ID ?>">remove</span>
												
											<?php else: ?>
												<div class="add_cover_photo_button general-button" rel="photo_3">Upload Photo #3</div>
												<input type="file" id="photo_3" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
											<?php endif; ?>
										</div>
										<div class="business_gallery_image">
											<?php $photo_4 = get_field("photo_4", $business[0]->ID);
											if(!empty($photo_4)){
												if(is_numeric($photo_4)){
													$photo_4 = wp_get_attachment_image_src($photo_4)[0];
												}else{
													$photo_4 = $photo_4['url'];
												}
											}
											if($photo_4): ?>
												<div class="add_cover_photo_button general-button" rel="photo_4">Change Photo #4</div>
												<input type="file" id="photo_4" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
												<img src="<?=$photo_4?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_4?>" target="_blank">Click HERE to preview Photo #4</a>
												<span class="add-photo-remove" data-id="4" data-biz="<?php echo $business[0]->ID ?>">remove</span>
												
											<?php else: ?>
												<div class="add_cover_photo_button general-button" rel="photo_4">Upload Photo #4</div>
												<input type="file" id="photo_4" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" />
											<?php endif; ?>
										</div>
									</div>
								</div>
								
							</div>
						<?php }else{ ?>
						
							<div class="accordion-section-padding">
								<div id="add_cover_photo">
								<h2 class="add-photo-title">Additional photos</h2>
									<div class="col-md-12 pull-left">
										<div class="business_gallery_image">
											<?php $photo_1 = get_field("photo_1", $business[0]->ID);
											if($photo_1): ?>
												<div class="add_cover_photo_button" rel="photo_1">Change Photo #1</div>
												<input type="file" id="photo_1" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
												<img src="<?=$photo_1["url"]?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_1["url"]?>" target="_blank">Click HERE to preview Photo #1</a>
												
											<?php else: ?>
												<div class="add_cover_photo_button" rel="photo_1">Upload Photo #1</div>
												<input type="file" id="photo_1" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
											<?php endif; ?>
										</div>
										<div class="business_gallery_image">
											<?php $photo_2 = get_field("photo_2", $business[0]->ID);
											if($photo_2): ?>
												<div class="add_cover_photo_button" rel="photo_2">Change Photo #2</div>
												<input type="file" id="photo_2" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
												<img src="<?=$photo_2["url"]?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_2["url"]?>" target="_blank">Click HERE to preview Photo #2</a>
												
											<?php else: ?>
												<div class="add_cover_photo_button" rel="photo_2">Upload Photo #2</div>
												<input type="file" id="photo_2" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
											<?php endif; ?>
										</div>
										<div class="business_gallery_image">
											<?php $photo_3 = get_field("photo_3", $business[0]->ID);
											if($photo_3): ?>
												<div class="add_cover_photo_button" rel="photo_3">Change Photo #3</div>
												<input type="file" id="photo_3" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
												<img src="<?=$photo_3["url"]?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_3["url"]?>" target="_blank">Click HERE to preview Photo #3</a>
												
											<?php else: ?>
												<div class="add_cover_photo_button" rel="photo_3">Upload Photo #3</div>
												<input type="file" id="photo_3" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
											<?php endif; ?>
										</div>
										<div class="business_gallery_image">
											<?php $photo_4 = get_field("photo_4", $business[0]->ID);
											if($photo_4): ?>
												<div class="add_cover_photo_button" rel="photo_4">Change Photo #4</div>
												<input type="file" id="photo_4" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
												<img src="<?=$photo_4["url"]?>" alt="" class="business_small_preview" />
												<a href="<?=$photo_4["url"]?>" target="_blank">Click HERE to preview Photo #4</a>
												
											<?php else: ?>
												<div class="add_cover_photo_button" rel="photo_4">Upload Photo #4</div>
												<input type="file" id="photo_4" name="file" rel="<?=$business[0]->ID?>" style="display:none" class="business_gallery_img" disabled="disabled"/>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="more-photos-box">
									<a href="#">
										More photos bring more clients.
										Upgrade to Premium Now!
									</a>
								</div>
							</div>
						<?php } ?>
						<div class="section-border"></div>
						<div class="accordion-section-padding">
							<div id="manage_business_links">
								<div class="col-md-6 pull-left">
									<h2>Links</h2>
									<p>
										Premium users can add to their business homepage and social media links. 
										<?php if($business_pack == 'Free' ){ ?><a href="#">Upgrade to Premium Now!</a><?php } ?>
									</p>
									<form action="javascript:void(0)">
										<div class="manage_business_links_row">
											<span>Homepage</span>
											<?php
												$homepage = get_field("homepage", $business[0]->ID);
												if($homepage)
													$HPval = $homepage;
											?>
											<input type="text" id="homepage_preview" placeholder="http://" value="<?php echo $HPval; ?>" <?php if($business_pack == 'Free' ){ ?> disabled="disabled" <?php } ?>/>
											<?php  if($business_pack != 'Free' ){?><button id="homepage_preview_button">	Preview link</button><?php } ?>
										</div>
										<div class="manage_business_links_row">
											<span>Facebook</span>
											<?php
												$facebook_page = get_field("facebook_page", $business[0]->ID);
												if($facebook_page)
													$FBval = $facebook_page;
											?>
											<input type="text" id="facebook_preview" placeholder="http://" value="<?php echo $FBval; ?>" <?php if($business_pack == 'Free' ){ ?> disabled="disabled" <?php } ?>/><?php  if($business_pack != 'Free' ){?><button id="facebook_preview_button">Preview link</button><?php } ?>
										</div>
										<?php  if($business_pack != 'Free' ){?><input type="submit" value="Save Changes" id="links_update" /><?php } ?>
									</form>
								</div>
							</div>
						</div>
						<div class="section-border"></div>
						<div class="accordion-section-padding">
							<strong>Opening Hours</strong><br />
							<select name="openingDay" id="openingDay">
								<option value="">-</option>
								<option value="Sunday">Sunday</option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
							</select>
							<select name="openingDayStart" id="openingDayStart">
								<option value="">-</option>
								<option value="00:00">00:00</option>
								<option value="01:00">01:00</option>
								<option value="02:00">02:00</option>
								<option value="03:00">03:00</option>
								<option value="04:00">04:00</option>
								<option value="05:00">05:00</option>
								<option value="06:00">06:00</option>
								<option value="07:00">07:00</option>
								<option value="08:00">08:00</option>
								<option value="09:00">09:00</option>
								<option value="10:00">10:00</option>
								<option value="11:00">11:00</option>
								<option value="12:00">12:00</option>
								<option value="13:00">13:00</option>
								<option value="14:00">14:00</option>
								<option value="15:00">15:00</option>
								<option value="16:00">16:00</option>
								<option value="17:00">17:00</option>
								<option value="18:00">18:00</option>
								<option value="19:00">19:00</option>
								<option value="20:00">20:00</option>
								<option value="21:00">21:00</option>
								<option value="22:00">22:00</option>
								<option value="23:00">23:00</option>
								<option value="24:00">24:00</option>
							</select>
							<select id="openingDayEnd" name="openingDayEnd">
								<option value="">-</option>
								<option value="00:00">00:00</option>
								<option value="01:00">01:00</option>
								<option value="02:00">02:00</option>
								<option value="03:00">03:00</option>
								<option value="04:00">04:00</option>
								<option value="05:00">05:00</option>
								<option value="06:00">06:00</option>
								<option value="07:00">07:00</option>
								<option value="08:00">08:00</option>
								<option value="09:00">09:00</option>
								<option value="10:00">10:00</option>
								<option value="11:00">11:00</option>
								<option value="12:00">12:00</option>
								<option value="13:00">13:00</option>
								<option value="14:00">14:00</option>
								<option value="15:00">15:00</option>
								<option value="16:00">16:00</option>
								<option value="17:00">17:00</option>
								<option value="18:00">18:00</option>
								<option value="19:00">19:00</option>
								<option value="20:00">20:00</option>
								<option value="21:00">21:00</option>
								<option value="22:00">22:00</option>
								<option value="23:00">23:00</option>
								<option value="24:00">24:00</option>
							</select>
							<input type="button" value="Add" id="addOpeningDay" />
							<div id="opening_hours_data">
								<ul>
									<?php
										$opening_hours = get_field("opening_hours", $business[0]->ID);
										if($opening_hours) {
											foreach($opening_hours as $row) {
										?>
												<li>
													<a href="javascript:void(0)" class="openingDayDelete" rel="<?=$row["id"]?>"><img src="<?php bloginfo('template_directory'); ?>/images/delete_icon.png" alt="" /></a> 
													<a href="javascript:void(0)" class="popmake-edit-opening-day" rel="<?=$row["id"]?>"><i class="fa fa-pencil-square-o"></i></a> 
													<?=$row["day"]." ".$row["start"]." - ".$row["end"];?></li>
										<?php
											}
										}
									?>
								</ul>
							</div>
						</div>
						<div class="section-border"></div>
						<div class="accordion-section-padding">
							<div id="manage_business_additional_info">
								<?php echo do_shortcode("[gravityform id=11 title=false description=false ajax=true field_values='add_information={$add_info}']"); ?>
								<!--<div class="col-md-6 pull-left">
									<h2>Additional Information</h2>
									<p>
										Let your customers get to know your business in 30 – 1000 characters. 
									</p>
									<form action="javascript:void(0)">
										<textarea id="additional_info"><?php echo get_field("additional_info", $business[0]->ID); ?></textarea>
										<input type="submit" value="Save Changes" id="additional_info_update" />
									</form>
								</div>-->
							</div>
							<a href="<?php echo get_permalink($business[0]->ID); ?>" target="_blank" id="preview_business_page">Preview Business Page</a>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion" id="a3">
				<div class="accordion-section">
				<?php 
					if(empty($benefitStatus)){
						$class = 'err';
					}else{
						$class = '';
					}
				?>
					<a class="accordion-section-title <?=$class ?>" href="" title="3" style="background: #dd6f33;">
						<div style="display: inline-block; padding-top: 4px; padding-bottom: 4px;">
							<span style="display: block; color: #fff;">Benefits & Coupons</span>
							<span style="display: block; color: #fff; clear: both; font-size: 16px; margin-top: -6px;">That your Business offers</span>
						</div>
					</a>
					 
					<div id="accordion-3" class="accordion-section-content">
						<div class="accordion-section-padding">
							<div id="manage_business_benefits">
								<h2>Main Benefit</h2>
								<p>
									The main benefit is a mandatory benefit, without it your business will not appear in the businesses list. This benefit is to your City card holder only! No other city card holders deserves it. With publishing this benefit you agree to this conditions
								</p>
								<?php if( have_rows('benefits', $business[0]->ID) ): ?>
								<table class="main-benefit">
										<tr>
											<th></th>
											<th>Status</th>
											<th>Details</th>
											<th>Send Date</th>
											<th>Next update</th>
											<th>Targeted Customers</th>
											<th>Actions</th>
										</tr>
										<tr>
											<td colspan="9">
												<div class="section-border"></div>
											</td>
										</tr>
										<?php
										$i = 0;
											while (have_rows('benefits', $business[0]->ID)) : the_row(); 									
												if(get_sub_field('benefit_type') == "Main Benefit") {
													$actionButton = get_sub_field('benefit_status') == 1?"Stop":"Resume";
													$statusText = get_sub_field('benefit_status') == 1?"Active":"Disabled";
													$statusClass = 'active';
													if($statusText == 'Disabled'){
														$statusClass = 'err';
													}
													$ID = get_sub_field('benefit_id');
													$bPack = get_field('business_pack', $business[0]->ID);
													if($bPack != "Free")
														$updateText = "Any Time";
													else 
														$updateText =  get_sub_field('benefit_end_date');
													$area = get_sub_field('area');
										?>
											<tr class="<?=$statusClass ?>">
												<td><!--<a href="" class="benefitDelete" rel="<?/*=$ID;*/?>"><img src="<?php /*bloginfo('template_directory'); */?>/images/delete_icon.png" alt="" />--></td>
												<td><?=$statusText?></td>
												<td>
													<span class="ben-title" style="text-decoration:underline; cursor:pointer;"><?=the_sub_field('benefit_title');?></span>
													
													<span class="ben-desc" style="display:none;"><?=the_sub_field('benefit_description')?></span>
												</td>
												<td><?=the_sub_field('benefit_publish_date');?></td>
												<?php
													$nextUpdate = 'Any time';
													if($business_pack == 'Free'){
														$nextUpdate = get_sub_field('benefit_expiration');

													}
													
												?>
												<td><?=$nextUpdate ?></td>
												<td><?=$area?></td>
												<td><a href="" class="popmake-edit-benefit businessTableButton" rel="<?=$ID;?>">Change</a><a href="" rel="<?=$ID;?>" class="benefitStatusAction businessTableButton"><?=$actionButton?></a></td>
											</tr>
											<tr class="drop-down" style="display:none">
												<td colspan="9">
													<div class="info clearfix">
														<?php 
															$benPhoto = get_sub_field('benefit_image');
															if(!empty($benPhoto)){
																if(is_numeric($benPhoto)){
																	$benPhoto = wp_get_attachment_image_src($benPhoto)[0];
																}else{
																	$benPhoto = $benPhoto['url'];
																}
														?>
														<img src="<?=$benPhoto ?>" />
														
														<?php } ?>
														<span class="desc"><?=the_sub_field('benefit_description')?></span>
													</div>
												</td>
											</tr>
										<?php $i++; 
												}
										endwhile; ?>
									
								</table>
								<?php else: ?>
										<a href="#" class="popmake-add-new-benefit" id="add_benefit">Add Benefit</a>
								<?php endif; ?>
								<?php 
									$benefitId = get_post_meta($business[0]->ID, 'benefits_0_benefit_id', true);
									if($business_pack == 'Premium' && !empty($benefitId)): 
								?>
								<div>
									<h2>Additional Benefits</h2>
									<table class="additional">
										<tr>
											<th></th>
											<th>Status</th>
											<th>Details</th>
											<th>Send Date</th>
											<th>Valid through</th>
											<th>Targeted Customers</th>
											<th>Actions</th>
										</tr>
										<tr>
											<td colspan="9">
												<div class="section-border"></div>
											</td>
										</tr>
										<?php if( have_rows('benefits', $business[0]->ID) ): 
											$i = 0;
												while (have_rows('benefits', $business[0]->ID)) : the_row(); 									
													if(get_sub_field('benefit_type') == "Additional") {
														$actionButton = get_sub_field('benefit_status') == 1?"Stop":"Resume";
														$statusText = get_sub_field('benefit_status') == 1?"Active":"Disabled";
														$statusClass = 'active';
														if($statusText == 'Disabled'){
															$statusClass = 'err';
														}
														$ID = get_sub_field('benefit_id');
														$bPack = get_field('business_pack', $business[0]->ID);
														if($bPack != "Free")
															$updateText = "Any Time";
														else 
															$updateText =  get_sub_field('benefit_end_date');
											?>
														<tr class="<?=$statusClass ?>">
															<td><a href="" class="benefitDelete" rel="<?=$ID;?>"><img src="<?php bloginfo('template_directory'); ?>/images/delete_icon.png" alt="" /></a></td>
															<td><?=$statusText?></td>
															<td>
																<span class="ben-title" style="text-decoration:underline; cursor:pointer;"><?=the_sub_field('benefit_title');?></span>
																
																<span class="ben-desc" style="display:none;"><?=the_sub_field('benefit_description')?></span>
															</td>
															<td><?=the_sub_field('benefit_publish_date');?></td>
															<td><?=the_sub_field('benefit_expiration');?></td>
															<td><?=the_sub_field('area')?></td>
															<td><a href="" class="popmake-edit-additional-benefit businessTableButton" rel="<?=$ID;?>">Change</a><a href="" rel="<?=$ID;?>" class="benefitStatusAction businessTableButton additional"><?=$actionButton?></a></td>
														</tr>
														<tr class="drop-down" style="display:none">
															<td colspan="9">
																<div class="info clearfix">
																	<?php 
																		$benPhoto = get_sub_field('benefit_image');
																		if(!empty($benPhoto)){
																			if(is_numeric($benPhoto)){
																				$benPhoto = wp_get_attachment_image_src($benPhoto)[0];
																			}else{
																				$benPhoto = $benPhoto['url'];
																			}
																	?>
																	<img src="<?=$benPhoto ?>" />
																	
																	<?php } ?>
																	<span class="desc"><?=the_sub_field('benefit_description')?></span>
																</div>
															</td>
														</tr>
											<?php $i++; 
													}
											endwhile;?>
										<?php endif; ?>
									</table>
									<a href="#" class="popmake-add-benefit" id="add_benefit">Add Benefit</a>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion" id="a4">
				<div class="accordion-section">
					<a class="accordion-section-title <?php if($business_pack == 'Free'){echo "blocked";} ?>" href="" title="4" style="background: #cbc5bd;">
						<span style="display: block; color: #fff; position: relative; top: 13px;">Message Your Clients</span>
					</a>
					<?php if($business_pack != 'Free' ): ?>
					<div id="accordion-4" class="accordion-section-content">
						<div class="accordion-section-padding">
							<div id="manage_business_benefits">
								<h2>Title</h2>
								<p>
									Text or somethingText or somethingText or somethingText or somethingText or something 
								</p>
								<table>
									<tr>
										<th></th>
										<th>Status</th>
										<th>Details</th>
										<th>Send Date</th>
										<th>Valid <br />Through</th>
										<th>Targeted<br /> Customers</th>
										<th>No. of <br />Customers targeted</th>
										<th>Customers<br /> Reach</th>
										<th>Action</th>
									</tr>
									<?php
    $args = array(
            'author' => $current_user->ID,
            'post_type' => 'message',
            'showposts' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                        'meta_key' => 'status',
                        'meta_value' => 'active',
                ),
                array(
                        'meta_key' => 'status',
                        'meta_value' => 'expired',
                ),
                array(
                        'meta_key' => 'status',
                        'meta_value' => 'sold out',
                )
        )
    );
										$mes = new WP_Query ($args);
										if($mes->have_posts()):
											while($mes->have_posts()):
												$mes->the_post();
												$mesId = get_the_id();
												$rowClass = '';
												$status = get_post_meta($mesId, 'status', true);
												if($status != 'active'){
													$rowClass = 'err';
												} else {
                                                    $rowClass = 'active';
                                                }
												$startDate = (int) get_post_meta($mesId, 'startDate', true);
												$startDate = date('d/m/Y H:i:s', $startDate);
												$endDate = (int) get_post_meta($mesId, 'endDate', true);
												$endDate = date('d/m/Y H:i:s', $endDate);
												$amount = get_post_meta($mesId, 'amount', true);
												$count_targeted = get_post_meta($mesId, 'count_targeted', true);
												$actionButton = $status == 'active'?"Stop":"Resume";
												$target = get_post_meta($mesId, 'target', true);
												$matches = get_post_meta($mesId, 'matches', true);
												$meters = get_post_meta($mesId, 'meters', true);
												$areaText = 'ALL MCC Holders';
												if($target == 'Your city card holders'){
													$cityId = get_post_meta($mesId, 'city', true);
													$cityTitle = get_the_title($cityId);
													$areaText = $cityTitle.' card Holders';
												}
												$details = get_the_content();
												if(strlen($details) > 30){
													$shortDesc = substr($details, 0, 30);
													$shortDesc .= '...';
												}else{
													$shortDesc = $details;
												}
									?>
                                                <?php if ($status != 'deleted') { ?>
											<tr class="<?=$rowClass ?>">
												<td><a href="javascript:void(0)" class="messageDelete" rel="<?=$mesId;?>"><img src="<?php bloginfo('template_directory'); ?>/images/delete_icon.png" alt="" /><span style="display:none" class="target"><?=$target ?></span><span style="display:none" class="matches"><?=$matches ?></span><span style="display:none" class="meters"><?=$meters ?></span></td>
												<td><?=ucfirst($status);?></td>
												<td class="content" style="text-decoration:underline; cursor:pointer;"><span class="details"><?=$shortDesc ;?></span></td>
												<td><?=$startDate ;?></td>
												<td><?=$endDate;?></td>
												<td><?=$areaText?></td>
												<td><?=$amount;?></td>
												<td><?=$count_targeted;?></td>
												<td class="messagesLastCell">
													<a href="javascript:void(0)" rel="<?=$mesId;?>" class="messageAction businessTableButton"><?=$actionButton?></a>
													<a href="javascript:void(0)" class="businessTableButton extDuration" rel="<?=$mesId;?>">Extend Duration</a>
													<a href="javascript:void(0)" class="businessTableButton soldOut" rel="<?=$mesId;?>">Sold Out</a>
												</td>
											</tr>
                                                <?php } ?>
											<tr class="drop-down" style="display:none">
												<td colspan="9">
													<div class="info clearfix">
														<?php 
															$message_image = get_post_meta($mesId, 'message_image', true);
															if(!empty($message_image)){
																if(is_numeric($message_image)){
																	$message_image = wp_get_attachment_image_src($message_image)[0];
																}else{
																	$message_image = $message_image['url'];
																}
														?>
														<img src="<?php echo $message_image ?>" />
														
														<?php } ?>
														<span class="desc"><?php echo $details ?></span>
													</div>
												</td>
											</tr>
										<?php 
										endwhile;?>

									<?php endif; wp_reset_query(); ?>
								</table>
								<a href="#" class="popmake-notification-clients-message-popup" id="add_benefit">Create Message</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
				</div>
			</div>
			<?php if($business_pack == 'Free' ) { ?>
				<div class="premium">
					<a href="">Upgrade to Premium Now!</a>
				</div>
			<?php } ?>
			<script>
				jQuery(document).ready(function($) {
					$("#homepage_preview_button").click(function(e) {
						e.preventDefault();
						var val = $("#homepage_preview").val();
						if(val != '') {
							if(val.substr(0, 7) != 'http://'&&val.substr(0, 8) !=  'https://'){
								val = "http://"+val;
							}
							var win = window.open(val, '_blank');
							win.focus();

						} else
							alert("Please enter homepage before preview");
					});
					
					$("#facebook_preview_button").click(function(e) {
						e.preventDefault();
						var val = $("#facebook_preview").val();
						if(val != '') {
							if(val.substr(0, 7) != 'http://'&&val.substr(0, 8) !=  'https://'){
								val = "http://"+val;
							}
							var win = window.open(val, '_blank');
							win.focus();
						} else
							alert("Please enter facebook page before preview");
					});
					
					$("#links_update").click(function(e) {
						e.preventDefault();
						var fb = $("#facebook_preview").val();
						var hp = $("#homepage_preview").val();
						
						if(fb.substr(0, 7) != 'http://'&&fb.substr(0, 8) !=  'https://'){
							fb = "http://"+fb;
						}
						if(hp.substr(0, 7) != 'http://'&&hp.substr(0, 8) !=  'https://'){
							hp = "http://"+hp;
						}

						if(fb != ''&&fb != 'http://')  {

							if(!/^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i.test(fb)) {
								alert("Please enter a valid facebook link");
								return false;
							}
						}else{
							fb = '';
						}
						if(hp == ''||hp === 'http://'){
							hp = '';
						}
						
						if(!fb&&!hp){
							return false;
						}
						
						$.ajax({
							url: ajaxurl + "?action=business_links_update",
							type: 'POST',
							data: { "fb" : fb, "homepage": hp, "business_id": "<?=$business[0]->ID;?>" },
							success: function(data) {
								console.log(data);
								if(data.success == true)
									alert("Business links updated!");
							},
							error: function(data) {
								alert("FAILED");
							}
						});
					});
					
					$("#addOpeningDay").click(function(e) {
						e.preventDefault();
						var openingDayEnd = $("#openingDayEnd").val();
						var openingDayStart = $("#openingDayStart").val();
						var openingDay = $("#openingDay").val();
						
						if(openingDay != '' && openingDayStart != '' && openingDayEnd != '') {
							$.ajax({
								url: ajaxurl,
								method: 'POST',
								data: { action: "addOpeningDay", "openingDay": openingDay, "openingDayStart": openingDayStart, "openingDayEnd" : openingDayEnd	},
								success: function(data) {
										$("#opening_hours_data > ul").append(data);
										alert("Opening hours updated!");
										//window.location = window.location.href;
								},
								error: function(data) {
									console.log("error");
								}
							});
						} else {
							alert("Please fill out all fields");
						}
					});
					
					$(".openingDayDelete").click(function(e) {
						e.preventDefault();
						var openingDayId = $(this).attr("rel");
						var li = $(this).parent();
						$.ajax({
							url: ajaxurl + "?action=deleteOpeningDay",
							type: 'POST',
							data: { "openingDayId": openingDayId },
							success: function(data) {
								console.log(data);
								if(data.success == true) {
									alert("Opening day deleted!");
									//window.location = window.location.href;
									li.remove();
								}
							},
							error: function(data) {
								
							}
						});
					});
					
					$(".popmake-edit-opening-day").click(function() {
						var id = $(this).attr("rel");
						$("#popmake-706 .gform_hidden input[type=hidden]").val(id);
						$.ajax({
							url: ajaxurl + "?action=get_openingday_details",
							type: 'POST',
							data: { "id": id },
							success: function(result) {
								console.log(result);
								if(result.success == true) {
									$("#popmake-706 .gform_hidden input[type=hidden]").val(id);
									$("#popmake-706 .popup_opening_day select").val(result.data.day);
									$("#popmake-706 .popup_opening_start select").val(result.data.start);
									$("#popmake-706 .popup_opening_end select").val(result.data.end);
								}
							},
							error: function(data) {
								alert("FAILED");
							}
						});
					});
					/*edit openning day*/
					$("#gform_12").submit(function(e){
						e.preventDefault();
						var id = $("#input_12_5").val();
						var day = $("#input_12_1").val();
						var start = $("#input_12_3").val();
						var end = $("#input_12_4").val();
						var li = $("#opening_hours_data a[rel="+id+"]").parent();
						$.ajax({
							url: ajaxurl,
							method: "post",
							data: {
								action: "editOpenningDay",
								id: id,
								start: start,
								day: day,
								end: end
							}

						})
						.done(function(data){
							$("#popmake-overlay").hide();
							$("#popmake-706").hide();
							$("#gform_ajax_spinner_12").remove();
							$("#gform_submit_button_12").attr("onclick", "");
							li.html(data);

						})
						.fail(function(){
							console.log("error");
						})
					});
					$(".popmake-edit-benefit").click(function() {
						var benefitId = $(this).attr("rel");
						$.ajax({
							url: ajaxurl + "?action=get_benefit_details",
							type: 'POST',
							data: { "benefitId": benefitId },
							success: function(result) {
								console.log(result);
								if(result.success == true) {
									if(result.data.business_pack != "Free") {
										$("#popmake-412 .gform_hidden input[type=hidden]").val(benefitId);
										$("#popmake-412 .popup_benefit_title input[type=text]").val(result.data.benefit_title);
										$("#popmake-412 .popup_benefit_area select").val(result.data.area);
										if(result.data.benefit_type == 'Main Benefit'){
											$("#popmake-412 .popup_benefit_area").hide();
										}
										else{
											$("#popmake-412 .popup_benefit_area").show();
										}
										
										$("#popmake-412 textarea").val(result.data.benefit_description);
										
										jQuery("#popmake-412 .date_exp_edit input").datepicker('destroy');
										jQuery("#popmake-412 .date_exp_edit #input_9_6").datepicker({
											minDate: 0,
											dateFormat: 'dd/mm/yy',
											defaultDate: result.data.benefit_expiration
										});
										
										jQuery("#popmake-412 .date_exp_edit #input_9_6").datepicker('setDate', result.data.benefit_expiration);
										//$("#popmake-412 .date_exp_edit input[type=text]").val(result.data.benefit_expiration);
										
										if(!$("#popmake-412 .popup_benefit_image").find(".popup_benefit_image_div").length){
											$("#popmake-412 .popup_benefit_image").append('<a href="' +result.data.benefit_image.url+ '" class="popup_benefit_image_div" target="_blank">Preview Benefit Image</a><img class="popup_benefit_image_div_src" src="'+result.data.benefit_image.url+'" style="width:100px;">');
										}else{
											$("#popmake-412 .popup_benefit_image .popup_benefit_image_div").attr('href', result.data.benefit_image.url);
											$("#popmake-754 .popup_benefit_image_div_sr").attr('src', result.data.benefit_image.url);
										}
									} else {
										if(result.data.endStr < result.data.todayStr) {
											$("#popmake-412 .gform_hidden input[type=hidden]").val(benefitId);
											$("#popmake-412 .popup_benefit_title input[type=text]").val(result.data.benefit_title);
											$("#popmake-412 .popup_benefit_area select").val(result.data.area);
											if(result.data.benefit_type == 'Main Benefit')
												$("#popmake-412 .popup_benefit_area").hide();
											else
												$("#popmake-412 .popup_benefit_area").show();
											
											$("#popmake-412 .popup_benefit_description input[type=text]").val(result.data.benefit_description);
											
											if(!$("#popmake-412 .popup_benefit_image").find(".popup_benefit_image_div").length){
												$("#popmake-412 .popup_benefit_image").append('<a href="' +result.data.benefit_image.url+ '" class="popup_benefit_image_div" target="_blank">Preview Benefit Image</a><img class="popup_benefit_image_div_src" src="'+result.data.benefit_image.url+'" style="width:100px;">');
											}
											else{
												$("#popmake-412 .popup_benefit_image .popup_benefit_image_div").attr('href', result.data.benefit_image.url);
												$("#popmake-754 .popup_benefit_image_div_sr").attr('src', result.data.benefit_image.url);
											}
										} else {
											$("#popmake-412 .popmake-close").click();
											alert("אתה יכול לערוך את ההטבה זו רק בתאריך "+result.data.benefit_end_date+" או לשדרג את החשבון שלך");							
										}
									}
								}
							},
							error: function(data) {
								alert("FAILED");
							}
						});
					});
					
					$(".start_date_message input").datepicker({
						minDate: 0,
						maxDate: "+1w",
						dateFormat: 'dd/mm/yy',
						onSelect: function(dateText) {
							$sD = new Date(dateText);
							$(".end_date_message input").datepicker('option', 'minDate', dateText);
						}
					});
					
					function readURL(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							$('.logo_preview').html('<img src="'+e.target.result+'" >');
						}

						reader.readAsDataURL(input.files[0]);
					}
					}

					$(".main-logo input").change(function(){
						readURL(this);
					})
				});
			</script>
		  </main><!-- #main -->
		</div>
	  </div><!-- #primary -->
		<div class="modal fade" id="ModalLoadBackground" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
			<img src="http://www.asus.com/support/images/support-loading.gif" alt="" style="width: 100px;" />
		</div>
<?php } } ?>
<?php get_footer(); ?>
