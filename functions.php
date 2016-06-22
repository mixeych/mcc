<?php
/**
 * mycitycard functions and definitions
 *
 * @package mycitycard
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

add_theme_support( 'post-thumbnails' );

if ( ! function_exists( 'mycitycard_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mycitycard_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on mycitycard, use a find and replace
	 * to change 'mycitycard' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'mycitycard', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'mycitycard' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'mycitycard_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // mycitycard_setup
add_action( 'after_setup_theme', 'mycitycard_setup' );

/*
* Disable update plugins
*/

function filter_plugin_updates( $update ) {    
    global $DISABLE_UPDATE; // look in wp-config.php
    if( !is_array($DISABLE_UPDATE) || count($DISABLE_UPDATE) == 0 ){  return $update;  }
    if(!is_array($update)){
        return $update;
    }
    foreach( $update->response as $name => $val ){
        foreach( $DISABLE_UPDATE as $plugin ){
            if( stripos($name,$plugin) !== false ){
                unset( $update->response[ $name ] );
            }
        }
    }
    return $update;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function mycitycard_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'mycitycard' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'HeaderSearchWidgets', 'mycitycard' ),
		'id'            => 'header-search-widgets',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'HeaderCityWidgets', 'mycitycard' ),
		'id'            => 'header-city-widgets',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'SidemenuWidgets', 'mycitycard' ),
		'id'            => 'sidemenu-widgets',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'AdsWidgets', 'mycitycard' ),
		'id'            => 'ads-widgets',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'TopBar', 'mycitycard' ),
		'id'            => 'topbar',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          =>  'Social Login',
		'id'            => 'social-login',
		'description'   => 'Social Login sidebar',
	) );
	register_sidebar( array(
		'name'          => __( 'TopBar', 'mycitycard' ),
		'id'            => 'topbar',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'mycitycard_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mycitycard_scripts() {
	wp_enqueue_style( 'mycitycard-style', get_stylesheet_uri() );

	wp_enqueue_script( 'mycitycard-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_style( 'datetimepickercss', get_template_directory_uri().'/js/datetimepicker-master/jquery.datetimepicker.css' );


	wp_enqueue_script( 'mycitycard-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	wp_deregister_script( 'jquery' );
	//wp_enqueue_script('jquery');
	//wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-2.2.2.min.js');
	wp_register_script( 'jquery', "https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js");
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script('datetimepicker',  get_template_directory_uri() . '/js/datetimepicker-master/build/jquery.datetimepicker.full.min.js', array('jquery') );

	wp_enqueue_script( 'mycitycard-main', get_template_directory_uri() . '/js/main.js', array('jquery', 'datetimepicker'), true );
	wp_enqueue_script( 'mycitycard-front', get_template_directory_uri() . '/js/front.js', array('jquery'), true );
}
add_action( 'wp_enqueue_scripts', 'mycitycard_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
*	Add theme options menu page
*/
require get_template_directory() . '/inc/theme-settings.php';

/**
* Add theme custom roles and another features
*/

require get_template_directory() . '/inc/shortcodes.php';
/**
 * create cusom shortcodes
 */

require get_template_directory() . '/inc/custom-features.php';
/*
 * Tranzilla Class
 */
require get_template_directory() . '/inc/Tranzilla.class.php';


add_action('init', 'add_mcc_tables');
function add_mcc_tables(){
	global $wpdb;
	if (!isset($wpdb->termmeta)) {
		$wpdb->termmeta = $wpdb->prefix.'termmeta';
	}
	if (!isset($wpdb->termvisiblepost_relationships)) {
		$wpdb->termvisiblepost_relationships = $wpdb->prefix.'termvisiblepost_relationships';
	}
	if (!isset($wpdb->ben_favorites)) {
		$wpdb->ben_favorites = $wpdb->prefix.'ben_favorites';
	}
	if (!isset($wpdb->biz_favorites)) {
		$wpdb->biz_favorites = $wpdb->prefix.'biz_favorites';
	}
	if (!isset($wpdb->promotions)) {
		$wpdb->promotions = $wpdb->prefix.'promotions';
	}
	if(!isset($wpdb->delivered_messages)){
		$wpdb->delivered_messages = $wpdb->prefix.'delivered_messages';
	}
	if(!isset($wpdb->new_messages)){
		$wpdb->new_messages = $wpdb->prefix.'new_messages';
	}
	$table_name = $wpdb->prefix.'termvisiblepost_relationships';
	$query = "CREATE TABLE IF NOT EXISTS $wpdb->new_messages(
    			rel_id BIGINT (20) AUTO_INCREMENT,
                user_id BIGINT (20) NOT NULL,
                message_id BIGINT (20) NOT NULL,
                PRIMARY KEY(rel_id) )";
        $wpdb->query($query);
	$query = "CREATE TABLE IF NOT EXISTS $wpdb->delivered_messages(
    			rel_id BIGINT (20) AUTO_INCREMENT,
                user_id BIGINT (20) NOT NULL,
                message_id BIGINT (20) NOT NULL,
                PRIMARY KEY(rel_id) )";
    $wpdb->query($query);
    $query = "CREATE TABLE IF NOT EXISTS $wpdb->promotions(
    			promo_id BIGINT (20) AUTO_INCREMENT,
                business_id BIGINT (20) NOT NULL,
                promo_city VARCHAR(255) NULL,
                promo_area VARCHAR(255) NULL,
                PRIMARY KEY(promo_id) )";
    $wpdb->query($query);
    /*$query = "CREATE TABLE IF NOT EXISTS $wpdb->biz_favorites(
                user_id BIGINT (20) NOT NULL,
                business_id BIGINT (20) NOT NULL,
                rel_id INT(250) AUTO_INCREMENT,
                PRIMARY KEY(rel_id) )";
    $wpdb->query($query);*/

    define('TABLE_TERMVISPOST_RELATIONSHIP', $table_name);
}
// Our custom post type function
function create_discount_posttype() {
	register_post_type( 'discount',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Discounts' ),
				'singular_name' => __( 'Discount' )
			),
			'public' => true,
			'featured_image' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'discount'),
			'taxonomies' => array('category', 'location'),
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		)
	);
}


// Hooking up our function to theme setup
add_action( 'init', 'create_discount_posttype' );

function create_advert_posttype(){
	register_post_type( 'advertising',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Advertising' ),
				'singular_name' => __( 'Advertising' )
			),
			'public' => true,
			'featured_image' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'advertisng'),
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		)
	);
}

add_action('init', 'create_advert_posttype');

function create_message_posttype(){
	register_post_type( 'message',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Message' ),
				'singular_name' => __( 'Message' )
			),
			'public' => false,
			'featured_image' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'message'),
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		)
	);
}

add_action('init', 'create_advert_posttype');

function create_undelivered_poststatus(){
	register_post_status( 
		'undelivered', 
		array(
			'label'                     => _x( 'Undelivered', 'post' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
		)
	);
}

add_action('init', 'create_undelivered_poststatus');

function advert_shortcode($atts){
	if(!isset($atts['id'])){
		return "<div id='ad-1'></div><div id='ad-2'></div><div id='ad-3'></div><div id='ad-4'></div>";
	}
	$adv = get_post($atts['id']);
	if(!$adv){
		return '';
	}
	if($adv->post_type != 'advertising'){
		return '';
	}
	$img = get_the_post_thumbnail($atts['id'], 'full');
	$output = "<div>".$img."</div>";

	return $output;
}
add_shortcode('advertising', 'advert_shortcode');

function add_id_column($attr){
	$attr['post_id'] = 'ID';
	return $attr;
}

add_filter('manage_advertising_posts_columns', 'add_id_column');

function custom_id_column( $column, $post_id ) {
    if($column == 'post_id'){
    	echo $post_id;
    }
}

add_action( 'manage_advertising_posts_custom_column' , 'custom_id_column', 10, 2 );

function create_discount_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Locations', 'taxonomy general name' ),
		'singular_name'     => _x( 'Location', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Locations' ),
		'all_items'         => __( 'All Locations' ),
		'parent_item'       => __( 'Parent Location' ),
		'parent_item_colon' => __( 'Parent Location:' ),
		'edit_item'         => __( 'Edit Location' ),
		'update_item'       => __( 'Update Location' ),
		'add_new_item'      => __( 'Add New Location' ),
		'new_item_name'     => __( 'New Location Name' ),
		'menu_name'         => __( 'Locations' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'location' )
	);

	register_taxonomy( 'location', array( 'discount' ), $args );
}
add_action( 'init', 'create_discount_taxonomies', 0 );


add_filter( 'gform_pre_render_3', 'get_businesses_cats' );
add_filter( 'gform_pre_validation_3', 'get_businesses_cats' );
add_filter( 'gform_pre_submission_filter_3', 'get_businesses_cats' );
add_filter( 'gform_admin_pre_render_3', 'get_businesses_cats' );
add_filter( 'gform_pre_render_10', 'get_businesses_cats' );
add_filter( 'gform_pre_validation_10', 'get_businesses_cats' );
add_filter( 'gform_pre_submission_filter_10', 'get_businesses_cats' );
add_filter( 'gform_admin_pre_render_10', 'get_businesses_cats' );
function get_businesses_cats( $form ) {

    foreach ( $form['fields'] as &$field ) {
        if ( $field->type == 'select' && $field->id == 1) {
			global $current_user;
			$args = array(
				'author' => $current_user->ID,
				'posts_per_page'   => 5,
				'offset'           => 0,
				'category'         => '',
				'category_name'    => '',
				'orderby'          => 'date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => 'business',
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => 'publish',
				'suppress_filters' => true 
			);
			$business = get_posts( $args ); 
			$business = $business[0];
			$business_cats = get_the_terms($business->ID, "business_cat");
			
			$args = array(
				'type'                     => 'business',
				'child_of'                 => 0,
				'parent'                   => 0,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'business_cat',
				'pad_counts'               => false 

			); 
			
			$categories = get_categories($args);

			$field->choices = array();
			foreach($categories as $post) {
				$select = '';
				if($business_cats){
					foreach($business_cats as $bcat) {
						if($post->term_id == $bcat->term_id)
							$select = 1;
					}
				}
				$iclId = icl_object_id($post->term_id, 'business_cat', true, 'en');				
				$field->choices[] = array( 'text' => $post->name, 'value' => $iclId, 'isSelected' => $select );
			}

			global $sitepress;

			$current_language = $sitepress->get_current_language();
			if($current_language == "en")
				$field->placeholder = 'Select a Category';
			
			if($current_language == "he")
				$field->placeholder = 'בחר קטגוריה';
		}
		if($field->type == 'select' && ($field->id == 4 || $field->id == 7 || $field->id == 6)){
			
			$args = array(
				'author' => $current_user->ID,
				'posts_per_page'   => 5,
				'offset'           => 0,
				'category'         => '',
				'category_name'    => '',
				'orderby'          => 'date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => 'business',
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => 'publish',
				'suppress_filters' => true 
			);
			$business = get_posts( $args ); 
			$business = $business[0];
			$business_cats = get_the_terms($business->ID, "business_cat");

			$parentId = $business_cats[0]->term_id;
			$args = array(
				'type'                     => 'business',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'taxonomy'                 => 'business_cat',
				'parent' 					=>	$parentId,
				'pad_counts'               => false 

			); 
			$categories = get_categories($args);
			$select = 0;
                        array_splice($field->choices, 1);
			foreach ($categories as $cat){
                                
				if($cat->parent != '0'){

//					if($business_cats){
//						foreach($business_cats as $bcat) {
//
//							if($cat->term_id == $bcat->term_id){
//								$select = 1;
//								break;
//							}
//						}
//					}

					$iclId = icl_object_id($cat->term_id, 'business_cat', true, 'en');
                                        
					$field->choices[] = array( 'text' => $cat->name, 'value' => $cat->term_id, 'isSelected' => $select );

				}
			}
		}
    }

    return $form;
}



// Business Page Tab - Category
function get_sub_businesses_cats() {
	header("Content-type:application/json"); 
	$parent_cat = $_POST["pcatid"];
	if($parent_cat > 0) {
		$args = array(
			'type'                     => 'business',
			'child_of'                 => 0,
			'parent'                   => $parent_cat,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'business_cat',
			'pad_counts'               => false 

		); 
		
		$subCats = get_categories($args);
		$choices = array();

		foreach ( $subCats as $post ) {
			$choices[] = array( 'text' => $post->name, 'value' => $post->term_id );
		}

		if(empty($choices)) {
			global $sitepress;

			$current_language = $sitepress->get_current_language();
			if($current_language == 'en')
				$choices[] = array( 'text' => "Sub Categories Not Found", 'value' => '' );
			
			if($current_language == 'he')
				$choices[] = array( 'text' => "תתי קטגוריות לא נמצאו במערכת", 'value' => '' );
		}
		
		echo json_encode($choices);
		die();
	}
}
add_action( 'wp_ajax_nopriv_get_sub_businesses_cats',  'get_sub_businesses_cats' );
add_action( 'wp_ajax_get_sub_businesses_cats', 'get_sub_businesses_cats' );

add_action( 'wp_ajax_getSubCat', 'getSubCat' );

function getSubCat(){
	global $current_user;
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args );
	$post_terms = wp_get_post_terms($business[0]->ID, 'business_cat');
	$output = array();
	foreach ($post_terms as $term){
		if($term->parent !== 0){
			$output[] = $term->term_id;
		}
	}
	echo json_encode(array("success" => true, "result" => $output)); die();
	die();
}
// Business Page Tab - Get logo
function get_business_logo() {
	header("Content-type:application/json"); 
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	if($business) {
		$logo = get_field("field_554775b13e29f", $business[0]->ID);
		if($logo['url'] != home_url().'/wp-content/uploads/2015/08/logo-temp.jpg' ){
			echo json_encode(array("logo" => $logo["sizes"]["thumbnail"]));
			die();
		}else{
			echo json_encode(array("res" => "error"));
			die();
		}
		
	}
}
add_action( 'wp_ajax_nopriv_get_business_logo',  'get_business_logo' );
add_action( 'wp_ajax_get_business_logo', 'get_business_logo' );


