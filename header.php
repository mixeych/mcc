<?php
/**
 * The header for our theme.
 *
 * 
 *
 * @package mycitycard
 */
$sessStatus = session_status();
    if($sessStatus == 'PHP_SESSION_DISABLED'||$sessStatus===0 ){
        session_start();
    }
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">


<?php 
if(is_single()):
	$singleId = get_the_id();
	$logo = get_field("logo", $singleId);
	$title = get_the_title();
	$cityId = get_post_meta($singleId, 'bcity', true);
	$cityName = get_the_title($cityId);
	if(is_numeric($logo)){
		$imageFb = wp_get_attachment_image_src($logo)[0];
	}else{
		$imageFb = $logo['url'];

	}
	$short_desc = get_field("field_554775a23e29e", $singleId);
	$desc = "Download MyCityCard app for Free and receive a personal mobile benefits card that gives benefits and coupons for small businesses in your city.
Click to watch $title benefits in $cityName";
?>
<meta property="og:url" content="<?php the_permalink() ?>" />
<meta property="og:type"               content="article" />
<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:description" content="<?php echo $desc; ?>" />
<meta property="og:image" content="<?php echo $imageFb; ?>" />
<?php endif; ?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">


<?php 
global $sitepress;
global $current_user;

$current_language = $sitepress->get_current_language();
$lang = get_bloginfo('language');
?>

<?php if ($current_language == "he") { ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style-he.css" media="screen" type="text/css" />
<?php } ?>
<?php if (is_page_template('page-business.php')) { ?>
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/business.css">
<?php } ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<?php wp_head();  ?>
</head>

