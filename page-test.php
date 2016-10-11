<pre>
<?php 
/*
* Template Name: test
*/
global $current_user;

//update_field("business_pack", 'Free', $business[0]->ID);
//update_user_meta($current_user->ID, 'tranzillaInfo', '');
//update_post_meta($business[0]->ID, 'messages_have', '');
//$args = array(
//	'author' => $current_user->ID,
//	'posts_per_page'   => 1,
//	'post_type'        => 'business'
//    );
//    $business = get_posts( $args ); 
//$mesHave = (int)get_post_meta($business[0]->ID, 'messages_have', true);
//                    $mesHave = $mesHave+1000;
//                    update_post_meta($business[0]->ID, 'messages_have', $mesHave);
//var_dump($current_user);
//die();

wp_mail('zguchiy@gmail.com', 'Тeст', 'Содержание');