// Business Page Tab - Add Opening Day
function addOpeningDay() {
	//header("Content-type:application/json"); 
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	if($business) {
		$opening_hours = get_field("opening_hours", $business[0]->ID);
		if(!empty($opening_hours)){
			foreach($opening_hours as $day)
				$newOpeningHour[] = array("id" => $day["id"], "day" => $day["day"], "start" => $day["start"], "end" => $day["end"]);
		}
		$newId = uniqid();
		$newOpeningHour[] = array("id" => $newId, "day" => $_POST["openingDay"], "start" => $_POST["openingDayStart"], "end" => $_POST["openingDayEnd"]);
		update_field("opening_hours", $newOpeningHour, $business[0]->ID);
		?>
		<li class="added-<?php echo $newId; ?>"><a href="javascript:void(0)" class="openingDayDelete" rel="<?=$newId?>"><img src="<?php bloginfo('template_directory'); ?>/images/delete_icon.png" alt="" /></a><a href="javascript:void(0)" class="popmake-edit-opening-day" rel="<?=$newId?>"><i class="fa fa-pencil-square-o"></i></a><?=$_POST["openingDay"]." ".$_POST["openingDayStart"]." - ".$_POST["openingDayEnd"];?></li>
		<script>
			jQuery("li.added-<?php echo $newId; ?> .openingDayDelete").click(function(e) {
						e.preventDefault();
						var openingDayId = jQuery(this).attr("rel");
						var li = jQuery(this).parent();
						jQuery.ajax({
							url: ajaxurl + "?action=deleteOpeningDay",
							type: 'POST',
							data: { "openingDayId": openingDayId },
							success: function(data) {
								console.log(data);
								if(data.success == true) {
									alert("Opening day deleted!");
									//window.location = window.location.href;
									li.remove();
								}
							},
							error: function(data) {
								
							}
						});
					});
		</script>
		<?php
		//echo json_encode(array("success" => true));
		die();
	}
}
add_action( 'wp_ajax_nopriv_addOpeningDay',  'addOpeningDay' );
add_action( 'wp_ajax_addOpeningDay', 'addOpeningDay' );

// Business Page Tab - Delete Opening Day
function deleteOpeningDay() {
	header("Content-type:application/json"); 
	global $current_user;
	
	
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	if($business) {
		$opening_hours = get_field("opening_hours", $business[0]->ID);
		
		foreach($opening_hours as $day) {
			if($day["id"] != $_POST["openingDayId"])
				$newOpeningHour[] = array("id" => $day["id"], "day" => $day["day"], "start" => $day["start"], "end" => $day["end"]);
		}
		
		update_field("opening_hours", $newOpeningHour, $business[0]->ID);
		echo json_encode(array("success" => true));
		die();
	}
}
add_action( 'wp_ajax_nopriv_deleteOpeningDay',  'deleteOpeningDay' );
add_action( 'wp_ajax_deleteOpeningDay', 'deleteOpeningDay' );

// Get Opening Day Details

function get_openingday_details(){
	header("Content-type:application/json"); 
	global $current_user;

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 

	if($business) {
		$business = $business[0];
			$days = get_field('opening_hours', $business->ID);
			if(empty($days)){
				return json_encode(array("success" => false));
			}
			foreach($days as $day) {
				if($_POST["id"] == $day["id"])
					$currentDay = $day;
			}

			echo json_encode(array("success" => true, "data" => array("day" => $currentDay["day"], "start" => $currentDay["start"], "end" => $currentDay["end"])));die();
	}
}

add_action( 'wp_ajax_nopriv_get_openingday_details',  'get_openingday_details' );
add_action( 'wp_ajax_get_openingday_details', 'get_openingday_details' );

//add_action("gform_post_submission_12", "update_openingday_popup", 10, 2);
function update_openingday_popup($entry, $form){
	//print_r($entry);
	global $current_user;

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	
	if($business) {
		$business = $business[0];
		$opening_hours = get_field("opening_hours", $business->ID);
		$newOpeningHour = array();
		foreach($opening_hours as $day){
			if($day['id'] == $entry[5]){
				$newOpeningHour[] = array("id" => $day["id"], "day" => $entry[1], "start" => $entry[3], "end" => $entry[4]);
			}else{
				$newOpeningHour[] = array("id" => $day["id"], "day" => $day["day"], "start" => $day["start"], "end" => $day["end"]);
			}
		}
		update_field("opening_hours", $newOpeningHour, $business->ID);
	}
}

/*
* Edit openning day
*/
add_action( 'wp_ajax_nopriv_editOpenningDay',  'edit_openning_day' );
add_action( 'wp_ajax_editOpenningDay', 'edit_openning_day' );
function edit_openning_day(){
	global $current_user;

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$day_id = $_POST['id'];
	$start = $_POST['start'];
	$new_day = $_POST['day'];
	$end = $_POST['end'];
	$business = get_posts( $args ); 
	if($business) {
		$business = $business[0];
		$opening_hours = get_field("opening_hours", $business->ID);
		$newOpeningHour = array();
		foreach($opening_hours as $day){
			if($day['id'] == $day_id){
				$newOpeningHour[] = array("id" => $day["id"], "day" => $new_day, "start" => $start, "end" => $end);
			}else{
				$newOpeningHour[] = array("id" => $day["id"], "day" => $day["day"], "start" => $day["start"], "end" => $day["end"]);
			}
		}
		update_field("opening_hours", $newOpeningHour, $business->ID);
	}
	?>
	<a href="javascript:void(0)" class="openingDayDelete" rel="<?=$day_id?>"><img src="<?php bloginfo('template_directory'); ?>/images/delete_icon.png" alt="" /></a><a href="javascript:void(0)" class="popmake-edit-opening-day" rel="<?=$day_id?>"><i class="fa fa-pencil-square-o"></i></a><?=" ".$new_day." ".$start." - ".$end;?>
	<?php
	die();
}


// Update Business Details
add_action("gform_post_submission_2", "update_business_details", 10, 2);
function update_business_details($entry, $form){
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	

	$my_post = array(
		'ID'           => $business[0]->ID,
		'post_title'   => $entry[16]
	);
	wp_update_post( $my_post );
	
	// Update LTD / INC
	update_field("field_5547749c3e294", $entry[2], $business[0]->ID);
	
	// Update Your Name
	update_field("field_554774c73e296", $entry[3], $business[0]->ID);
	
	// Update Family Name
	update_field("field_554775223e297", $entry[4], $business[0]->ID);
	
	// Update Phone
	update_field("field_5547753a3e298", $entry[9], $business[0]->ID);
	
	// Update Email
	update_field("field_554775513e299", $entry[8], $business[0]->ID);
	
	// Update Desciption
	update_field("field_554775a23e29e", nl2br($entry[7]), $business[0]->ID);
	
	// Update address
	update_field("address", $entry[17], $business[0]->ID);

	$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
	$addArr = explode(' ', $entry[17]);
	foreach($addArr as $val){
		$url .= $val.'+';
	}
	$url .= '&key=AIzaSyAekAAvMNofkQmmU7Az1YThH1TlokfVaxA';
	$geocode = file_get_contents($url);
	$output = json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	
	update_field("lat", $latitude, $business[0]->ID);
	update_field("lon", $longitude, $business[0]->ID);
		
		
	// Update Role
	update_field("business_role", $entry[13], $business[0]->ID);
	
	// Update Business
	update_field("business_phone", $entry[11], $business[0]->ID);
	
	// Update Business 2
	update_field("business_phone_2", $entry[12], $business[0]->ID);

	// Update Logo 
	// Create attachment from image

	if($entry[10]) {

		if (function_exists('jdn_create_image_id')) $image_id = jdn_create_image_id($entry[10], $business[0]->ID);
		if ($image_id) {
			update_field("field_554775b13e29f", $image_id, $business[0]->ID);
		}
	}

}


// Update Business Category
add_action("gform_post_submission_3", "update_business_category", 10, 2);
add_action("gform_post_submission_10", "update_business_category", 10, 2);
function update_business_category($entry, $form){
	global $wpdb;
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 

	$cat_array = array();
	$cat_array[] = $entry[1];
	if($entry[4])
		$cat_array[] = $entry[4];

	if($entry[7])
		$cat_array[] = $entry[7];

	if($entry[6])
		$cat_array[] = $entry[6];
        $visPost = get_post_meta($business[0]->ID, 'visibility', true);
	$res = wp_set_post_terms($business[0]->ID, $cat_array, 'business_cat');
}

add_action('set_object_terms', 'mccChangeVisiblePostsTerm', 10, 6);
function mccChangeVisiblePostsTerm($object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids){
    if($taxonomy != 'business_cat'){
        return;
    }
    $isVisible = get_post_meta($object_id, 'visibility', true);
    if(empty($isVisible)){
        return;
    }
    foreach($old_tt_ids as $oldTTid){
        delete_visible_post($object_id, $oldTTid);
    }
    foreach($tt_ids as $newTTid){
        add_visible_post($object_id, $newTTid);
    }
}

// Update Likes Count
function update_business_likes() {
	header("Content-type:application/json"); 
	global $current_user;
	$bizId = (int) trim(strip_tags($_POST['bid']));
	if(is_user_logged_in()) {
		$likes_field = get_post_meta($bizId, "user_likes", true);

		if(empty($likes_field)){
			$likes_field = array();
		}

		if(in_array($current_user->ID, $likes_field)){
			echo json_encode(array("success" => false, "message" => 'You already liked')); die();
		}
		$likes_field[] = $current_user->ID;		
		if(update_post_meta($bizId, "user_likes", $likes_field)) {
			echo json_encode(array("success" => true)); die();
		} else {
			echo json_encode(array("success" => false, "message" => "error")); die();
		}
	} else {
		echo "FU";die();
	}
}

add_action( 'wp_ajax_update_business_likes', 'update_business_likes' );





//==================== Custom Post Type - Business ===================

