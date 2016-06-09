<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mycitycard
 */
global $current_user;
$mesId = get_the_id();
$bizId = get_post_meta($mesId, 'business', true);
$bizName = get_the_title($bizId);
$bizLink = get_permalink($bizId);
$image = get_post_meta($mesId, 'message_image', true);
$imageSrc = wp_get_attachment_image_src($image)[0];
$validThru = (int) get_post_meta($mesId, 'endDate', true);
$status = get_post_meta($mesId, 'status', true);
$classStatus = ($status == 'expired'||$status=='sold out'||$status=='disabled')?'expired':'';
$validThru = date('d/m/Y H:i:s', $validThru);
$target = get_post_meta($mesId, 'target', true);
$areaText = 'ALL MCC Holders';
if($target == 'Your city card holders'){
	$cityId = get_post_meta($mesId, 'city', true);
	$city = get_the_title($cityId);
	$areaText = $city.' card Holders';
}
$dataUs='regular';
$user_type = get_user_meta($current_user->ID, 'mcc_user_type', true);
if($current_user->caps['contributor']||$user_type=='business'){
	$dataUs='biz';
        
}else{
    reset_new_messages($current_user->ID, $mesId);
}

?>
	<div class="business_page_benefit">
	<a href="<?=$bizLink ?>">
		
			<div class="business_page_benefit_discount"><img src="<?=$imageSrc;?>" /></div>
			<div class="business_page_benefit_details">
				<div class="business_page_benefit_title"><b><?=$bizName;?></b></div>
				<div class="business_page_benefit_card"><?=$areaText?></div>
                                <?php 
                                the_content();
                                if($classStatus === 'expired'):
                                    ?>
                                <p style="color:#dc5e19" class="<?=$classStatus ?>" s><?php echo ucwords($status) ?></p>
                                <?php endif; ?>
					<p class=<?php echo $classStatus ?>>Valid through <?=$validThru?></p>
				
			</div>
        <?php if($current_user->caps['subscriber']){ ?>
			<a href="javascript:void(0)" class="business_page_benefit_fav delMessage" data-user="<?=$dataUs ?>" rel="<?=$mesId ?>"> <img src="<?php bloginfo('template_url'); ?>/images/delete_icon.png" alt="" /></a>
		<?php } ?>
	</a>
	</div>
