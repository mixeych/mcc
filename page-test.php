<pre>
<?php 
/*
* Template Name: test
*/

global $current_user;
$args = array(
    'author' => $current_user->ID,
    'posts_per_page'   => 5,
    'post_type'        => 'business'
);
$business = get_posts( $args );
$business = $business[0];
update_field("business_pack", 'Free', $business->ID);
update_user_meta($current_user->ID, 'tranzillaInfo', '');
update_post_meta($business->ID, 'messages_have', '');
//$tranz = new MCCTranzillaPayment($current_user);
//$res = $tranz->sendRecurringPayment($current_user);
//var_dump($res);