// Register Custom Post Type
function custom_post_type_business() {

	$labels = array(
		'name'                => _x( 'Businesses', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Business', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Business', 'text_domain' ),
		'name_admin_bar'      => __( 'Business', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Businesses', 'text_domain' ),
		'add_new_item'        => __( 'Add New Business', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Business', 'text_domain' ),
		'edit_item'           => __( 'Edit Business', 'text_domain' ),
		'update_item'         => __( 'Update Business', 'text_domain' ),
		'view_item'           => __( 'View Business', 'text_domain' ),
		'search_items'        => __( 'Search Business', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' )
	);
	$args = array(
		'label'               => __( 'Business', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'          => array( 'business_cat' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-store',
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => array('business', 'businesses'),
		'map_meta_cap' => false
	);
	register_post_type( 'business', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_business', 0 );

function create_business_taxomony() {
	register_taxonomy(
		'business_cat',
		'business',
		array(
			'label' => __( 'Business Categories' ),
			'hierarchical' => true,  
            'query_var' => true
		)
	);
}
add_action( 'init', 'create_business_taxomony');






// Register Custom Post Type
function custom_post_type_cities() {

	$labels = array(
		'name'                => _x( 'Cities', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'City', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'City', 'text_domain' ),
		'name_admin_bar'      => __( 'City', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Cities', 'text_domain' ),
		'add_new_item'        => __( 'Add New City', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New City', 'text_domain' ),
		'edit_item'           => __( 'Edit City', 'text_domain' ),
		'update_item'         => __( 'Update City', 'text_domain' ),
		'view_item'           => __( 'View City', 'text_domain' ),
		'search_items'        => __( 'Search City', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' )
	);
	$args = array(
		'label'               => __( 'City', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'          => array( 'countries' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-store',
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => array('city', 'cities')
	);
	register_post_type( 'city', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type_cities', 0 );

function create_country_taxomony() {
	register_taxonomy(
		'countries',
		'city',
		array(
			'label' => __( 'All Countries' ),
			'hierarchical' => true,  
            'query_var' => true
		)
	);
}
add_action( 'init', 'create_country_taxomony');


//* Load Font Awesome
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
}
//============================================================

/*add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {

	$user = new WP_User( $user_id );
	print_r($user);
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role )
			echo $role;
	}

}*/


add_filter( 'gform_pre_render_6', 'register_pre_form' );
add_filter( 'gform_pre_validation_6', 'register_pre_form' );
add_filter( 'gform_pre_submission_filter_6', 'register_pre_form' );
add_filter( 'gform_admin_pre_render_6', 'register_pre_form' );
function register_pre_form( $form ) {
    foreach ( $form['fields'] as &$field ) {
        if ( $field->type == 'select' && $field->id == 5) {
			$args = array(
				'type'                     => 'business',
				'hide_empty'               => 0,
				'taxonomy'                 => 'business_cat',
			); 
			
			$categories = get_categories($args);

			$choices = array();

			foreach ( $categories as $post ) {
				if($post->parent == '0'){
					$iclId = icl_object_id($post->term_id, 'business_cat', true, 'en');
					$choices[] = array( 'text' => $post->name, 'value' => $iclId );
				}
			}

			global $sitepress;

			$current_language = $sitepress->get_current_language();
			if($current_language == "en")
				$field->placeholder = 'Select a category';
			
			if($current_language == "he")
				$field->placeholder = 'בחר קטגוריה';
			$field->choices = $choices;
		}
		
		
        if ( $field->type == 'select' && $field->id == 6) {
			$args = array(
				'posts_per_page'   => -1,
				'order'   => 'ASC',
				'post_type'        => 'city',
				'suppress_filters' => false
			);
			$cities = get_posts( $args ); 

			$choices = array();

			foreach ( $cities as $city ) {
				$iclId = icl_object_id($city->ID, 'city', true, 'en');
				$choices[] = array( 'text' => $city->post_title, 'value' => $iclId );
			}

			$field->placeholder = 'Select a city';
			
			$field->choices = $choices;
		}
    }

    return $form;
}

add_action( 'gform_after_submission_6', 'new_post_business_register', 10, 2 );
function new_post_business_register( $entry, $form ) {
	$editor = false;
	$user = get_user_by_email( $entry['10'] );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role ){
			if($role == "contributor") $editor = true;
		}
	}

	if($editor) {
		// Create post object
		$my_post = array(
		  'post_title'    => $entry[2],
		  'post_status'   => 'publish',
		  'post_type'     => 'business',
		  'post_author'   => $user->ID
		  //'post_category' => array(8,39)
		);
		
		// Insert the post into the database
		$post_id = wp_insert_post( $my_post, $wp_error );
		//echo $post_id;
		
		$cat_array = array();
		$cat_array[] = $entry[5];

		// update category
		wp_set_post_terms( $post_id, $cat_array, 'business_cat');
		update_user_meta($user->ID, 'mcc_user_type', 'business');
		// Update City 
		update_field("city", $entry[6], "user_".$user->ID);
		
		update_field("bcity", $entry[6], $post_id);
		
		// Update LTD / INC
		update_field("field_5547749c3e294", $entry[3], $post_id);
		
		// Update Your Name
		update_field("field_554774c73e296", $entry[4], $post_id);
		
		// Update Family Name
		update_field("field_554775223e297", $entry[7], $post_id);
		
		// Update Phone
		update_field("field_5547753a3e298", $entry[13], $post_id);
		
		// Update Email
		update_field("field_554775513e299", $entry[10], $post_id);
		
		//Update Address  
		update_field("field_554775683e29a", $entry[9], $post_id);
		
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
		$addArr = explode(' ', $entry[9]);
		foreach($addArr as $val){
			$url .= $val.'+';
		}
		$url .= '&key=AIzaSyAekAAvMNofkQmmU7Az1YThH1TlokfVaxA';
		$geocode = file_get_contents($url);
		$output = json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		
		update_field("lat", $latitude, $post_id);
		update_field("lon", $longitude, $post_id);
		
		
		// Update Business Email  
		update_field("field_554775c23e2a0", $entry[10], $post_id);
		
		
		update_field("business_pack", "Free", $post_id);
		
		//update_field("logo", 640, $post_id);
		
		//update_field("main_photo", 684, $post_id);
		
		$to = $entry['10'];
		$subject = 'Activation Link';
		$body = home_url().'?activate_hash='.md5($user->data->user_email."_".$user->data->display_name).'&user_id='.$user->ID;
		$headers = array('Content-Type: text/html; charset=UTF-8');

		wp_mail( $to, $subject, $body, $headers );
	} else {
		echo "Not Contributor";
	}
}


function add_current_city_to_list($bizId){
	$cityId = get_post_meta($bizId, 'bcity', true);
	update_post_meta($cityId, 'active_city', '1');
}

function remove_current_city_form_list($bizId){
	$cityId = get_post_meta($bizId, 'bcity', true);
	update_post_meta($cityId, 'active_city', '0');
}

add_action( 'gform_after_submission_11', 'additional_info_submit', 10, 2 );
function additional_info_submit( $entry, $form ) {

	global $current_user;

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	
	if($business) {
		$business = $business[0];

		update_field("additional_info", $entry[1], $business->ID);
	}
}
function check_user_auth(){
    if(!is_user_logged_in()){
        session_start();
        $_SESSION['redirect'] = get_permalink();
        wp_redirect(wp_login_url(get_permalink()));
    }
}

add_action( 'login_errors', function( $error ) {
	global $errors;
	$err_codes = $errors->get_error_codes();

	if ( in_array( 'invalid_username', $err_codes ) ) {
            $redirect = home_url('/log-in/?user=invalid');
	}
        if ( in_array( 'incorrect_password', $err_codes ) ) {
            $redirect = home_url('/log-in/?user=invalid');
        }
        echo "<script>window.location.href='".$redirect."';</script>";
	return $error;
} );

function my_login_redirect( $url, $request, $user ){
    session_start();
    if(!isset($_SESSION['redirect'])){
        $url = home_url();
    }else{
        $url = $_SESSION['redirect'];
    }
    return $url;
}

add_filter('login_redirect', 'my_login_redirect', 10, 3 );

add_action('wsl_hook_process_login_after_wp_insert_user', 'activateSocialLoggedInUsers', 10, 3);
function activateSocialLoggedInUsers($user_id, $provider, $hybridauth_user_profile){
    update_field("active_user", 1, "user_".$user_id);
}

function do_on_login($login, $user) {
    $sessStatus = session_status();
    if($sessStatus == 'PHP_SESSION_DISABLED'||$sessStatus===0 ){
        session_start();
    }
    
    if(get_field("active_user", "user_".$user->ID) != 1){
        wp_logout();
        $redirect = '/log-in/?user=notactivated';
        wp_redirect($redirect);
        die();
    }
    $userCityID = get_user_meta($user->ID, 'city', true);
    if(!$userCityID){
        $_SESSION['action'] = '!city';
    }else{
        $active = get_post_meta($userCityID, 'active_city', true);
        if(empty($active)){

            $_SESSION['action'] = 'city not active';
        }
    }
    $user_ID = $user->ID;

    $_SESSION['my_cityz'] = get_field("field_56680b158ee8c", "user_".$user_ID)->ID;
}
add_action('wp_login', 'do_on_login', 10, 2);

function enqueue_popup_city(){
    wp_enqueue_script('cityscript', get_template_directory_uri() . '/js/citychoosing.js', array('jquery'), true );
}

function checkAction(){
    if(!is_user_logged_in()){
        return;
    }
    if(isset($_SESSION['action'])&&$_SESSION['action'] === 'city not active'){
        $_SESSION['action'] = '';
        add_action('wp_enqueue_scripts', 'enqueue_popup_script');
    }
    if(isset($_SESSION['action'])&&$_SESSION['action'] === '!city'){
        $_SESSION['action'] = '';
        add_action('wp_enqueue_scripts', 'enqueue_popup_city');
    }
    return;
}
add_action('init', 'checkAction');

add_action( 'lost_password', 'redirect_to_custom_lostpassword' );
function redirect_to_custom_lostpassword() {
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
		wp_redirect( home_url( 'lost' ) );
		exit;
	}
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$errors = retrieve_password();
		if ( is_wp_error( $errors ) ) {
			// Errors found
			$redirect_url = home_url( 'lost' );
			$redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
		} else {
			// Email sent
			$redirect_url = home_url('lost');
			$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
		}

		wp_redirect( $redirect_url );
		exit;
	}
}

add_action( 'login_form_rp', 'redirect_to_custom_password_reset');
add_action( 'login_form_resetpass', 'redirect_to_custom_password_reset');

function redirect_to_custom_password_reset(){
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
		// Verify key / login combo
		$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
		if ( ! $user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				wp_redirect( home_url( 'lost?login=expiredkey' ) );
			} else {
				wp_redirect( home_url( 'lost?login=invalidkey' ) );
			}
			exit;
		}

		$redirect_url = home_url( 'lost' );
		$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
		$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

		wp_redirect( $redirect_url );
		exit;
	}
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$rp_key = $_REQUEST['rp_key'];
		$rp_login = $_REQUEST['rp_login'];

		$user = check_password_reset_key( $rp_key, $rp_login );

		if ( ! $user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				wp_redirect( home_url( 'lost?login=expiredkey' ) );
			} else {
				wp_redirect( home_url( 'lost?login=invalidkey' ) );
			}
			exit;
		}

		if ( isset( $_POST['pass1'] ) ) {
			if ( $_POST['pass1'] != $_POST['pass2'] ) {
				// Passwords don't match
				$redirect_url = home_url( 'lost' );

				$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
				$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

			if ( empty( $_POST['pass1'] ) ) {
				// Password is empty
				$redirect_url = home_url( 'lost' );

				$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
				$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
				$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

				wp_redirect( $redirect_url );
				exit;
			}

			// Parameter checks OK, reset password
			reset_password( $user, $_POST['pass1'] );
			wp_redirect( home_url( 'lost?password=changed' ) );
		} else {
			$redirect_url = home_url( 'lost' );

			$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
			$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
			$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
			wp_redirect( $redirect_url );
		}

		exit;
	}
}

function update_city_cookie() {
	header("Content-type:application/json"); 
	session_start();

	$_SESSION['my_cityz'] = $_POST["mcityz"];
	
	echo json_encode(array("success" => true, "hi" => $_SESSION['my_cityz']));die();
}

add_action( 'wp_ajax_nopriv_update_city_cookie',  'update_city_cookie' );
add_action( 'wp_ajax_update_city_cookie', 'update_city_cookie' );


function update_business_gallery() {
	//header("Content-type:application/json"); 
	$photo_id = $_POST["photo_id"];
	$business_id = $_POST["business_id"];
	
	//Upload la photo dans le dossier
	require_once(ABSPATH.'wp-admin/includes/file.php');
	$uploadedfile = $_FILES["file"];

	$movefile = wp_handle_upload($uploadedfile, array('test_form' => false));

	//On sauvegarde la photo dans le média library
	if ($movefile) {
		$wp_upload_dir = wp_upload_dir();
		$guid = $wp_upload_dir['url'].'/'.basename($movefile['file']);
		$attachment = array(
		'guid' => $guid,
		'post_mime_type' => $movefile['type'],
		'post_title' => preg_replace('/\.[^.]+$/', '', basename($movefile['file'])),
		'post_content' => '',
		'post_status' => 'inherit'
		);	
		$attach_id = wp_insert_attachment($attachment, $movefile['file']);

		// generate the attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );

		// update the attachment metadata
		wp_update_attachment_metadata( $attach_id,  $attach_data );		
				
		if(update_field($photo_id, $attach_id, $business_id)) {
			echo $guid;
			die();
		} else {
			echo 'error';
			die();
		}
	} else {
		echo 'error';
		die();
	}
}

add_action( 'wp_ajax_nopriv_update_business_gallery',  'update_business_gallery' );
add_action( 'wp_ajax_update_business_gallery', 'update_business_gallery' );

function delete_additional_photo(){
	$photoId = $_POST['photoId'];
	$bizId = $_POST['bizId'];
	$res = update_field('photo_'.$photoId, '', $bizId);
	echo $res;
	die();
}
add_action( 'wp_ajax_nopriv_deleteAdditionalPhoto',  'delete_additional_photo' );
add_action( 'wp_ajax_deleteAdditionalPhoto', 'delete_additional_photo' );




function business_links_update() {
	header("Content-type:application/json");
	update_field("facebook_page", $_POST["fb"], $_POST["business_id"]);
	
	update_field("homepage", $_POST["homepage"], $_POST["business_id"]);
	
	echo json_encode(array("success" => true));die();
}

add_action( 'wp_ajax_nopriv_business_links_update',  'business_links_update' );
add_action( 'wp_ajax_business_links_update', 'business_links_update' );

function additional_info_update() {
	header("Content-type:application/json"); 
	
	$update = update_field("additional_info", $_POST["additional_info"], $_POST["business_id"]);
	if($update){
		echo json_encode(array("success" => true));die();
	} else {
		echo json_encode(array("success" => false));die();
	}
}

add_action( 'wp_ajax_nopriv_additional_info_update',  'additional_info_update' );
add_action( 'wp_ajax_additional_info_update', 'additional_info_update' );



function jdn_create_image_id( $image_url, $parent_post_id = null ) {
	
	if( !isset( $image_url ) )
		return false;

	// Cache info on the wp uploads dir
	$wp_upload_dir = wp_upload_dir();
	// get the file path
	$path = parse_url( $image_url, PHP_URL_PATH );

	// File base name
	$file_base_name = basename( $image_url );

	// Full path
	if( site_url() != home_url() ) {
		$home_path = dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) );
	} else {
		$home_path = dirname( dirname( dirname( dirname( __FILE__ ) ) ) );
	}

	$home_path = untrailingslashit( $home_path );
	$uploaded_file_path = $home_path . $path;
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( $file_base_name, null );

	if( !empty( $filetype ) && is_array( $filetype ) ) {
		$post_title = preg_replace( '/\.[^.]+$/', '', $file_base_name );
	
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $uploaded_file_path ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => esc_attr( $post_title ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
	
		if( !is_null( $parent_post_id ) )
			$attachment['post_parent'] = $parent_post_id;
		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $uploaded_file_path );
		
		if( !is_wp_error( $attach_id ) ) {
			if( file_exists( ABSPATH . 'wp-admin/includes/image.php') && file_exists( ABSPATH . 'wp-admin/includes/media.php') ) {
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file_path );
				wp_update_attachment_metadata( $attach_id, $attach_data );
			} 
		}

		return $attach_id; 

	} else {
		return false;
	} 
}

// Add Benefit

//add_action("gform_post_submission_7", "add_benefit_popup", 10, 2);

add_action("wp_ajax_addAddbenefit", "add_benefit_popup");
function add_benefit_popup(){
	//header("Content-type:application/json"); 
	global $current_user;
	
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	$cityId = get_user_meta($current_user->ID, 'city', true);
	$city = get_the_title($cityId);
	$benefitArea = $_POST['benefitArea'];
	$benefitTitle = $_POST['benefitTitle'];
	$benefitDesc = $_POST['benefitDesc'];
	$expDate = $_POST['expDate'];
	if($benefitArea == '%city% card holders exclusive'){
		$area = str_replace('%city%', $city, $benefitArea);
	}else{
		$area = $benefitArea;
	}
	if($business) {
		$business = $business[0];
		if(!empty($_FILES[0])){
			$uploadDir = wp_upload_dir();
			$uploadDir = $uploadDir['path'];
			$uploadFile = $uploadDir.'/'.$_FILES[0]['name'];
			if(!move_uploaded_file($_FILES[0]['tmp_name'], $uploadFile)){
				$image_id  = 653;
			}
			if (function_exists('jdn_create_image_id')){
				$image_id = jdn_create_image_id($uploadFile, $business->ID);
			}
		}else{
			$image_id  = 653;
		}
		if ($image_id) {
			if(have_rows('benefits', $business->ID)){
				$publishDate = date("d/m/Y");
				$benefitId = uniqid();
				$benefit = array(
					'benefit_id' => $benefitId,
					'benefit_title'	=> $benefitTitle,
					'area' => $area,
					'benefit_description' => $benefitDesc,
					'benefit_image'		=> $image_id,
					'benefit_publish_date' => $publishDate,
					'benefit_end_date' => date("d/m/Y", strtotime("+30 days")),
					'benefit_expiration' => $expDate,
					'benefit_type' => "Additional",
					'benefit_status' => 1
				);
				add_row("benefits", $benefit, $business->ID);
				$benPhoto = wp_get_attachment_image_src($image_id)[0];
				
				$row = "<tr class='active'>
							<td><a href='' class='benefitDelete' rel='".$benefitId."'><img src='".get_bloginfo('template_directory')."/images/delete_icon.png' alt='' /></td>
							<td>Active</td>
							<td>
								<span class='ben-title' style='text-decoration:underline; cursor:pointer;''>".$benefitTitle."</span>
								
								<span class='ben-desc' style='display:none;'>".$benefitDesc."</span>
							</td>
							<td>".$publishDate."</td>
							<td>".$expDate."</td>
							<td>".$area."</td>
							<td><a href='' class='popmake-edit-additional-benefit businessTableButton' rel='".$benefitId."'>Change</a><a href='' rel='".$benefitId."' class='benefitStatusAction businessTableButton additional'>Stop</td>

						</tr>
						<tr class='drop-down' style='display:none'><td colspan='9'><div class='info clearfix'><img src='".$benPhoto."' /><span class='desc'>".$benefitDesc."</span></div></td></tr>";
                                 $time = time();
                                update_post_meta($business->ID, 'benefit_created_at', $time);
				echo json_encode(array("success" => true, "main" => false, "row" => $row));
				die();
			}else{
				$benefit = array(
					'benefit_id' => uniqid(),
					'benefit_title'	=> $benefitTitle,
					'area' => $area,
					'benefit_description' => $benefitDesc,
					'benefit_image'		=> $image_id,
					'benefit_publish_date' => date("d/m/Y"),
					'benefit_end_date' => date("d/m/Y", strtotime("+30 days")),
					'benefit_type' => "Main Benefit",
					'benefit_status' => 1
				);
				update_field("field_557d71226236f", array($benefit), $business->ID);
                                $time = time();
                                update_post_meta($business->ID, 'benefit_created_at', $time);
				echo json_encode(array("success" => true, "main" => true));
				die();
			}	
		}
	
	}
}

add_action("gform_post_submission_13", "add_main_benefit_popup", 10, 2);
function add_main_benefit_popup($entry, $form){		
	//header("Content-type:application/json");
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	$cityId = get_user_meta($current_user->ID, 'city', true);
	$city = get_the_title($cityId);
	if($business) {
		$business = $business[0];
		if(!empty($entry[3])){
			if (function_exists('jdn_create_image_id')){
				$image_id = jdn_create_image_id($entry[3], $business->ID);
			} 
		}else{
			$image_id  = 653;
		}
		if ($image_id) {
			$benefit = array(
				'benefit_id' => uniqid(),
				'benefit_title'	=> $entry[1],
				'area' => $city.' card holders exclusive',
				'benefit_description' => $entry[4],
				'benefit_image'		=> $image_id,
				'benefit_publish_date' => date("d/m/Y"),
				'benefit_expiration' => date("d/m/Y", strtotime("+30 days")),
				'benefit_type' => "Main Benefit",
				'benefit_status' => 1
			);
			update_field("field_557d71226236f", array($benefit), $business->ID);
                        $time = time();
                        update_post_meta($business->ID, 'benefit_created_at', $time);
		}
	}
}


// Update Benefit Status

function update_benefit_status() {
	header("Content-type:application/json"); 
	global $current_user;

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 

	if($business) {
		$business = $business[0];
		if(have_rows('benefits', $business->ID)){
			$newStatus = $_POST["currentStatus"] == "Stop"?0:1;
			while( have_rows('benefits', $business->ID) ) {
				the_row();
				if(get_sub_field("benefit_id") == $_POST["benefitId"]) {
					$newDate = false;
					update_sub_field('benefit_status', $newStatus);
					if(get_sub_field('benefit_type') == "Main Benefit"){
						if(empty($newStatus)){
							update_post_meta($business->ID, 'visibility', '0');
						}else{

							update_post_meta($business->ID, 'visibility', '1');
						}
					}else{
						if(!empty($newStatus)){
							$oldDate = get_sub_field('benefit_expiration');
							if($oldDate){
								$arr = explode('/', $oldDate);
								$oD = $arr[1].'/'.$arr[0].'/'.$arr[2];
								$tSmp = strtotime($oD);
								$cT = time();
								if($tSmp < $cT){
									$newDate = $cT+2592000; // 1 month
									$newDate = date('d-m-Y', $newDate);
									update_sub_field('benefit_expiration', $newDate);
								}
							}
						}
					}

					echo json_encode(array("success" => true, "newDate" => $newDate));die();
					break;
				}
			}	
		}
	}
}

//add_action( 'wp_ajax_nopriv_update_benefit_status',  'update_benefit_status' );
add_action( 'wp_ajax_update_benefit_status', 'update_benefit_status' );

function prolong_benefit_expdate($date){

}

add_filter( 'gform_pre_render_17', 'cahngeCityDropDown' );
add_filter( 'gform_admin_pre_render_17', 'cahngeCityDropDown' );

function cahngeCityDropDown($form){
    foreach ( $form['fields'] as &$field ) {
        if ( $field->type == 'select' && $field->id == 1){
            $args = array(
                'posts_per_page'   => -1,
                'order'   => 'ASC',
                'post_type'        => 'city',
                'suppress_filters' => false
            );
            $cities = get_posts( $args ); 
            $choices = array();
            foreach ( $cities as $city ) {
                $iclId = icl_object_id($city->ID, 'city', true, 'en');
                $choices[] = array( 'text' => $city->post_title, 'value' => $iclId );
            }
            $field->placeholder = 'Select a city';
            $field->choices = $choices;
        }
    }

    return $form;
}

add_action("gform_post_submission_17", "saveRegularUserCity", 10, 2);
function saveRegularUserCity($entry, $form){
    global $current_user;
    update_user_meta($current_user->ID, 'city', $entry[1]);
}

// Add Notification Message

add_filter( 'gform_pre_render_8', 'change_availabel_messages_number' );
// add_filter( 'gform_pre_validation_8', 'change_availabel_messages_number' );
// add_filter( 'gform_pre_submission_filter_8', 'change_availabel_messages_number' );
add_filter( 'gform_admin_pre_render_8', 'change_availabel_messages_number' );

function change_availabel_messages_number($form){
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args );
	$business = $business[0];
	foreach ($form["fields"] as &$field) {
		if($field->id == 12){
			$number = 0;
			$messages_have = get_post_meta($business->ID, 'messages_have', true);
			if(!empty($messages_have)){
				$number = $messages_have;
			}
			$field->description = "You have <p style='text-decoration:underline;'><a href='".get_permalink(1866)."' target='_blanc'><span class='message-number'>".$number."</span> message remaining in the bank. Purchase additional message in a bargain price. </a></p>";
		}
	}
	return $form;
}

