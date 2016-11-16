<?php
/*
 * Template Name: Homepage
 * Description: Homepage Template.
 */

get_header();
global $wpdb;
global $sitepress;
$currentLanguage = $sitepress->get_current_language();
 ?>
	<div class="container">

		<div id="sidebar">
			<?php get_sidebar(); ?>
		</div>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

        <?php 
            $city = 'all';
            if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All'){
                $city = (int) $_SESSION["my_cityz"];
                
            }
            $query = "SELECT business_id FROM $wpdb->promotions WHERE promo_city = '$city' AND promo_area='mainPromo'";
            $res = $wpdb->get_var($query);

            if(!empty($res)):
                $res = (int) $res;
                $promoLink = get_permalink($res);
                if($currentLanguage == 'he'){
                    $promoLink = str_replace('/business/', '/he/business/', $promoLink);
                }
                $promoTitle = get_the_title($res);
                $promoLogo = get_field("logo", $res);
                if(is_numeric($promoLogo)){
                  $promoLogo = wp_get_attachment_image_src($promoLogo)[0];
                }else{
                  $promoLogo = $promoLogo["url"];
                }
                $promoCity = get_post_meta($res, 'bcity', true);
                $promoCity = get_the_title($promoCity);

        ?>
      				<div class="featured-discount">
      					<div class="discount-preview">
                  <div class="discount-preview-container">
                    <div class="discount-preview-image">
                      <a href="<?=$promoLink?>"><img src="<?=$promoLogo?>"></a>
                    </div>
                    <div class="discount-preview-footer">
                      <div class="discount-preview-title">
                        <a href="<?=$promoLink?>"><?=$promoTitle ?></a>
                      </div>
                      <div class="discount-preview-location">
                        <a href="<?=$promoLink?>"><?=$promoCity?></a>
                      </div>
                    </div>
                  </div>
                </div>
      				</div>
        <?php 
            endif;
           $visibleCategories = get_categories_with_visible_bizs();
        ?>
        <div class="categories-container">
        <?php 
          foreach($visibleCategories as $cat){
              
              $catId = (int) icl_object_id($cat->term_id, 'business_cat', false, 'en');
              $cat = get_term_by('id', $catId, 'business_cat');
              $catTitle = $cat->name;
              //$catTitle = get_the_title($catId);
              $catLink =  get_term_link($catId, 'business_cat');
              ?>
              <div class="category-container">
            <div class="category-header">
              <div class="category-title"><?php _e($catTitle, "mycitycard"); ?></div>
              <div class="category-viewall"><a href="<?=$catLink ?>" class="orange"><?php _e("(View All)", "mycitycard"); ?></a></div>
            </div>
            <div class="category-items">
            <?php
                if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All') {
                    $args = array(
                      'post_type' => 'business',
                      'post_status' => 'publish', 
                      'tax_query' => array(
                        array(
                          'taxonomy' => 'business_cat',
                          'field' => 'id',
                          'terms' => $catId
                        ),
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
                      'showposts' => 3,
                      'meta_key' => 'benefit_created_at',
                        'orderby'  => 'meta_value_num',
                        'order'    => 'DESC',
                    );
              } else {
                $args = array(
                  'post_type' => 'business',
                  'post_status' => 'publish', 
                  'tax_query' => array(
                    array(
                      'taxonomy' => 'business_cat',
                      'field' => 'id',
                      'terms' => $catId
                    )
                  ),
                    'meta_query' => array(
                        'key'     => 'visibility',
                          'value'   => "1"
                    ),
                  'showposts' => 3,
                  'meta_key' => 'benefit_created_at',
                        'orderby'  => 'meta_value_num',
                        'order'    => 'DESC',
                );
              }
              $logoSrc = '';
              $bizs = new WP_Query($args);
              if($bizs->have_posts()):
                while($bizs->have_posts()):
                  $bizs->the_post();
                  $bizId = get_the_id();
                  $bizTitle = get_the_title();
                  $bCity = get_field('bcity', $bizId);
                  $iclBizCity =  icl_object_id($bCity, 'city', false);
                  $city = get_post($iclBizCity);
                  $bCity = $city->post_title;
                  $logo = get_field("logo", $bizId);
                  $link = get_permalink();
                  if($currentLanguage == 'he'){
                      $link = str_replace('/business/', '/he/business/', $link);
                  }
                  if(!empty($logo)){
                    if(is_numeric($logo)){
                          $logoSrc = wp_get_attachment_image_src($logo)[0];
                        }else{
                          $logoSrc = $logo["url"];
                        }
                  }
            ?>
              <div class="category-item">
                <div class="discount-preview">
                  <div class="discount-preview-container">
                    <div class="discount-preview-image">
                      <a href="<?=$link ?>"><img src="<?=$logoSrc ?>" alt="logo"></a>
                    </div>
                    <div class="discount-preview-footer">
                      <div class="discount-preview-title">
                        <a href="<?=$link ?>"><?php _e($bizTitle, "mycitycard"); ?></a>
                      </div>
                      <div class="discount-preview-location">
                        <a href="<?=$link ?>"><?php _e($bCity, "mycitycard"); ?></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!--category-item-->
              <?php 
              endwhile; endif;
              wp_reset_query();
              ?>
            </div> <!--category-items -->
          </div><!--category-container -->
              <?php
          }
        ?>
        </div>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
			if ( is_active_sidebar( 'ads-widgets' ) ) { ?>
			<div id="ads">
				<?php dynamic_sidebar( 'ads-widgets' ); ?>
			</div>
		<?php } ?>
	</div>

<?php get_footer(); ?>
