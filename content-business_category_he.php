<?php
/**
 * @package mycitycard
 */

global $current_user;
 
$logo = get_field("field_554775b13e29f", get_the_ID());

$likes_field = get_field("field_557d79b3d4c4b", get_the_ID());
//print_r($likes_field);

if($likes_field) {
	$like_row = "<span>" .count($likes_field). "</span> אהבו את העסק";	
	$perm_likes_class = "like_allow";
	
	foreach ($likes_field as $like) {
		if ($like["ID"] == $current_user->ID) {
			$perm_likes_class = "like_disable";
			break;
		}
	}
} else {
	$like_row = "תהיה הראשון לאהוב את זה";
	$perm_likes_class = "like_allow";
}

if ( !is_user_logged_in() )
	$perm_likes_class = "like_disable";
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?=get_permalink();?>" class="business_logo">
		<img src="<?=$logo["sizes"]["thumbnail"];?>" alt="" />
	</a>
	<div class="business_content">
		<div class="business_header">
			<?php the_title( sprintf( '<h1><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
			<div class="business_header_likes <?=$perm_likes_class?>" rel="<?php the_ID();?>"><?=$like_row;?></div>
		</div>
		<div class="business_desc"><?=get_field("field_554775a23e29e", get_the_ID());?></div>
		<? if( have_rows('benefits', get_the_ID()) ): the_row(); ?>
			<div class="business_last_benefit">
				<h2><?=the_sub_field('benefit_title');?></h2>
				<span><?=the_sub_field('benefit_description');?></span>
			</div>
		<? endif; ?>
		<a href="<?=get_permalink();?>" class="business_link">צפה בכל ההטבות של העסק</a>
	</div>
</article><!-- #post-## -->