function change_date_to_timestamp($date){
	$arr = explode(' ', $date);
	if(empty($arr)){
		return false;
	}
	$arrD = explode('/', $arr[0]);
	if(empty($arrD)){
		return false;
	}
	if(count($arrD) == 3){
		$out = $arrD[1].'/'.$arrD[0].'/'.$arrD[2];
		$time = $arr[1];
		$out .= $time;
		return strtotime($out);
	}else{
		return false;
	}
}

add_action("wp_ajax_editMessage", "editMessageDate");
function editMessageDate(){
	$id = trim(strip_tags($_POST['id']));
	if(empty($id)){
		echo json_encode(array("success" => false));
		die();
	}
	$endDate = trim(strip_tags($_POST['endDate']));
	if(empty($endDate)){
		echo json_encode(array("success" => false));
		die();
	}

	$newDate = change_date_to_timestamp($endDate);
	if(!$newDate){
		echo json_encode(array("success" => false));
	}
	update_post_meta($id, 'endDate', $newDate);
	$newDate = date('d/m/Y  H:i:s', $newDate);
	echo json_encode(array("success" => true, "newDate" => $newDate));
	die();
}

function isBusinessInFavorite($userId, $bizId){
    $userId = (int) $userId;
    $bizId = (int) $bizId;
    global $wpdb;
    $query = "SELECT rel_id FROM {$wpdb->biz_favorites} WHERE user_id = $userId AND business_id = $bizId";
    $res = $wpdb->get_var($query);
    return $res;
}

add_action("wp_ajax_addMessage", "add_notification_message_popup");
function add_notification_message_popup(){
	global $current_user;
        global $wpdb;
        
	$args = array(
            'author' => $current_user->ID,
            'posts_per_page'   => 5,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'business',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => true 
	);
	$business = get_posts( $args );
	if($business) {
		$business = $business[0];
		$messages_have = (int) get_post_meta($business->ID, 'messages_have', true);
		$amount = (int) trim(strip_tags($_POST['amount']));
		if(empty($messages_have)||$messages_have < $amount ){
                    echo json_encode(array("success" => false));
                    die();
		}
		if(!empty($_FILES[0])){
                    $uploadDir = wp_upload_dir();
                    $uploadDir = $uploadDir['path'];
                    $uploadFile = $uploadDir.'/'.$_FILES[0]['name'];
                    if(!move_uploaded_file($_FILES[0]['tmp_name'], $uploadFile)){
                            $image_id  = 653;
                    }
                    if (function_exists('jdn_create_image_id')){
                            $image_id = jdn_create_image_id($uploadFile, $business->ID);
                    }
		}else{
                    $image_id  = 653;
		}

		$details = trim(strip_tags($_POST['details']));
		$matches = trim(strip_tags($_POST['matches']));
		$target = trim(strip_tags($_POST['target']));
		$meters = trim(strip_tags($_POST['meters']));
		$startDate = trim(strip_tags($_POST['startDate']));
		$endDate = trim(strip_tags($_POST['endDate']));
		$startDate = change_date_to_timestamp($startDate);
		$city = get_post_meta($business->ID, 'bcity', true);
		if(!$startDate){
                    echo json_encode(array("success" => false, "message" => "bad date format"));
		}

		$endDate = change_date_to_timestamp($endDate);
		if(!$endDate){
                    echo json_encode(array("success" => false, "message" => "bad date format"));
		}
                switch($matches){
                    case 'From 40% Discount': $alert_rate_new_benefits =array('From 10% Discount', 'From 20% Discount', 'From 30% Discount', 'From 40% Discount', 'All');
                        break;
                    case 'From 30% Discount': $alert_rate_new_benefits = array('From 10% Discount', 'From 20% Discount', 'From 30% Discount', 'All');
                        break;
                    case 'From 20% Discount': $alert_rate_new_benefits = array('From 10% Discount', 'From 20% Discount', 'All');
                        break;
                    case 'From 10% Discount': $alert_rate_new_benefits =array('From 10% Discount', 'All');
                        break;
                    default : $alert_rate_new_benefits = array('From 10% Discount', 'From 20% Discount', 'From 30% Discount', 'From 40% Discount', 'All');
                }

		$args = array(
                    'post_type'     => 'message',
                    'post_author'   => $current_user->ID,
                    'post_title'    => 'Message title',
                    'post_content'  => $details,
                    'post_status' => 'publish',
		);

		$post_id = wp_insert_post( $args, true );
		if( is_wp_error( $post_id ) ){
                    echo json_encode(array("success" => false));
                    die();
		}
                
		if(!empty($meters)){
                    update_post_meta($post_id, 'meters', $meters);
		}

		update_post_meta($post_id, 'message_image', $image_id);

		update_post_meta($post_id, 'business', $business->ID);
		
		update_post_meta($post_id, 'matches', $matches);
		
		update_post_meta($post_id, 'startDate', $startDate);
		update_post_meta($post_id, 'endDate', $endDate);
		update_post_meta($post_id, 'target', $target);
		update_post_meta($post_id, 'undelivered', '1');
		update_post_meta($post_id, 'status', 'active');
		update_post_meta($post_id, 'count_targeted', '0');
		update_post_meta($post_id, 'amount', $amount);
               /*
                * add message to user
                */
                $currentTime = time();
                $monthAgo = $currentTime - 2592000;
                if($target == 'Your city card holders'){
                    $city = get_post_meta($business->ID, 'bcity', true);
                    update_post_meta($post_id, 'city', $city);
                    /*
                     * get users that added biz to favorite
                     */
                    $MCCMessageTargetedUser = $amount;
                    $query = "SELECT fav.user_id FROM {$wpdb->biz_favorites} AS fav, {$wpdb->usermeta} AS meta WHERE fav.user_id = meta.user_id AND meta.meta_key = 'city' AND meta.meta_value = '$city' AND business_id = $business->ID LIMIT $MCCMessageTargetedUser";
                    $favUsers = $wpdb->get_results($query);
                    $deliveredUsers = array();
                    foreach($favUsers as $user){
                        add_message_to_user($user->user_id, $post_id);
                        $deliveredUsers[] = $user->user_id;
                        if(function_exists('sendPushNotificationsASPN')){
                            sendPushNotificationsASPN($user->ID);
                        }
                        if(function_exists('sendPushNotificarionsAndroid')){
                            sendPushNotificarionsAndroid($user->ID);
                        }
                        $MCCMessageTargetedUser--;
                    }
                    if($MCCMessageTargetedUser > 0){
                        $args = array(
                            'role' => 'subscriber',
                            'meta_query' => array(
                                array(
                                        'key' => 'alert_rate_new_benefits',
                                        'value' => $alert_rate_new_benefits,
                                        'compare' => 'IN',
                                ),
                                array(
                                    'key' => 'city',
                                    'value' => $city
                                ),
                                array(
                                    'key' => 'loginTime',
                                    'value' => $monthAgo,
                                    'type'    => 'numeric',
                                    'compare' => '>=',
                                ),
                            ),
                            'exclude' => $deliveredUsers,
                            'showposts' => $MCCMessageTargetedUser,
                            'meta_key' => 'loginTime',
                            'orderby'  => 'meta_value_num',
                        );
                        $users = get_users($args);
                        foreach($users as $user){
                            add_message_to_user($user->ID, $post_id);
                            if(function_exists('sendPushNotificationsASPN')){
                                sendPushNotificationsASPN($user->ID);
                            }
                            if(function_exists('sendPushNotificarionsAndroid')){
                                sendPushNotificarionsAndroid($user->ID);
                            }
                        }
                    }
		}else{
                    $lat = get_post_meta($business->ID, 'lat', true);
                    $lon = get_post_meta($business->ID, 'lon', true);
                    $latlng = $lat.','.$lon;
                    $args = array(
                        'role' => 'subscriber',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                    'key' => 'alert_rate_new_benefits',
                                    'value' => $alert_rate_new_benefits,
                                    'compare' => 'IN',
                            ),
                            array(
                                'key' => 'mcc_current_location',
                                'value' => '',
                                'compare' => '!='
                            ),
                            array(
                                'key' => 'loginTime',
                                'value' => $monthAgo,
                                'type'    => 'numeric',
                                'compare' => '>=',
                            ),
                        ),
                        'meta_key' => 'loginTime',
                        'orderby'  => 'meta_value_num',
                        'showposts' => $amount

                    );
                    $users = get_users($args);
                    
                    foreach ($users as $usr){
                        $userLocation = get_user_meta($usr->ID, 'mcc_current_location', true);

                        $arr1 = explode(',', $userLocation);
                        $ulat = $arr1[0];
                        $ulng = $arr1[1];
                        $distance = distance($ulat, $ulng, $lat, $lon);

                        $distance = $distance * 1000;
                        if($distance <= $meters){
                            add_message_to_user($usr->ID, $post_id);
                                if(function_exists('sendPushNotificationsASPN')){
                                sendPushNotificationsASPN($usr->ID);
                            }
                            if(function_exists('sendPushNotificarionsAndroid')){
                                sendPushNotificarionsAndroid($usr->ID);
                            }
                        }
                    }
                    update_post_meta($post_id, 'location', $latlng);
                    
		}
                $messages_have = $messages_have - $amount;
		$newMessagesHave = $messages_have;
		update_post_meta($business->ID, 'messages_have', $newMessagesHave);
                /*
                 * prepeare output
                 */
                if(strlen($details) > 30){
                    $shortDesc = substr($details, 0, 30);
                    $shortDesc .= '...';
		}else{
                    $shortDesc = $details;
		}
		$messageSrc = wp_get_attachment_image_src($image_id)[0];
                $areaText = 'ALL MCC Holders';
		if($target == 'Your city card holders'){
                    $cityTitle = get_the_title($city);
                    $areaText = $cityTitle.' card Holders';
		}
                $startDate = date('d/m/Y H:i:s', $startDate);
		$endDate = date('d/m/Y  H:i:s', $endDate);
                $countTargeted = get_post_meta($post_id, 'count_targeted', true);
                $output = "<tr class='active'>
						<td><a href='javascript:void(0)' class='messageDelete' rel='".$post_id."'><img src='".get_bloginfo('template_directory')."/images/delete_icon.png' alt='' /><span style='display:none' class='target'>".$target."</span><span style='display:none' class='matches'>".$matches."</span><span style='display:none' class='meters'>".$meters."</span></td>
						<td>Active</td>
						<td class='content' style='text-decoration:underline; cursor:pointer;'><span class='details'>$shortDesc</span></td>
						<td>$startDate</td>
						<td>$endDate</td>
						<td>$areaText</td>
						<td>$amount</td>
						<td>$countTargeted</td>
						<td class='messagesLastCell'><a href='javascript:void(0)' rel='".$post_id."' class='messageAction businessTableButton'>Stop</a><a href='javascript:void(0)' class='businessTableButton extDuration' rel='".$post_id."'>Extend Duration</a><a href='javascript:void(0)' class='businessTableButton soldOut' rel='".$post_id."'>Sold Out</a></td>
					</tr>
					<tr class='drop-down' style='display:none'>
						<td colspan='9'>
							<div class='info clearfix'>
								<img src='$messageSrc' />
								
								<? } ?>
								<span class='desc'>$details</span>
							</div>
						</td>
					</tr>";
            echo json_encode(array("success" => true, "messageHave" => $newMessagesHave, 'row' => $output ));
            die();
	}else{
            echo json_encode(array("success" => false));
            die();
	}
}

