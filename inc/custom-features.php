<?php 
function disable_access_to_dashboard(){
	if ( is_admin() && !current_user_can( 'administrator' ) && !current_user_can( 'country_manager' ) && !current_user_can('city_manager') && !current_user_can('test_role') &&! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}
add_action('init','disable_access_to_dashboard');

/*function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_city' ); 
    $admins->add_cap( 'edit_cities' ); 
    $admins->add_cap( 'edit_others_cities' ); 
    $admins->add_cap( 'publish_cities' ); 
    $admins->add_cap( 'read_city' ); 
    $admins->add_cap( 'read_private_cities' ); 
    $admins->add_cap( 'delete_city' ); 

    $admins->add_cap( 'edit_business' ); 
    $admins->add_cap( 'edit_businesses' ); 
    $admins->add_cap( 'edit_others_businesses' ); 
    $admins->add_cap( 'publish_businesses' ); 
    $admins->add_cap( 'read_business' ); 
    $admins->add_cap( 'read_private_businesses' ); 
    $admins->add_cap( 'delete_business' ); 
}
add_action( 'admin_init', 'add_theme_caps');*/

add_action('init', 'addRoleCountryCityManager');
function addRoleCountryCityManager() {
	global $wp_roles;
    if (empty($wp_roles->roles['country_manager'])) {
        $countrymanagerCaps = array(
			'read' => true,
			'edit_city' => true,
			'edit_cities' => true,
			'edit_other_cities' => true,
			'publish_cities' => true,
			'read_city' => true,
			'read_private_cities' => true,
			'delete_city' => true,
			'edit_business' => true,
			'edit_businesses' => true,
			'edit_others_businesses' => true,
			'publish_businesses' => true,
			'read_business' => true,
			'read_private_businesses' => true,
			'delete_business' => true,
		);

		add_role('country_manager', 'Country Manager', $countrymanagerCaps );
    }
    if(empty($wp_roles->roles['city_manager'])){
    	$cityManagerCaps = array(
				'read' => true,
				'edit_business' => true,
				'edit_businesses' => true,
				'edit_others_businesses' => true,
				'publish_businesses' => true,
				'read_business' => true,
				'read_private_businesses' => true,
				'delete_business' => true,
			);
    	add_role('city_manager', 'City Manager', $cityManagerCaps );
    }
    if(empty($wp_roles->roles['test_role'])){
    	$test_roleCaps = array(
                'manage_categories' => true,
                'edit_posts' => true,
                'edit_others_posts' => true,
                'edit_published_posts' => true,
                'publish_posts' => true,
                'edit_pages' => true,
                'read' => true,
                /*[level_10] => 1
                [level_9] => 1
                [level_8] => 1
                [level_7] => 1
                [level_6] => 1
                [level_5] => 1
                [level_4] => 1
                [level_3] => 1
                [level_2] => 1
                [level_1] => 1
                [level_0] => 1*/
                'edit_others_pages '=> true,
              	'edit_published_pages' => true,
                'publish_pages' => true,
                'delete_pages' => true,
                'delete_others_pages' => true,
                'delete_published_pages' => true,
                'delete_posts' => true,
                'delete_others_posts' => true,
                'delete_published_posts' => true,
                'delete_private_posts' => true,
                'edit_private_posts' => true,
                'read_private_posts' => true,
                'delete_private_pages' => true,
                'edit_private_pages' => true,
                'read_private_pages' => true,
                'delete_users' => true,
                'create_users' => true,
                'upload_files' => true,
                'unfiltered_upload' => true,
                // [edit_dashboard] => 1
                // [update_plugins] => 1
                // [delete_plugins] => 1
                // [install_plugins] => 1
                // [update_themes] => 1
                // [install_themes] => 1
                // [update_core] => 1
                'list_users' => true,
                'remove_users' => true,
                'add_users' => true,
                'edit_users' => true,
                'promote_users' => true1,
                /*[edit_theme_options] => 1
                [delete_themes] => 1
                [export] => 1
               /* [view_cimy_extra_fields] => true,*/
                /*[copy_posts] => 1*/
                /*[gravityforms_user_registration] => true
                [gravityforms_user_registration_uninstall] => true*/
                /*[manage_woocommerce] => 1
                [view_woocommerce_reports] => 1
                [edit_product] => 1
                [read_product] => 1
                [delete_product] => 1
                [edit_products] => 1
                [edit_others_products] => 1
                [publish_products] => 1
                [read_private_products] => 1
                [delete_products] => 1
                [delete_private_products] => 1
                [delete_published_products] => 1
                [delete_others_products] => 1
                [edit_private_products] => 1
                [edit_published_products] => 1
                [manage_product_terms] => 1
                [edit_product_terms] => 1
                [delete_product_terms] => 1
                [assign_product_terms] => 1
                [edit_shop_order] => 1
                [read_shop_order] => 1
                [delete_shop_order] => 1
                [edit_shop_orders] => 1
                [edit_others_shop_orders] => 1
                [publish_shop_orders] => 1
                [read_private_shop_orders] => 1
                [delete_shop_orders] => 1
                [delete_private_shop_orders] => 1
                [delete_published_shop_orders] => 1
                [delete_others_shop_orders] => 1
                [edit_private_shop_orders] => 1
                [edit_published_shop_orders] => 1
                [manage_shop_order_terms] => 1
                [edit_shop_order_terms] => 1
                [delete_shop_order_terms] => 1
                [assign_shop_order_terms] => 1
                [edit_shop_coupon] => 1
                [read_shop_coupon] => 1
                [delete_shop_coupon] => 1
                [edit_shop_coupons] => 1
                [edit_others_shop_coupons] => 1
                [publish_shop_coupons] => 1
                [read_private_shop_coupons] => 1
                [delete_shop_coupons] => 1
                [delete_private_shop_coupons] => 1
                [delete_published_shop_coupons] => 1
                [delete_others_shop_coupons] => 1
                [edit_private_shop_coupons] => 1
                [edit_published_shop_coupons] => 1
                [manage_shop_coupon_terms] => 1
                [edit_shop_coupon_terms] => 1
                [delete_shop_coupon_terms] => 1
                [assign_shop_coupon_terms] => 1
                [edit_shop_webhook] => 1
                [read_shop_webhook] => 1
                [delete_shop_webhook] => 1
                [edit_shop_webhooks] => 1
                [edit_others_shop_webhooks] => 1
                [publish_shop_webhooks] => 1
                [read_private_shop_webhooks] => 1
                [delete_shop_webhooks] => 1
                [delete_private_shop_webhooks] => 1
                [delete_published_shop_webhooks] => 1
                [delete_others_shop_webhooks] => 1
                [edit_private_shop_webhooks] => 1
                [edit_published_shop_webhooks] => 1
                [manage_shop_webhook_terms] => 1
                [edit_shop_webhook_terms] => 1
                [delete_shop_webhook_terms] => 1
                [assign_shop_webhook_terms] => 1*/
               /* [wpml_manage_translation_management] => 1
                [wpml_manage_languages] => 1
                [wpml_manage_theme_and_plugin_localization] => 1
                [wpml_manage_support] => 1
                [wpml_manage_media_translation] => 1
                [wpml_manage_navigation] => 1
                [wpml_manage_sticky_links] => 1
                [wpml_manage_string_translation] => 1
                [wpml_manage_translation_analytics] => 1
                [wpml_manage_wp_menus_sync] => 1
                [wpml_manage_taxonomy_translation] => 1
                [wpml_manage_troubleshooting] => 1
                [wpml_manage_translation_options] => 1
                [wpml_manage_woocommerce_multilingual] => 1
                [wpml_operate_woocommerce_multilingual] => 1*/
                'edit_city' => true,
                'edit_cities' => true,
                'edit_other_cities' => true,
                'publish_cities' => true,
                'read_city' => true,
                'read_private_cities' => true,
                'delete_city' => true,
                'edit_business' => true,
                'edit_businesses' => true,
                'edit_other_businesses' => true,
                'publish_businesses' => true,
                'read_business' => true,
                'read_private_businesses' => true,
                'delete_business' => true,
                'manage_bens' => true,
                'edit_businesss' => true,
                'edit_other_businesss' => true,
                'edit_others_cities' => true,
                'edit_others_businesses' => true,
    		);
		add_role('test_role', 'Test role', $test_roleCaps );
    }else{
        //remove_role( 'test_role' );
    }


}

?>