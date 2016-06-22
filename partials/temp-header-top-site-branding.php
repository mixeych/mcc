<?php
$sessStatus = session_status();
    if($sessStatus == 'PHP_SESSION_DISABLED'||$sessStatus===0 ){
        session_start();
    }
?>
<div class="site-branding">
	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php _e("My", "mycitycard"); ?><span><?php _e("City", "mycitycard"); ?></span><?php _e("Card", "mycitycard"); ?></a></h1>
	<?php
		if ( isset($_SESSION['my_cityz']) ) {
			$ccity = get_post($_SESSION['my_cityz']);
			if(get_field("active_city", $ccity) == 1) {
	?>
		<h1 class="user-location"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="orange"><?=$ccity->post_title;?></a></h1>
	<?php 
			}
		} 
	?>
</div><!-- .site-branding -->