add_action('init', 'recieve_message');
function recieve_message(){

	global $current_user;
	if(!in_array('subscriber', $current_user->roles)){
		return;
	}
	$userCity = get_user_meta($current_user->ID, "city", true);
	$userLocation = get_user_meta($current_user->ID, 'mcc_current_location', true);
	$alert_rate_new_benefits = get_field('alert_rate_new_benefits', 'user_'.$current_user->ID);
	$compare = 'IN';
	
        switch($alert_rate_new_benefits){
            case 'From 40% Discount': $alert_rate_new_benefits = array('From 40% Discount');
                break;
            case 'From 30% Discount': $alert_rate_new_benefits = array('From 30% Discount', 'From 40% Discount');
                break;
            case 'From 20% Discount': $alert_rate_new_benefits = array('From 20% Discount', 'From 30% Discount', 'From 40% Discount');
                break;
            case 'From 10% Discount': $alert_rate_new_benefits = array('From 10% Discount', 'From 20% Discount', 'From 30% Discount', 'From 40% Discount');
                break;
            default : $alert_rate_new_benefits = array('From 10% Discount', 'From 20% Discount', 'From 30% Discount', 'From 40% Discount');
            
        }
	$currentDate = time();
	$args = array(
		'post_type' => 'message',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'matches',
				'value' => $alert_rate_new_benefits,
				'compare' => $compare,
			),
			array(
				'key' => 'city',
				'value' => $userCity
			),
			array(
				'key' => 'startDate',
				'value' => $currentDate,
				'compare' => '<='
			),
			array(
				'key' => 'undelivered',
				'value' => '1'
			),
			array(
				'key' => 'status',
				'value' => 'active'
			),

		),
		'showposts' => -1,
	);
	$messages = get_posts($args);
	if(!empty($messages)){
		foreach($messages as $message){
			add_message_to_user($current_user->ID, $message->ID);
		}
	}
	if(!empty($userLocation)){
		$args = array(
			'post_type' => 'message',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'matches',
					'value' => $alert_rate_new_benefits,
					'compare' => $compare,
				),
				array(
					'key' => 'target',
					'value' => 'Clients near to the business'
				),
				array(
					'key' => 'startDate',
					'value' => $currentDate,
					'compare' => '<='
				),
				array(
					'key' => 'undelivered',
					'value' => '1'
				),
				array(
					'key' => 'status',
					'value' => 'active'
				),
			),
			'showposts' => -1,
		);
		$messages = get_posts($args);
		if(!empty($messages)){
			foreach($messages as $message){

				$latlng = get_post_meta($message->ID, 'location', true);
				$arr = explode(',', $latlng);
				$lat = $arr[0];
				$lng = $arr[1];
				$arr1 = explode(',', $userLocation);
				$ulat = $arr1[0];
				$ulng = $arr1[1];
				$distance = distance($ulat, $ulng, $lat, $lng);
				$meters = (int) get_post_meta($message->ID, 'meters', true);
				if($distance <= $meters){
					add_message_to_user($current_user->ID, $message->ID);
				}
			}
		}
	}
	
}

function delete_delivered_message($userId, $messageId){
	global $wpdb;
	$userId = (int) $userId;
	$messageId = (int) $messageId;
	$query = "SELECT rel_id FROM $wpdb->delivered_messages WHERE user_Id = $userId AND message_id=$messageId";
	$res = $wpdb->get_var($query);
	if(empty($res)){
		return false;
	}
	$rel_id = (int) $res;

	$query = "DELETE FROM $wpdb->delivered_messages WHERE rel_id = $rel_id";
	$res = $wpdb->query($query);

	if(empty($res)){
		return false;
	}else{
		return true;
	}
}

function get_delivered_messages($userId){
	global $wpdb;
	$ids = array();
	$query = "SELECT message_id FROM $wpdb->delivered_messages WHERE user_id = $userId";
	$res = $wpdb->get_results($query);
	if(!empty($res)){
		foreach ($res as $obj){
			$ids[] = $obj->message_id;
		}
		return $ids;
	}else{
		return false;
	}
}

function check_message_validation(){

	$currentTime = time();
	$args = array(
		'post_type' => 'message',
		'meta_query' => array(
					array(
						'key'     => 'endDate',
						'value'   => $currentTime,
						'compare' => '<',
					),
				),
		'showposts' => -1,
	);
	$messages = get_posts($args);
	if(!empty($messages)){
		foreach($messages as $mes){
			update_post_meta($mes->ID, 'status', 'expired');
		}
	}

}
add_action('check_valid_message', 'check_message_validation');

function add_message_to_user($userId, $messageId){
	global $wpdb;
	$userId = (int) $userId;
	$messageId = (int) $messageId;
	$query = "SELECT rel_id FROM $wpdb->delivered_messages WHERE user_id = $userId AND message_id = $messageId";
	$res = $wpdb->get_var( $query );
	if(!empty($res)){
            return;
	}
	$query = "INSERT INTO $wpdb->delivered_messages (user_id, message_id) VALUES (%d, %d)";
	$res = $wpdb->query( $wpdb->prepare($query, $userId, $messageId) );
	$query = "INSERT INTO $wpdb->new_messages (user_id, message_id) VALUES (%d, %d)";
	$res = $wpdb->query( $wpdb->prepare($query, $userId, $messageId) );

        $business_id = (int) get_post_meta($messageId, 'business', true);
//        $bussines_messages_have = (int) get_post_meta($business_id, 'messages_have', true);
//        $bussines_messages_have++;
//        update_post_meta($business_id, 'messages_have', $bussines_messages_have );

        
	$amount = (int) get_post_meta($messageId, 'amount', true);
	$count_targeted = (int) get_post_meta($messageId, 'count_targeted', true );
	$count_targeted++;
	update_post_meta($messageId, 'count_targeted', $count_targeted);
        if($amount === $count_targeted){
            update_post_meta( $messageId, 'undelivered', '0' );
        }
//	$newMessages = (int) get_user_meta($userId, 'mcc_new_messages', true);
//	$newMessages++;
//	update_user_meta($userId, 'mcc_new_messages', $newMessages);
}
/*
 * delete message from new
 */

function getNewMessages($userId){
    global $wpdb;
    $userId = (int) $userId;
    $query = "SELECT COUNT(*) FROM {$wpdb->new_messages} WHERE user_id = $userId";
    $res = $wpdb->get_var($query);
    return $res;
}

function reset_new_messages($user_id, $message_id){
    $user_id = (int) $user_id;
    $message_id = (int) $message_id;
    global $wpdb;

    $res = $wpdb->delete( $wpdb->new_messages, array( 'user_id' => $user_id, 'message_id' =>  $message_id) );

}

// Delete Benefit

function delete_benefit(){
	header("Content-type:application/json"); 
	global $current_user;

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	
	if($business) {
		$business = $business[0];
		if(have_rows('benefits', $business->ID)){
			$benefits = get_field('benefits', $business->ID);
			foreach($benefits as $benefit) {
				the_row();
				if(get_sub_field("benefit_id") != $_POST["benefitId"])
					$newBenefits[] = $benefit;
			}
			
			update_field('benefits', $newBenefits, $business->ID);
			
			echo json_encode(array("success" => true));die();
		}
	}
}

add_action( 'wp_ajax_nopriv_delete_benefit',  'delete_benefit' );
add_action( 'wp_ajax_delete_benefit', 'delete_benefit' );

// Delete Message

