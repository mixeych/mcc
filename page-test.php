<pre>
<?php 
/*
* Template Name: test
*/
global $current_user;
//update_user_meta($current_user->ID, 'tranzillaInfo', '');
$args = array(
	'author' => $current_user->ID,
	'posts_per_page'   => 1,
	'post_type'        => 'business'
);
$business = get_posts( $args ); 
update_field("business_pack", 'Free', $business[0]->ID);
update_user_meta($current_user->ID, 'tranzillaInfo', '');
update_post_meta($business[0]->ID, 'messages_have', '');
//$info = get_user_meta($current_user->ID, 'tranzillaInfo', true);
//
//$tranz = new MCCTranzillaPayment();
//$res = $tranz->sendRecurringPayment();
//var_dump($res);