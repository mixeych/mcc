<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mycitycard
 */
global $current_user;

$city = 'all';
if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All'){
    $city = (int) $_SESSION["my_cityz"];
}
$search = trim(strip_tags($_GET['s']));
$bizId = get_the_ID();
$bCity = get_field("bcity", $bizId);
?>


<?php if( have_rows('benefits', $bizId) ): ?>
	<?php 
        $favBens = get_favorite_benefits($bizId, $current_user->ID);
	global $search;
	while (have_rows('benefits', $bizId)) : 
		the_row();
                
		$benefitTile = html_entity_decode(get_sub_field('benefit_title'));
		$benefitContent = html_entity_decode(get_sub_field('benefit_description'));
		$posTitle = strripos($benefitTile, $search);
		$posDesc = strripos($benefitContent, $search);
		$areaText = get_sub_field('area');

		if(get_sub_field('benefit_status') == 1 && ($posTitle !== false || $posDesc !==false)) {

			if($city !='all' && $areaText != 'All MyCityCard holders' && $bCity != $city){
				continue;
			}
                        $benId = get_sub_field('benefit_id');
                        $benefitFavClass = 'addFavBenefit';
                        $starSrc = 'benefit_star.png';
                        if(is_array($favBens)){
                            foreach($favBens as $favBen){
                                if($favBen['benefit_id'] == $benId){
                                    $benefitFavClass = "FavBenefit";
                                    $starSrc = 'greenstar.png';
                                }
                            }
                        }
			
			$validThru = get_sub_field("benefit_type") == "Additional"?"Valid through ".get_sub_field('benefit_expiration'):"";
			
			
	?>
	<a href="<?php the_permalink() ?>">
		<div class="business_page_benefit">
			<div class="business_page_benefit_discount"><img src="<? echo get_sub_field('benefit_image')["url"];?>" /></div>
			<div class="business_page_benefit_details">
				<div class="business_page_benefit_title"><?=the_sub_field('benefit_title');?></div>
				<div class="business_page_benefit_card"><?=$areaText?></div>
				<p>
					<?=$benefitContent;?><br />
					<?=$validThru?>
				</p>
			</div>
                        <?php if(is_user_logged_in()): ?>
			<a href="javascript:void(0)" class="business_page_benefit_fav <?=$benefitFavClass;?>" data-business-id="<?php the_ID();?>" data-benefit-id="<?=the_sub_field('benefit_id');?>"><img src="<?php bloginfo('template_directory'); ?>/images/<?php echo $starSrc; ?>" alt="" /></a>
                        <?php endif; ?>
		</div>
	</a>
	<?php
		} 
	endwhile;
	?>
<?php endif; ?>
