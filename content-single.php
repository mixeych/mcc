<?php
/**
 * @package mycitycard
 */
 
global $current_user;
global $sitepress;
$currentLanguage = $sitepress->get_current_language();
$logo = get_field("logo", get_the_ID());

$likes_field = get_field("user_likes", get_the_ID());

if($likes_field) {
	$like_row = "<span>" .count($likes_field). "</span> People like it";	
	$perm_likes_class = "like_allow";

	foreach ($likes_field as $like) {

		if ($like == $current_user->ID) {
			$perm_likes_class = "like_disable";
			break;
		}
	}
} else {
	$like_row = "Be the first to like it";
	$perm_likes_class = "like_allow";
}

if ( !is_user_logged_in() )
	$perm_likes_class = "like_disable";

$post_id = get_the_id();
$cityID = get_field('bcity', $post_id);

$post_term = wp_get_post_terms($post_id, 'business_cat');

$postTermId = $post_term[0]->term_id;

$business_pack = get_field("business_pack", $post_id);
$businessFavoriteClass = "addFavBusiness";
$favBusinesses = get_favorite_businesses($current_user->ID);
if(!empty($favBusinesses)){
	if(is_array($favBusinesses)){
		foreach($favBusinesses as $favBiz){
			if($favBiz->business_id == $post_id){
				$businessFavoriteClass = "FavBusiness";
			}
		}
	}
}

if($business_pack == 'Free') {
?>

<div id="728_90_ad">
	<?php echo do_shortcode('[advertising id=1478]'); ?>
</div>
<?php } ?>
<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="business_page_logo">
		<?php 
			if(!empty($logo)):
				if(is_numeric($logo)){
					$logoSrc = wp_get_attachment_image_src($logo)[0];
				}else{
					$logoSrc = $logo["url"];
				}
		?>
			<img src="<?=$logoSrc ;?>" alt="" />
		<?php endif; ?>
		</div>
		<div class="business_page_title">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<div class="business_page_title_cats">
				<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
					<?php if(function_exists('bcn_display')) {
						bcn_display();
					}?>
				</div>
				<div class="business_page_likes_row"><?=$like_row;?></div>
			</div>
		</div>
		<div class="business_page_social">
			<a href="mailto:yourmail@test.com?subject=Share&body=<?php the_permalink(); ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/email_icon.png" alt="" /></a>
			<?php 
			$short_link = wp_get_shortlink(); 
			$bizTitle = get_the_title();
			$bCity = get_post_meta($post_id, 'bcity', true);
                        $iclCityId = icl_object_id($bCity, 'city', true);
			$ciytName = get_the_title($iclCityId);
			$content = "Click to watch $bizTitle benefits in $ciytName $short_link";
			?>
			<a target="_blank" href="https://twitter.com/home?status=<?= $content ?>"><img src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" alt="" /></a>
			<a target="_blank" href="#" onclick="
  window.open(
    'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 
    'facebook-share-dialog', 
    'width=626,height=436'); 
    return false;"><img src="<?php bloginfo('template_directory'); ?>/images/fb_icon.png" alt="" /></a>
			<a href="javascript:void(0)" class="<?=$businessFavoriteClass?>" rel="<?=$post_id;?>"><img src="<?php bloginfo('template_directory'); ?>/images/fav_icon.png" alt="" /></a>
			<a href="javascript:void(0)" class="<?=$perm_likes_class?>" rel="<?=$post_id;?>"><img src="<?php bloginfo('template_directory'); ?>/images/like_it_icon.png" alt="" /></a>
		</div>
		<div class="business_page_desc"><?=get_field("field_554775a23e29e", $post_id);?></div>
	</header><!-- .entry-header -->
	<div class="business_page_info">
		<div class="business_page_info_left_side">
		<?php 
			$main_photo = get_field("main_photo", $post_id);
			if(is_numeric($main_photo)){
				$main_photo =  wp_get_attachment_image_src($main_photo)[0];
			}else{
				$main_photo = $main_photo["url"];
				
			}
		?>
			<div class="business_page_info_image"><img src="<?php echo $main_photo ?>" ></div>
			<?php if($business_pack != 'Free') { ?>
			<ul>
				<li><img src="<?php echo $main_photo ?>" ></li>
			    <?php 
					for($i=1; $i<5; $i++){
						$add_photo = get_field("photo_".$i, $post_id);
						if(is_numeric($add_photo)){
							$add_photo = wp_get_attachment_image($add_photo);
							if(!empty($add_photo)){
								echo "<li>".$add_photo."</li>";
							}
						}else{
							if(!empty($add_photo)){
								$add_photo = $add_photo["url"];
								echo "<li><img src='".$add_photo."' /></li>";
							}
						}
					}
				?>
			</ul>
			<?php } 
			if($business_pack == 'Free'){
			 ?>
				<div class="business_page_info_ad">
				<?php echo do_shortcode('[advertising id=1481]'); ?>
				</div>
			<?php } ?>
		</div>