function delete_message(){
	global $current_user;
	global $wpdb;

	header("Content-type:application/json");
	$id = (int) $_POST['id'];
	
	$user_type = get_user_meta($current_user->ID, 'mcc_user_type', true);
        $newMessagesHave = false;
	if($current_user->caps['contributor']||$user_type == 'business'){

        $args = array(
            'author' => $current_user->ID,
            'posts_per_page'   => 5,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'business',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $business = get_posts( $args );
        $business = $business[0];
        
        $res = update_post_meta($id, 'status', 'deleted');
        update_post_meta($id, 'undelivered', '0');
        $wpdb->delete( $wpdb->new_messages, array('message_id' =>  $id) );
        $messages_have = (int) get_post_meta($business->ID, 'messages_have', true);
        $amount = (int) get_post_meta($id, 'amount', true);
        $count_targeted = (int) get_post_meta($id, 'count_targeted', true);

        $newMessagesHave = $messages_have + ($amount - $count_targeted);
        update_post_meta($business->ID, 'messages_have', $newMessagesHave);

	}else{
		$res = delete_delivered_message($current_user->ID, $id);
	}
	if(!$res){
		echo json_encode(array("success" => false));die();
	}else{
		echo json_encode(array("success" => true, "newMessagesHave" => $newMessagesHave));die();
	}
}

add_action( 'wp_ajax_deleteMessage',  'delete_message' );

function update_notification_status(){
	header("Content-type:application/json"); 
	global $current_user;
	$id = (int) $_POST['id'];

	$user_type = get_user_meta($current_user->ID, 'mcc_user_type', true);
	if($current_user->caps['contributor']||$user_type == 'business'){
		
		$currentStatus = trim(strip_tags($_POST['currentStatus']));
		if($currentStatus == 'Active'){
			$res = update_post_meta($id, 'status', 'disabled');
			if(!$res){
				echo json_encode(array("success" => false));die();
			}
			echo json_encode(array("success" => true, 'newStatus' => 'Disabled', 'newButton' => 'Resume')); die();
		}else{
			$res = update_post_meta($id, 'status', 'active');
			$valTime = (int) get_post_meta($id, 'endDate', true);
			$ct = time();
			if($valTime < $ct){
				$newTime = $ct+604800; // 1 week
				update_post_meta($id, 'endDate', $newTime);
			}
			if(!$res){
				echo json_encode(array("success" => false));die();
			}
			echo json_encode(array("success" => true, 'newStatus' => 'Active', 'newButton' => 'Stop')); die();
		}
	}else{
		echo json_encode(array("success" => false));die();
	}
	

}

add_action( 'wp_ajax_changeMessageStatus',  'update_notification_status' );

add_action('wp_ajax_soldOut', 'messageSoldOut');

function messageSoldOut(){
	$mesId = (int) trim(strip_tags($_POST['mesId']));
	$currentStatus = trim(strip_tags($_POST['currentStatus']));
	if($currentStatus !== 'Sold out'){
		update_post_meta($mesId, 'status', 'sold out');
                echo json_encode(array("success" => true, "newStatus" => "Sold out"));die();
	}
	echo json_encode(array("success" => false));die();
}
// Get Benefit Details

function get_benefit_details(){
	header("Content-type:application/json"); 
	global $current_user;

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	
	if($business) {
		$business = $business[0];
		if(have_rows('benefits', $business->ID)) {
			$benefits = get_field('benefits', $business->ID);
			foreach($benefits as $benefit) {
				the_row();
				if($_POST["benefitId"] == get_sub_field("benefit_id")) {
					$currentBenefit = $benefit;
					$currentBenefit["endStr"] = strtotime(str_replace('/', '-', $benefit["benefit_expiration"]));
					$currentBenefit["todayStr"] = strtotime('now');
					$currentBenefit["business_pack"] = get_field("business_pack", $business->ID);
				}
			}

			echo json_encode(array("success" => true, "data" => $currentBenefit));die();
		}
	}
}

add_action( 'wp_ajax_nopriv_get_benefit_details',  'get_benefit_details' );
add_action( 'wp_ajax_get_benefit_details', 'get_benefit_details' );


function side_categories() {
	global $wp_query;
	global $wpdb;
	$current_tax =	$wp_query->queried_object->name;

	$val = get_option('categories_order');
    $val = $val['input'];
    if($val == 'count'){
    	$order = 'DESC';
    	$meta_query = array();
  		$args = array('type' => 'business', 'parent' => 0, 'taxonomy' => 'business_cat', 'hide_empty' => 0, 'orderby' => $val, 'order' => $order);
		$categories = get_categories($args);
    }elseif( $val=='visible' ){
    	$categories = get_categories_by_visible_bus();
    }elseif($val == 'yaron'){

		$order = 'DESC';
		$args = array('type' => 'business', 'parent' => 0, 'taxonomy' => 'business_cat', 'hide_empty' => 0);
		$precategories = get_categories($args);
		$categories = array();
		$i = 18;
		foreach($precategories as $category){
                        $catEnId = $iclId = (int) icl_object_id($category->term_id, 'business_cat', true, 'en');
			switch($catEnId){
				case 137: $categories[0] = $category;
					break;
				case 141: $categories[1] = $category;
					break;
				case 145: $categories[2] = $category;
					break;
				case 149: $categories[3] = $category;
					break;
				case 153: $categories[4] = $category;
					break;
				case 157: $categories[5] = $category;
					break;
				case 161: $categories[6] = $category;
					break;
				case 165: $categories[7] = $category;
					break;
				case 169: $categories[8] = $category;
					break;
				case 173: $categories[9] = $category;
					break;
				case 177: $categories[10] = $category;
					break;
				case 181: $categories[11] = $category;
					break;
				case 185: $categories[12] = $category;
					break;
				case 189: $categories[13] = $category;
					break;
				case 193: $categories[14] = $category;
					break;
				case 197: $categories[15] = $category;
					break;
				case 201: $categories[16] = $category;
					break;
				case 205: $categories[100] = $category;
					break;
				default: $categories[$i] = $category; $i++;
					break;
			}
		}
		ksort($categories);
	}else{
    	$order = 'ASC';
    	$args = array('type' => 'business', 'parent' => 0, 'taxonomy' => 'business_cat', 'hide_empty' => 0, 'orderby' => $val, 'order' => $order);
		$categories = get_categories($args);
    }
	$catsHTML = '';
	foreach($categories as $category) {
		$subCatsHTML = '';
		$subArgs = array('type' => 'business', 'parent' => $category->term_id, 'taxonomy' => 'business_cat', 'hide_empty' => 1, 'orderby' => 'name', 'order' => 'ASC');
		$subCats = get_categories($subArgs);

		$thisCat = $current_tax == $category->name?"selected_cat":"";
		$iclId = (int) icl_object_id($category->term_id, 'business_cat', true, 'en');
		if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All'){
			$args = array(
				'post_type' => 'business',
				'tax_query' => array(
							array(
								'taxonomy' => 'business_cat',
								'field'    => 'id',
								'terms'    =>  $iclId
							)
						),
				'meta_query' => array(
					array(
						'key'   => 'bcity',
						'value' => $_SESSION["my_cityz"],
					),
					array(
						'key'     => 'visibility',
						'value'   => "1",
					),
				),
				'showposts' => -1,
			);

		}else{
			$args = array(
				'post_type' => 'business',
				'tax_query' => array(
							array(
								'taxonomy' => 'business_cat',
								'field'    => 'id',
								'terms'    =>  $iclId
							)
						),
				'meta_key' => 'visibility',
				'meta_value' => '1',
				'showposts' => -1,
			);
		}
		$businesses = new WP_Query($args);
		$count = $businesses->found_posts;
		if($subCats) {

			$subCatsHTML .= '<ul>';
                        $selectedSubCat = false;
			foreach($subCats as $sCat) {
				$thisSCat = $current_tax == $sCat->name?"selected_cat":"";
                                if(!empty($thisSCat)){
                                    $selectedSubCat = true;
                                }
				$siclId = icl_object_id($sCat->term_id, 'business_cat', true, 'en');
				if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All'){
					$siclId = (int) icl_object_id($sCat->term_id, 'business_cat', true, 'en');
					$args = array(
						'post_type' => 'business',
						//'business_cat' => $sCat->slug,
						'tax_query' => array(
							array(
								'taxonomy' => 'business_cat',
								'field'    => 'term_id',
								'terms'    => $siclId
							)
						),
						'meta_query' => array(
							array(
								'key'   => 'bcity',
								'value' => $_SESSION["my_cityz"],
							),
							array(
								'key'     => 'visibility',
								'value'   => "1",
							),
						),
						'showposts' => -1
					);
				}else{
					$args = array(
						'post_type' => 'business',
						'tax_query' => array(
							array(
								'taxonomy' => 'business_cat',
								'field'    => 'term_id',
								'terms'    => $siclId
							)
						),
						'meta_key' => 'visibility',
						'meta_value' => '1',
						'showposts' => -1
					);
				}
				$b = new WP_Query($args);
				$countSub = $b->found_posts;
				
				$subCatsHTML .= '<li class="'.$thisSCat.'"><a href="' .get_term_link($sCat). '"> - ' .$sCat->name. ' ('.$countSub.')</a></li>';
			}
			$term_id = (int) $iclId;
			$link = get_term_link($term_id, 'business_cat');
			$subCatsHTML .= '</ul>';
			if($countSub == 0||(!$selectedSubCat&&$category->name != $current_tax)){
				$subCatsHTML = '';
			}
			$catsHTML .= '<li class="'.$thisCat.'"><a href="'.$link. '" class="menu-side-arrow">' .$category->name; '</a>' .$subCatsHTML. '</li>';
			if(!empty($count)){
				$catsHTML .= ' ('.$count.')</a>' .$subCatsHTML. '</li>';
			}else{
				$catsHTML .= '</a>' .$subCatsHTML. '</li>';
			}
		} else {
			$term_id = (int) $category->term_id;
			$link = get_term_link($term_id, 'business_cat');
			$catsHTML .= '<li class="'.$thisCat.'"><a href="' .$link. '">' .$category->name;
			if(!empty($count)){
				$catsHTML .= ' ('.$count.')</a></li>';
			}else{
				$catsHTML .= '</a></li>';
			}
		}
		wp_reset_query();
		
	}
	
	
	echo '<ul id="menu-side-menu">' .$catsHTML. '</ul>';
}
add_shortcode('side_categories', 'side_categories');

add_filter('widget_text', 'do_shortcode');

// Add Business To Favorites
function add_business_fav() {
	header("Content-type:application/json"); 
	global $current_user;
	global $wpdb;
	
	if(is_user_logged_in()) {
		$bizId = (int) $_POST["bid"];

		$query = "SELECT rel_id FROM $wpdb->biz_favorites WHERE user_id = $current_user->ID AND business_id = $bizId";
		$res = $wpdb->get_var($query);
		if(!empty($res)){
			echo json_encode(array("success" => false)); die();
		}
		$query = "INSERT INTO $wpdb->biz_favorites
					(user_id, business_id)
					VALUES (%d, %d)
					";
		$res = $wpdb->query(
			$wpdb->prepare(
				$query,
				$current_user->ID,
				$bizId
		  )
		);
		if($res){
			echo json_encode(array("success" => true)); die();
		}else{
			echo json_encode(array("success" => 1)); die();
		}

	} else {
		echo json_encode(array("success" => false)); die();
	}
}

add_action( 'wp_ajax_nopriv_add_business_fav',  'add_business_fav' );
add_action( 'wp_ajax_add_business_fav', 'add_business_fav' );


// Delete Business From Favorites
function delete_business_fav() {
	header("Content-type:application/json"); 
	global $current_user;
	global $wpdb;
	$bizId = (int) $_POST["bid"];
	if(is_user_logged_in()) {
		$query = "DELETE FROM $wpdb->biz_favorites WHERE user_id = %d AND business_id = %d";
		$res = $wpdb->query(
				$wpdb->prepare($query, $current_user->ID, $bizId)
			);
		if($res){
			echo json_encode(array("success" => true)); die();
		}else{
			echo json_encode(array("success" => false)); die();
		}

	} else {
		echo json_encode(array("success" => false)); die();
	}
	
}

add_action( 'wp_ajax_nopriv_delete_business_fav',  'delete_business_fav' );
add_action( 'wp_ajax_delete_business_fav', 'delete_business_fav' );


// Add Benefit To Favorites
function add_benefit_fav() {
	header("Content-type:application/json"); 
	global $current_user;
	global $wpdb;

	
	if(is_user_logged_in()) {
		$user_id = (int) $current_user->ID;
		$bizId = (int) $_POST["business_id"];
		$benId = $_POST["benefit_id"];
		$query = "SELECT rel_id, fav_benefits FROM $wpdb->ben_favorites where user_id = $user_id and business_id=$bizId";
		$res = $wpdb->get_results( $query );
		if( empty($res) ){
			$favBenefits = array(
					array(
						'benefit_id' => $benId,
						),
				);
			$serArr = serialize($favBenefits);
			$wpdb->query(
				$wpdb->prepare(
					"INSERT INTO $wpdb->ben_favorites ( user_id, business_id, fav_benefits ) VALUES ( %d, %d, %s )",
					$user_id,
					$bizId,
					$serArr
			  )
			);
			echo json_encode(array("success" => true)); die();
		}else{
			$relId = $res[0]->rel_id;
			$favBenefits = unserialize($res[0]->fav_benefits);
			$favBen = array(
					'benefit_id' => $benId,
				);
			foreach($favBenefits as $fb){
				if($fb['benefit_id'] == $benId){
					echo json_encode(array("success" => false)); die();
				}
			}
			$favBenefits[] = $favBen;
			$serArr = serialize($favBenefits);
			$wpdb->query("UPDATE $wpdb->ben_favorites SET fav_benefits='$serArr' WHERE rel_id = $relId");

			echo json_encode(array("success" => true)); die();
		}
	} else {
		echo "FU";die();
	}
}

add_action( 'wp_ajax_nopriv_add_benefit_fav',  'add_benefit_fav' );
add_action( 'wp_ajax_add_benefit_fav', 'add_benefit_fav' );



// Delete Benefit From Favorites
function delete_benefit_fav() {
	header("Content-type:application/json"); 
	global $current_user;
	global $wpdb;
	$bizId = $_POST['business_id'];
	$benId = $_POST['benefit_id'];
	if(is_user_logged_in()) {
		$query = "SELECT * FROM $wpdb->ben_favorites WHERE user_id = $current_user->ID and business_id = $bizId";
		$res = $wpdb->get_results($query);
		if(!is_array($res)){
			echo json_encode(array("success" => false)); die();
		}
		foreach ($res as $biz) {
			$benefits = unserialize($biz->fav_benefits);
			if(is_array($benefits)){
				foreach($benefits as $key => $benefit){
					if($benefit['benefit_id'] == $benId){
						unset($benefits[$key]);
					}
				}
			}
			
		}
		if(empty($benefits)){
			$query = "DELETE FROM $wpdb->ben_favorites
						WHERE user_id = $current_user->ID 
						AND business_id = $bizId";
			$RES = $wpdb->query( $query );
			if($res){
				echo json_encode(array("success" => true)); die();
			}else{
				echo json_encode(array("success" => false)); die();
			}
		}
		$serr = serialize($benefits);
		$query = "UPDATE $wpdb->ben_favorites SET fav_benefits = '$serr'
					WHERE user_id = $current_user->ID
					AND business_id = $bizId";
		$res = $wpdb->query($query);
		if($res){
			echo json_encode(array("success" => true)); die();
		}else{
			echo json_encode(array("success" => false)); die();
		}
	} else {
		echo json_encode(array("success" => false)); die();
	}
}

add_action( 'wp_ajax_nopriv_delete_benefit_fav',  'delete_benefit_fav' );
add_action( 'wp_ajax_delete_benefit_fav', 'delete_benefit_fav' );

add_filter('json_api_encode', 'json_api_encode_acf');


function json_api_encode_acf($response) 
{
    if (isset($response['posts'])) {
        foreach ($response['posts'] as $post) {
            json_api_add_acf($post); // Add specs to each post
        }
    } 
    else if (isset($response['post'])) {
        json_api_add_acf($response['post']); // Add a specs property
    }

    return $response;
}

function json_api_add_acf(&$post) 
{
    $post->acf = get_fields($post->id);
}


add_filter('show_admin_bar', '__return_false');


add_filter( 'gform_disable_post_creation', 'disable_post_creation', 10, 3 );
function disable_post_creation( $is_disabled, $form, $entry ) {
    return true;
}

add_filter('gform_confirmation_anchor', '__return_false');


add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}



add_filter( 'gform_pre_render_1', 'register_u_pre_form' );
add_filter( 'gform_pre_validation_1', 'register_u_pre_form' );
add_filter( 'gform_pre_submission_filter_1', 'register_u_pre_form' );
add_filter( 'gform_admin_pre_render_1', 'register_u_pre_form' );
function register_u_pre_form( $form ) {
    foreach ( $form['fields'] as &$field ) {
        if ( $field->type == 'select' && $field->id == 1) {
			$args = array(
				'posts_per_page'   => -1,
				'order'   => 'ASC',
				'post_type'        => 'city',
				'suppress_filters' => false
			);
			$cities = get_posts( $args ); 

			$choices = array();

			foreach ( $cities as $city ) {
				$iclId = icl_object_id($city->ID, 'city', true, 'en');
				$choices[] = array( 'text' => $city->post_title, 'value' => $iclId );
			}

			$field->placeholder = 'Select a city';
			
			$field->choices = $choices;
		}
    }

    return $form;
}

add_action( 'gform_after_submission_1', 'new_post_customer_register', 10, 2 );
function new_post_customer_register( $entry, $form ) {
	$user = get_user_by_email( $entry['6'] );
	$to = $entry['6'];
	$subject = 'Activation Link';
	$body = 'http://mycitycard.info/?activate_hash='.md5($user->data->user_email."_".$user->data->display_name).'&user_id='.$user->ID;
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$car_nummber = generate_card_number();
	update_user_meta($user->ID, 'card', $car_nummber);
	wp_mail( $to, $subject, $body, $headers );
}

add_action( 'user_register', 'addcardNumber', 10, 1 );

function addcardNumber( $user_id ) {
    $user = get_userdata( $user_id );
    if(in_array('subscriber', $user->roles)){
        $car_nummber = generate_card_number();
        update_user_meta($user_id, 'card', $car_nummber);
        update_field("alert_rate_new_benefits", 'All', "user_".$user_id);
    }
}

add_action('init','possibly_redirect');

