<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package mycitycard
 */

if ( ! is_active_sidebar( 'sidemenu-widgets' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidemenu-widgets' ); ?>
</div><!-- #secondary -->