<body <?php body_class(); ?>>
<?php //echo ICL_LANGUAGE_CODE; ?>
<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<div id="header-t">
			<div id="click-menu" class="overlay" role="button" aria-label="Responsive Menu Button">
			    <div class="threeLines" id="RMX" style="display: none;">×</div>
			    <div class="threeLines" id="RM3Lines" style="display: block;">       
			        <div class="line"></div>
			        <div class="line"></div>
			        <div class="line"></div>
			    </div>
			</div>
			<div class="container">

				<?php get_template_part( 'partials/temp-header-top-site-branding' ); ?>
				<?php get_template_part( 'partials/temp-header-top-right' ); ?>
				<div class="lang">
					<a href="http://www.online-kharkov.com/he/"><img src="<?php bloginfo('template_directory'); ?>/images/il.png" alt=""></a>
					<a href="http://www.online-kharkov.com"><img src="<?php bloginfo('template_directory'); ?>/images/en.png" alt=""></a>
					<div class="textwidget">
					<?php
                                        if(in_array('subscriber', $current_user->roles)){
                                        $displayName = $current_user->display_name;    
                                        }else{
                                            $args = array(
							'author' => $current_user->ID,
							'posts_per_page'   => 1,
							'post_type'        => 'business'
						);
						$business = get_posts( $args );
						$first_name = get_field("field_554774c73e296", $business[0]->ID);
						$last_name = get_field("field_554775223e297", $business[0]->ID);
                                        
						
						if(!empty($first_name)&&!empty($last_name)){
							$displayName = $first_name.' '.$last_name;
						}else{
							$displayName = $current_user->display_name;
						}
                                        }
						if(is_user_logged_in()) {
                                                        if($current_language == 'en') {
                                                            echo 'Welcome ';                                           
                                                        }else{
                                                            echo 'שלום ';
                                                        }
								echo  '<a href="javascript:void(0)" class="header-display-name">' .$displayName. '</a><i class="fa fa-angle-down" aria-hidden="true"></i>';
                                                                wp_nav_menu(array('menu' => 'header menu', 'container_class' => 'header-menu'));
                                                                
						} else {
							if($current_language == 'en') {
								echo '<a href="#" class="popmake-business-registration" style="cursor: pointer;">Business Registration</a> | <a class="popmake-customer-register" href="javascript:void(0)">User Registration</a> | <a class="popmake-login" href="javascript:void(0)">Login</a>';
							}
							
							if($current_language == 'he') {
								echo '<a href="#" class="popmake-business-registration" style="cursor: pointer;">רישום עסק</a> | <a class="popmake-customer-register" href="javascript:void(0)">רישום משתמש</a> | <a class="popmake-login" href="javascript:void(0)">התחברות</a>';
							}
                                                    do_action( 'wordpress_social_login' );
						}
                                                
					?>
					</div>
					<?php //echo dynamic_sidebar("topbar"); ?>
				</div>
				<div class=""></div>
			</div>
		</div>
		<div id="header-banner">
			<?php 
				$header_src;
				if(is_tax()){
					$currTerm = get_queried_object();
					$taxImg = get_field('cimage', $currTerm->taxonomy.'_'.$currTerm->term_id);
					$header_src = $taxImg['url'];
				}elseif(isset($_SESSION["my_cityz"])&&$_SESSION["my_cityz"] != 'All'){
					$header_src = get_field('city_image', $_SESSION["my_cityz"]);
					$header_src = $header_src['url'];
				}else{
					$header_src = get_field('country_image', 'countries_206');
					$header_src = $header_src['url'];

				}
				if(empty($header_src)){
					$header_src = get_field('country_image', 'countries_206');
					$header_src = $header_src['url'];
				}
			?>
			<img class="header-banner" src=<?php echo $header_src; ?> >
			<div class="container">

				<h2 class="site-description"><?php the_field('slider_headline') ?></h2>
				<h3 class="site-subdescription"><?php the_field('slider_sub_headline') ?></h3>

				<?php if (is_page_template('page-business.php')) {
						global $post;
						$parent_id = $post->post_parent;
						$field_from_parent = get_field('slider_headline', $parent_id);
						$field_from_parent = get_field('slider_sub_headline', $parent_id);

					} ?>
				<?php 
				if(is_tax()){
					$tax = get_queried_object();
					?>
					<h2 class="site-description"><?php echo $tax->name; ?></h2>
					<?php
					} 
				?>
			</div>
		</div>
		<div id="header-bottom">
			<div class="container">
				<?php if(is_user_logged_in()) { ?>
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><?php _e( 'Primary Menu', 'mycitycard' ); ?></button>
					<?php 
						if(get_current_user_role() == 'Subscriber') {
							$myCardLink;
							if($current_language == 'en'){
								$myCardLink = get_permalink(1432);
							}else{
								$myCardLink = get_permalink(1442);
							}
						if($current_language == 'he'){
							$favLink = get_permalink(1445);
							$locLink = get_permalink(1447);
							$messLink = get_permalink(1458);
							$card = 'הכרטיס שלי';
							$fav = 'מועדפים';
							$loc = 'המיקום שלי';
							$mess = 'הודעות';
						}else{
							$card = 'My card';
							$fav = 'Favorites';
							$loc = 'My Location';
							$mess = 'Messages';
							$messLink = get_permalink(1456);
							$favLink = get_permalink(476);
							$locLink = get_permalink(805);
						}
					?>
						<ul>
							<li class="my-card <?php if(is_page(1442) || is_page(1432)){echo "active";} ?>"><a href="<?php echo $myCardLink ?>"><?=$card ?></a></li>
							<li class="favorites <?php if(is_page(1445) || is_page(476) ){echo "active";} ?>"><a href="<?php echo $favLink ?>"><?=$fav ?></a></li>
							<li class="my-location <?php if(is_page(1447) || is_page(805) ){echo "active";} ?>"><a href="<?php echo $locLink ?>"><?=$loc ?></a></li>
							<li class="messages">
							<?php 
								$newMess = getNewMessages($current_user->ID);
								if(!empty($newMess)):
							?>
							<span class='count'><?=$newMess ?></span>
							<?php endif; ?>
							<a href="<?= $messLink ?>"><?=$mess ?></a></li>
						</ul>
					<?php
						} else {
							if($current_language == 'he'){
								$myBizLink = get_permalink(747);
								$favLink = get_permalink(1445);
								$locLink = get_permalink(1447);
								$messLink = get_permalink(1458);
								$card = 'העסק שלי';
								$fav = 'מועדפים';
								$loc = 'המיקום שלי';
								$mess = 'הודעות';
							}else{
								$card = 'My Business';
								$fav = 'Favorites';
								$loc = 'My Location';
								$mess = 'My messages';
								$favLink = get_permalink(476);
								$locLink = get_permalink(805);
								$myBizLink = get_permalink(126);
								$messLink = get_permalink(1456);
							}
					?>
						<ul>
							<li class="my-card <?php if(is_page(747) || is_page(126) ){echo "active";} ?>"><a href="<?php echo $myBizLink ?>"><?=$card ?></a></li>
							<li class="favorites <?php if(is_page(1445) || is_page(476) ){echo "active";} ?>"><a href="<?php echo $favLink ?>"><?=$fav ?></a></li>
							<li class="my-location <?php if(is_page(1447) || is_page(805) ){echo "active";} ?>"><a href="<?php echo $locLink ?>"><?=$loc ?></a></li>
							<li class="messages"><a href="<?=$messLink ?>"><?=$mess ?></a></li>
						</ul>
					<?php
						}
					?>
				</nav>
				<?php } ?>
				<div id="header-bottom-search">
					<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
						<label>
							<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
							<?php
								global $sitepress;

								$current_language = $sitepress->get_current_language();
								if($current_language == "en") { ?>
									<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Which benefit are you looking for?', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
							<?php } elseif($current_language == "he") { ?>
									<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'איזה עסק אתה מחפש ?', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
							<?php } ?>
						</label>
						<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
					</form>		
				</div>
				<div id="cities">
                                    <form>