function possibly_redirect(){
    global $pagenow;
    if( 'wp-login.php' == $pagenow && !isset($_GET['action'])&&$_SERVER['REQUEST_METHOD']=== 'GET' ) {
        if(!empty($_SERVER['QUERY_STRING'])){
            $redirect = '/log-in/?'.$_SERVER['QUERY_STRING'];
        }else{
            $redirect = '/log-in/';
        }
        wp_redirect($redirect);
        exit();
    }
}

function get_current_user_role() {
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
}

function checkIfActivateLink() {
	header('Content-Type: text/html; charset=utf-8');
	if(isset($_GET["activate_hash"]) && isset($_GET["user_id"])) {
		$user = get_user_by("id", $_GET["user_id"]);
		
		if(get_field("active_user", "user_".$user->ID) == 1) {
			echo "<script>alert('יוזר זה כבר מאושר.');location.href = '/';</script>";
		} else {
			if(md5($user->data->user_email."_".$user->data->display_name) == $_GET["activate_hash"]) {
				update_field("active_user", 1, "user_".$user->ID);
				$userCityID = get_user_meta($user->ID, 'city', true);
				$active = get_post_meta($userCityID, 'active_city', true);
				if(empty($active)){
					add_action('wp_enqueue_scripts', 'enqueue_popup_script');
				}else{
					echo "<script>
					alert('היוזר אושר בהצלחה!');

					location.href = '/';</script>";
				}
				
			} else {
				echo "<script>alert('אירוע שגיאה בפניה, נא נסה שנית.');location.href = '/';</script>";
			}
		}
	}
}

add_action( 'init', 'checkIfActivateLink' );

function enqueue_popup_script(){
	wp_enqueue_script('front', get_template_directory_uri() . '/js/checkactivecity.js', array('jquery'), true );
}


function distance($lat1, $lon1, $lat2, $lon2, $unit='K') {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

function check_benefit_expiration_date() {
	$args = array('posts_per_page' => -1, 'post_type' => 'business', 'post_status' => 'publish');
	$businesses = get_posts( $args );
	foreach($businesses as $biz) {
		if(have_rows("benefits", $biz->ID)) {
			while(have_rows("benefits", $biz->ID)) {
				the_row();
				$nBenefitDate = strtotime(str_replace('/', '-', get_sub_field("benefit_expiration")));
				if(get_sub_field("benefit_status") == 1 && get_sub_field("benefit_type") == "Additional" && $nBenefitDate < strtotime('now')) {
					update_sub_field("benefit_status", 0, $biz->ID);
				}
			}
		}
	}
}
add_action( 'cron_check_benefit_expiration_date', 'check_benefit_expiration_date' );

//add visibility to business
function add_visibility_to_business($ID, $post){
	update_post_meta($ID, 'visibility', 0);
	update_post_meta($ID, 'messages_have', 0);
}
add_action('new_business', 'add_visibility_to_business', 10, 2);

/*
*	update area benefit if business became 'free'
*/

function change_area_benefits($meta_id, $object_id, $meta_key, $meta_value ){
	global $wpdb;
	if($meta_key == 'business_pack' && $meta_value=='Free'){
		if(have_rows('benefits', $object_id)){
			$cityId = get_post_meta($object_id, 'bcity', true);
			$city = get_the_title($cityId);
			while (have_rows('benefits', $object_id)){
				the_row();
				$benefitType = get_sub_field('benefit_type');
				if($benefitType == 'Main Benefit'){
					update_sub_field('area', $city.' card holders exclusive', $object_id);
				}
				if($benefitType == 'Additional'){
					update_sub_field('benefit_status', 0, $object_id);
				}
			}
		}
	}

	if($meta_key == 'visibility' && $meta_value=='0' ){
		$post_term = wp_get_post_terms($object_id, 'business_cat');
		$postTermId = $post_term[0]->term_id;
		delete_visible_post($object_id, $postTermId);
	}
	if($meta_key == 'visibility' && $meta_value=='1'){
		$post_term = wp_get_post_terms($object_id, 'business_cat');
		$postTermId = $post_term[0]->term_id;
		add_visible_post($object_id, $postTermId);
	}

}

add_action("updated_postmeta", "change_area_benefits", 10, 4);

/*
*	update visible post term meta if post deleted
*/

add_action('delete_post', 'update_term_visible_post');
add_action('delete_post', 'deleteNewMessageFromTable');
add_action('wp_trash_post', 'update_term_visible_post');

function deleteNewMessageFromTable($postid){
    global $wpdb;
    $post_type = get_post_type($postid);
    if($post_type != 'message'){
        return false;
    }
    $postid = (int) $postid;
    $res = $wpdb->delete( $wpdb->new_messages, array( 'message_id' =>  $postid) );
    $res = $wpdb->delete( $wpdb->delivered_messages, array( 'message_id' =>  $postid) );
}

function update_term_visible_post($postid){
    global $wpdb;
    $post_type = get_post_type($postid);
    if($post_type != 'business'){
        return false;
    }

    $postid = (int) $postid;
    $post_term = wp_get_post_terms($postid, 'business_cat');
    $postTermId = (int) $post_term[0]->term_id;

    delete_visible_post($postid, $postTermId);
    $wpdb->delete($wpdb->promotions, array('business_id' => $postid));
    $wpdb->delete($wpdb->ben_favorites, array('business_id' => $postid));
    $wpdb->delete($wpdb->biz_favorites, array('business_id' => $postid));
    
    return;
}

/**
 * Delete business data if user delete
 */

add_action('delete_user', 'deleteBusinessUserData');
function deleteBusinessUserData($user_id){
    global $wpdb;
    $user = get_user_by('id', $user_id);
    if(empty($user)){
        return;
    }
    if(in_array('subscriber', $user->roles)){
        $wpdb->delete($wpdb->delivered_messages, array('user_id' => $user_id));
    }else{
        $args = array(
            'author' => $user_id,
            'posts_per_page'   => 5,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'business',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => true 
        );
        $business = get_posts( $args ); 
        $business = $business[0];
        $postid = (int) $business->ID;
	$post_term = wp_get_post_terms($postid, 'business_cat');
	$postTermId = (int) $post_term[0]->term_id;
	delete_visible_post($postid, $postTermId);
	$wpdb->delete($wpdb->promotions, array('business_id' => $postid));
	$wpdb->delete($wpdb->ben_favorites, array('business_id' => $postid));
	$wpdb->delete($wpdb->biz_favorites, array('business_id' => $postid));
        $args = array(
            'post_type' => 'message',
            'author' => $user_id,
            'showposts' => -1,
        );
        $messages = get_posts($args);
        if(!empty($messages)&&is_array($messages)){
            foreach($messages as $message){
                wp_delete_post($message->ID, true);
            }
        }
    }
    $wpdb->delete($wpdb->ben_favorites, array('user_id' => $user_id));
    $wpdb->delete($wpdb->biz_favorites, array('user_id' => $user_id));
}

/**
* Update term meta data
*
*/

function custom_update_term_meta($id, $meta_key, $meta_value){
	global $wpdb;
	$id = (int) $id;
	$query = "SELECT meta_id FROM {$wpdb->prefix}termmeta 
				WHERE meta_key='$meta_key' AND term_id = $id";
	$meta_id = $wpdb->get_var($query);
	if(!empty($meta_id)){
		$query = "UPDATE {$wpdb->prefix}termmeta SET meta_value = '$meta_value'
				WHERE term_id = $id AND meta_key = '$meta_key'";
	}else{
		$query = "INSERT INTO {$wpdb->prefix}termmeta (term_id, meta_key, meta_value)
					VALUES ($id, '$meta_key', '$meta_value')";
	}
	$wpdb->query($query);
}

/**
* get term meta data
*/

function custom_get_term_meta($id, $meta_key){
	global $wpdb;
	$id = (int) $id;
	$query = "SELECT meta_value FROM {$wpdb->prefix}termmeta
				WHERE term_id = $id AND meta_key = '$meta_key'";
	$res = $wpdb->get_var($query);
	return $res;
}

function custom_delete_term_meta($id){
	global $wpdb;
	$id = (int) $id;
	$query = "DELETE FROM {$wpdb->prefix}termmeta
				WHERE term_id = $id";
	$wpdb->query($query);
}

/**
* Add visible post to category
*/


function add_visible_post($post_id, $term_id){
	global $wpdb;
	$term_id = (int) $term_id;
	$post_id = (int) $post_id;
	$query = "SELECT rel_id FROM ".TABLE_TERMVISPOST_RELATIONSHIP."
				WHERE term_id=$term_id
				AND post_id=$post_id";
	$rel = $wpdb->get_var($query);
	if(!empty($rel)){
		return false;
	}
	$query = "INSERT INTO ".TABLE_TERMVISPOST_RELATIONSHIP." (term_id, post_id)
				VALUES ($term_id, $post_id)";
	$res = $wpdb->query($query);
	$visPosts = (int) custom_get_term_meta($term_id, 'visible_posts');
	$visPosts++;
	custom_update_term_meta($term_id, 'visible_posts', $visPosts);
	return $res;
}

/**
* Delete visible post from category
*/

function delete_visible_post($post_id, $term_id){
	global $wpdb;
	$term_id = (int) $term_id;
	$post_id = (int) $post_id;
	$query = "SELECT rel_id FROM ".TABLE_TERMVISPOST_RELATIONSHIP."
				WHERE term_id=$term_id
				AND post_id=$post_id";
	$rel = $wpdb->get_var($query);
	if(empty($rel)){
		return false;
	}
	$query = "DELETE FROM ".TABLE_TERMVISPOST_RELATIONSHIP."
				WHERE term_id=$term_id
				AND post_id=$post_id";
	$res = $wpdb->query($query);
	$visPosts = (int) custom_get_term_meta($term_id, 'visible_posts');
	if(!empty($visPosts)){
		$visPosts = $visPosts-1;
	}
	custom_update_term_meta($term_id, 'visible_posts', $visPosts);
	return $res;
}

/**
* add 0 visible posts to category after new category register
*/

function add_business_numbers_vis($term_id){
	custom_update_term_meta($term_id, 'visible_posts', '0');
}
add_action('create_business_cat', 'add_business_numbers_vis');

/**
* delete term meta after delete category
*/

function delete_business_meta($term){
	custom_delete_term_meta($term);
}
add_action('delete_business_cat', 'delete_business_meta');



/**
* Get all business categories, order by number of visible busnesses
* @return array
*/

function get_categories_by_visible_bus(){
	global $wpdb;
	global $sitepress;
	$currentLan = $sitepress->get_current_language();
	$query = "SELECT tax.term_id, tax.name, tax.slug FROM $wpdb->terms AS tax LEFT OUTER JOIN $wpdb->termmeta AS meta ON  (tax.term_id=meta.term_id) INNER JOIN {$wpdb->prefix}icl_translations AS trans ON (trans.element_id = tax.term_id) INNER JOIN $wpdb->term_taxonomy AS tt ON (tt.term_id = tax.term_id)
				WHERE trans.language_code = '$currentLan'
				AND trans.element_type = 'tax_business_cat'
				AND tt.parent = 0
				ORdER BY meta.meta_value DESC";
	return $wpdb->get_results($query);
}

function get_categories_with_visible_bizs(){
	global $wpdb;
	global $sitepress;
	$city = '';
	if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All'){
		$city = $_SESSION["my_cityz"];
	}

	//$currentLan = $sitepress->get_current_language();
	if(!empty($city)){

		$query = "SELECT DISTINCT tax.term_id, tax.name FROM $wpdb->terms AS tax, $wpdb->termmeta AS meta, {$wpdb->prefix}icl_translations AS trans,  $wpdb->term_relationships AS rel, $wpdb->term_taxonomy AS tt
					WHERE tax.term_id=meta.term_id
                                        AND tt.term_id = tax.term_id 
                                        AND tt.parent = 0
					AND trans.element_id = tax.term_id
					AND trans.language_code = 'en'
					AND trans.element_type = 'tax_business_cat'
					AND rel.term_taxonomy_id = tax.term_id
					AND meta.meta_value <> 0
					AND rel.object_id IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key='bcity' AND meta_value='$city')
				ORdER BY meta.meta_value DESC";
	}else{
		$query = "SELECT DISTINCT tax.term_id, tax.name FROM $wpdb->terms AS tax, $wpdb->termmeta AS meta, {$wpdb->prefix}icl_translations AS trans, $wpdb->term_taxonomy AS tt
				WHERE tax.term_id=meta.term_id
                                AND tt.term_id = tax.term_id 
                                AND tt.parent = 0
				AND trans.element_id = tax.term_id
				AND trans.language_code = 'en'
				AND trans.element_type = 'tax_business_cat'
				AND meta.meta_value <> 0
				ORdER BY meta.meta_value DESC";
	}
	$res = $wpdb->get_results($query);

	return $res;
}



function generate_card_number(){
	$card = date('dm_Y_Hi_s');
	$card .= rand(10, 99);
	return $card;
}

add_action('wp_ajax_getFavBenefits', 'get_fav_benefits');
function get_fav_benefits(){
	global $current_user;
	global $wpdb;

	$query = "SELECT * FROM $wpdb->ben_favorites WHERE user_id = $current_user->ID";
	$res = $wpdb->get_results( $query );
	if(!is_array($res)){
		die();
	}
	foreach($res as $biz){
		$favBenefits = unserialize($biz->fav_benefits);
		$business_id = $biz->business_id;
        $business_name = get_the_title($business_id);
        $business_link = get_permalink($business_id);
		if(is_array($favBenefits)){
			foreach($favBenefits as $benefit){
				$favBenefitId = $benefit['benefit_id'];
				while(have_rows('benefits', $business_id)) { the_row();

					if(get_sub_field("benefit_id") == $favBenefitId && get_sub_field("benefit_status") == 1) {
						$benefit_title = get_sub_field("benefit_title");
						$benefit_description = get_sub_field("benefit_description");
						$benefit_image = get_sub_field('benefit_image')["url"];
						$benefit_id = get_sub_field('benefit_id');
						
						$validThru = get_sub_field("benefit_type") == "Additional"?"Valid through ".get_sub_field('benefit_expiration'):"";
						$bCity = get_field("bcity", $business_id);
						$areaText = get_sub_field('area');

						$bUrl = get_bloginfo('template_directory');
						echo <<<html
							<div class="business_page_benefit">
								<div class="business_page_benefit_discount"><img src="{$benefit_image}"></div>
								<div class="business_page_benefit_details">
									<div class="business_page_benefit_title"><a href="{$business_link}" style="color: #d28b26;font-weight: bold;">{$business_name}</a></div>
									<div class="business_page_benefit_card">{$areaText}</div>
                                    <div class="business_page_benefit_title" style="color: black;font-size: 15px;">{$benefit_title}</div>

									<p>
										{$benefit_description}<br />
										{$validThru}
									</p>
								</div>
								<a href="javascript:void(0)" class="business_page_benefit_fav delFavBenefit added" data-business-id="{$business_id}" data-benefit-id="{$benefit_id}"><img src="{$bUrl}/images/delete_icon.png" alt="" /></a>
							</div>
html;
						break;
					}
				}
			}
		}
	}
	?>
	<script>
		jQuery(".delFavBenefit.added").click(delBenefitFromFav);
	</script>
	<?php
	die();
}