<script type="text/javascript">

function addMap(){
	var button = document.getElementsByClassName("business_page_info_map_button");
	button = button[0];
	button.addEventListener("click", initMap);
}

function initMap() {
	var lat, lng;
	var address ='<?=get_field("address", $post_id);?>';
	var adrArr = address.split(' ');
	var content = '<? the_title() ?>';

	var query = '<?=get_field("field_554775683e29a", $post_id);?>';
	var url = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
	for(var i=0; i<adrArr.length; i++){
		url += adrArr[i]+'+';
	}
	url += '&key=AIzaSyAekAAvMNofkQmmU7Az1YThH1TlokfVaxA';
	jQuery.ajax({
		url: url
	}).done(function(data){
		if(data.status =="OK"){
			lat = data.results[0].geometry.location.lat;
			lng = data.results[0].geometry.location.lng;
			var popup = document.getElementById('popmake-1360');
			popup = popup.getElementsByClassName("popmake-content");
			popup = popup[0];
		    var map = new google.maps.Map(popup, {
			    center: {lat: lat, lng: lng},
			    zoom: 17,
		  	});
		  	var marker = new google.maps.Marker({
		    map: map,
		    place: {
		      location: {lat: lat, lng: lng},
		      query: query

		    },
		    attribution: {
		      source: 'Google Maps JavaScript API',
		      webUrl: 'https://developers.google.com/maps/'
		    }
			});

			// Construct a new InfoWindow.
			var infoWindow = new google.maps.InfoWindow({
			   content: content
			});
			infoWindow.open(map, marker);
			

		}
	})

}

 </script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCADlHmeh7hB7hKIT4WMakfTMmNqUSdU8o&callback=addMap"
  type="text/javascript"></script>
		<div class="business_page_info_right_side">
			<div class="business_page_info_address popmake-google-map">
				<p><?=get_field("field_554775683e29a", $post_id);?></p>
				<a target="_blank" href="https://www.google.com/maps/place/<?=get_field("field_554775683e29a", $post_id);?>" class="business_page_info_map_button"></a>
				
			</div>
			<div class="business_page_info_more_details">
				<p><?=get_field("field_5547753a3e298", $post_id);?></p>
				<p class="ohours">
				<?php
					$opening_hours = get_field("opening_hours", $post_id);
					if($opening_hours){
						foreach($opening_hours as $row){
							echo $row['day']." <span>".$row['start'].' - '.$row['end'].'</span><br />';
						}
					}
				?>
				</p>
			<?php if($business_pack != 'Free'): 
				$homepage = get_field("homepage", $post_id);
				$facebook = get_field("facebook_page", $post_id);
				if(!empty($homepage)):
                                    if($currentLanguage == 'en'):
			?>
				<a href="<?=get_field("homepage", $post_id);?>" target="_blank">Home page</a><br />
				<?php
                                    else: ?>
                                    <a href="<?=get_field("homepage", $post_id);?>" target="_blank">דף הבית</a><br />
                                    <?php
                                    endif;
				endif;
				if(!empty($facebook)):
				
                                    if($currentLanguage == 'en'):
			?>
				<a href="<?=get_field("facebook_page", $post_id);?>" target="_blank">Facebook page</a>
                                <?php else: ?>
                                <a href="<?=get_field("facebook_page", $post_id);?>" target="_blank"> דף פייסבוק</a>
				<?php endif; endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="business_page_benefits_warp">
		<?php if( have_rows('benefits', $post_id) ): ?>
			<?php 
			$i = 0;
			$favBens = get_favorite_benefits($post_id, $current_user->ID);
			while (have_rows('benefits', $post_id)) : the_row(); 
			  $benefitType = get_sub_field('benefit_type');
			    if($business_pack != 'Premium' && $benefitType=='Additional'){
			    	continue;
			    }
				if(get_sub_field('benefit_status') == 1) {
					$i++;
					if($i==1){
                                            if($currentLanguage == 'en'){
						echo '<div class="business_page_benefits_title"><b>Business Benefits:</b></div>';
                                            }else{
                                                echo '<div class="business_page_benefits_title"><b>הטבות של העסק</b></div>';
                                            }
                                        }
					$benId = get_sub_field('benefit_id');
					$benefitFavClass = 'addFavBenefit';
					if(is_array($favBens)){
						foreach($favBens as $favBen){
							if($favBen['benefit_id'] == $benId){
								$benefitFavClass = "FavBenefit";
							}
						}
					}
					$benId = get_sub_field('benefit_id');
					$validThru = get_sub_field("benefit_type") == "Additional"?"Valid through ".get_sub_field('benefit_expiration'):"";
					$benefitType = get_sub_field("benefit_type");
					$areaText = get_sub_field('area');
                                        if($currentLanguage == 'he'){
                                            if($areaText == 'ALL MCC Holders'){
                                                 $areaText = ' כל מחזיקי כרטיס MyCityCard';
                                            }else{
                                                $areaText ='  למחזיקי כרטיס'.$ciytName;
                                            }
                                        }

			?>
				<div class="business_page_benefit <?php if($benefitType == 'Main Benefit'){echo 'main';} ?>">
					<div class="business_page_benefit_discount"><img src="<?php echo get_sub_field('benefit_image')["url"];?>" /></div>
					<div class="business_page_benefit_details">
						<div class="business_page_benefit_title"><?=the_sub_field('benefit_title');?></div>
						<div class="business_page_benefit_card"><?=$areaText?></div>
						<p>
							<?=the_sub_field('benefit_description');?><br />
							<?=$validThru?>
						</p>
					</div>
<?php
    $bizBenImgSrc = '/images/benefit_star.png';
    if($benefitFavClass == 'FavBenefit'){
        $bizBenImgSrc = '/images/greenstar.png';
    }
?>
					<a href="javascript:void(0)" class="business_page_benefit_fav <?=$benefitFavClass;?>" data-business-id="<?php echo $post_id; ?>" data-benefit-id="<?=the_sub_field('benefit_id');?>"><img src="<?php bloginfo('template_directory'); ?><?php echo $bizBenImgSrc ?>" alt="" /></a>
				</div>
			<?php
				} 
			endwhile;
			?>
		<?php endif; ?>
	</div>
        <?php 
            $addinfo = get_field("additional_info", $post_id);
            $addInfo = str_replace("\n", "<br>", $addinfo );
            if(!empty($addinfo)):
        ?>
	<div class="business_page_benefits_warp">
            <?php if($currentLanguage=='en'): ?>
            <div class="business_page_benefits_title"><b>About</b></div>
            <?php else: ?>
            <div class="business_page_benefits_title"><b>אודות העסק</b></div>
            <?php endif; ?>
		<?php
			
			echo $addInfo;
		?>
	</div>
        <?php endif; ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".business_page_info_left_side ul li").click(function() {
				this_img = $(this).find("img").attr("src");
				$(".business_page_info_image img").attr("src", this_img);
			});
			
			
			

			//Update likes button
			$(".like_allow").on('click', function() {
				business_id = $(this).attr("rel");
				thisBiz = $(this);
				var count = +$(".business_page_likes_row span").text();
				if(!count){
					count = 0;
				}
				console.log(count);
				$.ajax({
					url: ajaxurl + "?action=update_business_likes",
					type: 'POST',
					data: { "bid" : business_id },
					success: function(data) {
						if(data.success == true) {

							thisBiz.removeClass("like_allow");
							thisBiz.addClass("like_disable");
							count++;
							$(".business_page_likes_row span").text(count);
						}
					},
					error: function(data) {
						console.log("FAILED");
					}
				});
			});

		});
	</script>
</article><!-- #post-## -->
<div id="google-map" style="width:500px; height: 500px; display:none" ></div>