<?php 
        if(isset($_SESSION["my_cityz"])) {
                $ucity = $_SESSION["my_cityz"];

                echo '<select style="width:180px;">';
                if($current_language == "en"){
                        echo '<option value="All">All Cities</option>';
                        $args = array(
                                'posts_per_page'   => -1,
                                'orderby'          => 'name',
                                'order'            => 'ASC',
                                'post_type'        => 'city',
                                'suppress_filters' => false,
                                'meta_query' => array(
                                        array(
                                                'key'     => 'active_city',
                                                'value'   => 1,
                                                'compare' => '=',
                                        ),
                                )
                        );
                }
                if($current_language == "he"){
                        echo '<option value="All">כל הערים</option>';
                        $args = array(
                                'posts_per_page'   => -1,
                                'orderby'          => 'name',
                                'order'            => 'ASC',
                                'post_type'        => 'city',
                                'suppress_filters' => false,
                                'meta_query' => array(
                                        array(
                                                'key'     => 'active_city',
                                                'value'   => 1,
                                                'compare' => '=',
                                        ),
                                )
                        );
                }
                echo '<option value="" DISABLED>--------------------------------</option>';
                $cities = get_posts( $args );

                $check = false;
                foreach($cities as $cty) {
                        if($cty->ID != $userCity->ID) {
                                $iclId = icl_object_id($cty->ID, 'city', true, 'en');
                                if($iclId == $ucity){
                                        echo '<option selected value='.$iclId.'">'.$cty->post_title.'</option>';
                                        $check = true;
                                }
                                else{
                                        echo '<option value="'.$iclId.'">'.$cty->post_title.'</option>';
                                }
                        }
                }
                echo '</select>';
                if(!$check){
                        unset($_SESSION["my_cityz"]);
                }
        } else {
                echo '<select style="width:180px;">';
                if($current_language == "en") 
                        echo '<option value="All">All Cities</option>';
                if($current_language == "he") 
                        echo '<option value="All">כל הערים</option>';

                echo '<option value="" DISABLED>--------------------------------</option>';

                $args = array(
                        'posts_per_page'   => -1,
                        'orderby'          => 'name',
                        'order'            => 'ASC',
                        'post_type'        => 'city',
                        'suppress_filters' => false,
                        'meta_query' => array(
                                array(
                                        'key'     => 'active_city',
                                        'value'   => 1,
                                        'compare' => '=',
                                ),
                        )
                );
                $cities = get_posts( $args );

                foreach($cities as $post) {
                        $iclId = icl_object_id($post->ID, 'city', true, 'en');
                        echo '<option value="'.$iclId.'">'.$post->post_title.'</option>';
                }
                echo '</select>';
        }
?>
                                    </form>
				</div>
				
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