function get_favorite_benefits($bizId, $userId){
	global $wpdb;
	$userId = (int) $userId;
	$query = "SELECT * from $wpdb->ben_favorites where user_id=$userId and business_id = $bizId";
	$res = $wpdb->get_results($query);
	if(empty($res)){
		return false;
	}
	foreach($res as $biz){
		if(empty($biz->fav_benefits)){
			return false;
		}
		$favBens = unserialize($biz->fav_benefits);
		if(empty($favBens)){
			return false;
		}
		return $favBens;
	}

}

function get_favorite_businesses($userId){
	$userId = (int) $userId;
	global $wpdb;
	if(!is_user_logged_in()){
		return false;
	}
	$query = "SELECT business_id FROM $wpdb->biz_favorites WHERE user_id = $userId";
	$res = $wpdb->get_results($query);
	return $res;
}


add_action('wp_ajax_changeMainLogo', 'change_main_logo');

function change_main_logo(){
	global $current_user;
	if(!empty($_FILES[0])){
		$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
		);
		$business = get_posts( $args ); 
		$business = $business[0];

		require_once(ABSPATH.'wp-admin/includes/file.php');
		$uploadedfile = $_FILES[0];
		$movefile = wp_handle_upload($uploadedfile, array('test_form' => false));

		//On sauvegarde la photo dans le média library
		if ($movefile) {
			$wp_upload_dir = wp_upload_dir();
			$guid = $wp_upload_dir['url'].'/'.basename($movefile['file']);
			$attachment = array(
			'guid' => $guid,
			'post_mime_type' => $movefile['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($movefile['file'])),
			'post_content' => '',
			'post_status' => 'inherit'
			);	

			$attach_id = wp_insert_attachment($attachment, $movefile['file']);

			// generate the attachment metadata
			$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );

			// update the attachment metadata
			wp_update_attachment_metadata( $attach_id,  $attach_data );		
					
			if(update_field("logo", $attach_id, $business->ID)) {
				echo $guid;
				die();
			} else {
				echo 'error';
				die();
			}
		} else {
			echo 'error';
			die();
		}
	}else{
		echo "error";
		die();
	}
}

add_action('wp_ajax_editAddbenefit', 'edit_additional_benefits');
function edit_additional_benefits(){
	global $current_user;

	$benefitId = $_POST['benefitId'];
	$benefitTile = $_POST['benefitTitle'];
	$benefitDesc = $_POST['benefitDesc'];
	$benefitArea = $_POST['benefitArea'];
	$cityId = get_user_meta($current_user->ID, 'city', true);
	$city = get_the_title($cityId);
	if($benefitArea == '%city% card holders exclusive'){
		$benefitArea = str_replace('%city%', $city, $benefitArea);
	}
	$expDate = $_POST['expDate'];

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	$business = $business[0];
	$error = false;
	if(!empty($_FILES[0])){
		$uploadDir = wp_upload_dir();
		$uploadDir = $uploadDir['path'];
		$uploadFile = $uploadDir.'/'.$_FILES[0]['name'];
		if(!move_uploaded_file($_FILES[0]['tmp_name'], $uploadFile)){
			$error = true;
		}
		if (function_exists('jdn_create_image_id')){
			$image_id = jdn_create_image_id($uploadFile, $business->ID);
		}
	}


	if($business) {
                $time = time();
		update_post_meta($business->ID, 'benefit_created_at', $time);
		if(have_rows('benefits', $business->ID)){
			while( have_rows('benefits', $business->ID) ) {
				the_row();
				if(get_sub_field("benefit_id") == $benefitId) {
					update_sub_field('benefit_title', $benefitTile);
					update_sub_field('benefit_description', $benefitDesc);
					update_sub_field('area', $benefitArea);
					update_sub_field('benefit_expiration', $expDate);
					if(!empty($image_id)) {
						if ($image_id) {
							update_sub_field("benefit_image", $image_id);
						}
					}
					break;
				}
			}
		}
	}if(!$error){
		echo json_encode(array("success" => true, "area" => $benefitArea));
	}else{
		echo json_encode(array("success" => false));
	}
	die();
}

add_action('wp_ajax_editMainBenefit', 'edit_main_benefit');
function edit_main_benefit(){
	global $current_user;
	$benefitId = $_POST['benefitId'];
	$benefitTile = $_POST['benefitTitle'];
	$benefitDesc = $_POST['benefitDesc'];

	$args = array(
		'author' => $current_user->ID,
		'posts_per_page'   => 5,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'business',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$business = get_posts( $args ); 
	$business = $business[0];
	$error = false;
	if(!empty($_FILES[0])){
		$uploadDir = wp_upload_dir();
		$uploadDir = $uploadDir['path'];
		$uploadFile = $uploadDir.'/'.$_FILES[0]['name'];
		if(!move_uploaded_file($_FILES[0]['tmp_name'], $uploadFile)){
			$error = true;
		}
		if (function_exists('jdn_create_image_id')){
			$image_id = jdn_create_image_id($uploadFile, $business->ID);
		}
	}


	if($business) {
		$time = time();
		update_post_meta($business->ID, 'benefit_created_at', $time);
		if(have_rows('benefits', $business->ID)){
			while( have_rows('benefits', $business->ID) ) {
				the_row();
				if(get_sub_field("benefit_id") == $benefitId) {
					update_sub_field('benefit_title', $benefitTile);
					update_sub_field('benefit_description', $benefitDesc);
					if(!empty($image_id)) {
						if ($image_id) {
							update_sub_field("benefit_image", $image_id);
						}
					}
					break;
				}
			}
		}
	}if(!$error){
		echo json_encode(array("success" => true));
	}else{
		echo json_encode(array("success" => false));
	}
	die();
}


add_action('set_object_terms', 'change_term_visible_posts', 10, 6);
function change_term_visible_posts($object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids){
	if($taxonomy == 'business_cat'){
		$vis = get_post_meta($object_id, 'visibility', true);
		if($vis == '1'){
			if(is_array($old_tt_ids)){
				foreach($old_tt_ids as $old_tt_id){
					delete_visible_post($object_id, $old_tt_id);
				}
			}
			if(is_array($tt_ids)){
				foreach($tt_ids as $tt_id){
					add_visible_post($object_id, $tt_id);
				}
			}
		}
	}
}


/**
* Check if business open in current moment
* @param int business id
* @param int current timestamp
* @return bool	
*/

function is_biz_now_open($bizId){
        $timestamp = time();
	$opening_hours = get_field("opening_hours", $bizId);
	if(empty($opening_hours)){
		return false;
	}

	$currentDay = date('l', $timestamp);
	foreach($opening_hours as $open){
		if($currentDay == $open['day']){
			$currTime = (int) date('H', $timestamp);
			$start = (int) $open['start'];
			$end = (int) $open['end'];
			if($currTime >= $start && $currTime <= $end){
				return true;
			}
		}
	}
	return false;

}

function resendVerificationLink(){
    $email = trim(strip_tags($_POST['email']));
    $user = get_user_by_email( $email );
    if(!$user){
        echo json_encode(array("success" => false, 'message' => 'user not found'));
        die();
    }
    $active = get_field("active_user", "user_".$user->ID);

    if($active === '1'){
        echo json_encode(array("success" => false, 'message' => 'user is active'));
        die();
    }

    $to = $email;
    $subject = 'Activation Link';
    $body = 'http://mycitycard.info/?activate_hash='.md5($user->data->user_email."_".$user->data->display_name).'&user_id='.$user->ID;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail( $to, $subject, $body, $headers );
    echo json_encode(array("success" => true));
    die();
}
add_action( 'wp_ajax_nopriv_resendVerificationLink',  'resendVerificationLink' );

function sendPushNotificationsASPN($userId, $message='you have new message'){
    if(!class_exists('WPAPN_MyApiController')){
        return false;
    }
    $deviceTokens = unserialize(get_user_meta($userId, 'device_token', true));
    if(empty($deviceTokens['apple'])||!is_array($deviceTokens['apple'])){
        return false;
    }

    foreach($deviceTokens['apple'] as $deviceToken){
        $result = WPAPN_MyApiController::simpleSendToDevice($deviceToken, $message, array(), 1);
    }
    return true;
}

function sendPushNotificarionsAndroid($userId){
    if(!class_exists('MIXGCMSender')){
        return false;
    }
    $deviceTokens = unserialize(get_user_meta($userId, 'device_token', true));
    if(empty($deviceTokens['android'])||!is_array($deviceTokens['android'])){
        return false;
    }
    $sender = new MIXGCMSender();
    $res = $sender->sendMessage($deviceTokens['android']);
    return $res;
}


function addLogOutLinkToHeaderMenu($items, $args){
    global $sitepress;
    $currentLang = $sitepress->get_current_language();
    if($currentLang != 'en'){
        $label = 'התנתק';
    }else{
        $label = 'Logout';
    }
    $items .= '<li><a href="' .wp_logout_url( home_url() ). '">'.$label.'</a></li>';
    return $items;
}
add_filter( 'wp_nav_menu_items',  'addLogOutLinkToHeaderMenu', 10, 2);

function addUserLoginTime( $user_login, $user ) {
    $time = time();
    update_user_meta($user->ID, 'loginTime', $time);
}
add_action('wp_login', 'addUserLoginTime', 10, 2);

add_action('wp', 'checkPaymentDate');
function checkPaymentDate(){
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }
    
    if(is_page(4566)){
        return;
    }
    global $current_user;
    if(in_array('subscriber', $current_user->roles)){
        return;
    }
    if(!class_exists('MCCTranzillaPayment')){
        return;
    }
    $tranzillaInfo = unserialize(get_user_meta($current_user->ID, 'tranzillaInfo', true));
    if(empty($tranzillaInfo)){
        return;
    }
    
    $currentTime = time();
    if(!isset($tranzillaInfo['nextPaymentDate'])||empty($tranzillaInfo['nextPaymentDate'])){
        return;
    }
    if($currentTime < $tranzillaInfo['nextPaymentDate']){
        return false;
    }
    $args = array(
        'author' => $current_user->ID,
        'posts_per_page'   => 1,
        'post_type'        => 'business'
    );
    $business = get_posts( $args ); 
    $business = $business[0];
    if(isset($tranzillaInfo['stopPaying'])&&true===$tranzillaInfo['stopPaying']){
        $tranzillaInfo = array();
        update_field("business_pack", "Free", $business->ID);
        update_user_meta($current_user->ID, 'tranzillaInfo', '');
        return;
    }
    if($tranzillaInfo['business_pack'] == 'premium_year'){
        if($currentTime >= $tranzillaInfo['paymentYear']){
            $tranzillaInfo = array();
            update_user_meta($current_user->ID, 'tranzillaInfo', '');
            update_field("business_pack", "Free", $business->ID);
            wp_redirect(home_url('/payment/'));
            die();
        }
        $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
        $mesHave = $mesHave+1500;
        update_post_meta($business->ID, 'messages_have', $mesHave);
        $nextpaymentDate = $currentTime+2592000;
        $tranzillaInfo['nextPaymentDate'] = $nextpaymentDate;
        $ser = serialize($tranzillaInfo);
        update_user_meta($current_user->ID, 'tranzillaInfo', $ser);
        return;
    }
    $url = get_permalink(4566);
    wp_redirect($url);
    die();
}

add_action('wp_ajax_stopPaying', 'MCCTranzillaStopPaying');
function MCCTranzillaStopPaying(){
    global $current_user;
    $tranzillaInfo = get_user_meta($current_user->ID, 'tranzillaInfo', true);
    if(empty($tranzillaInfo)){
        echo json_encode(array('success' => false));
        die();
    }
    $tranzillaInfo = unserialize($tranzillaInfo);
    $tranzillaInfo['stopPaying'] = true;
    $ser = serialize($tranzillaInfo);
    $res = update_user_meta($current_user->ID, 'tranzillaInfo', $ser);
    if($res){
        echo json_encode(array('success' => true));
        die();
    }
    echo json_encode(array('success' => false));
    die();
}
add_action('wp_ajax_downgrade', 'MCCTranzillaDowngrade');
function MCCTranzillaDowngrade(){
    global $current_user;
    $tranzillaInfo = get_user_meta($current_user->ID, 'tranzillaInfo', true);
    if(empty($tranzillaInfo)){
        echo json_encode(array('success' => false));
        die();
    }
    $tranzillaInfo = unserialize($tranzillaInfo);
    if($tranzillaInfo['business_pack'] === 'Basic'){
        echo json_encode(array('success' => false));
        die();
    }
    $tranzillaInfo['downgrade'] = 'basic';
    $tranzillaInfo['paymentAmount'] = '30';
    $tranzillaInfo['business_pack'] = 'Basic';
    $ser = serialize($tranzillaInfo);
    $res = update_user_meta($current_user->ID, 'tranzillaInfo', $ser);
    if($res){
        echo json_encode(array('success' => true));
        die();
    }
    echo json_encode(array('success' => false));
    die();
}

add_action('wp_ajax_removeCreditCard', 'removeCreditCard');
function removeCreditCard(){
    global $current_user;
    $tranzillaInfo = get_user_meta($current_user->ID, 'tranzillaInfo', true);
     if(empty($tranzillaInfo)){
        echo json_encode(array('success' => false));
        die();
    }
    $tranzillaInfo = unserialize($tranzillaInfo);
    $tranzillaInfo['token'] = '';
    $tranzillaInfo['expmonth'] = '';
    $tranzillaInfo['expyear'] = '';
    $tranzillaInfo['cardNumber'] = '';
    $ser = serialize($tranzillaInfo);
    $res = update_user_meta($current_user->ID, 'tranzillaInfo', $ser);
    if($res){
        echo json_encode(array('success' => true));
        die();
    }
    echo json_encode(array('success' => false));
    die();
}