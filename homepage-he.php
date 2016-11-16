<?php
/*
 * Template Name: דף הבית - עברית
 * Description: Homepage Template.
 */

get_header(); 
global $wpdb;
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
              $iclId = (int) icl_object_id($cat->term_id, 'business_cat', true, 'he');
              $catTitle = get_term_by('id', $iclId, 'business_cat');
              $catTitle = $catTitle->name;
              $catId = (int) $cat->term_id;
              $catLink =  get_term_link($catId, 'business_cat');
              ?>
              <div class="category-container">
            <div class="category-header">
              <div class="category-title"><?php echo $catTitle; ?></div>
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
                      'orderby' => 'date',
                      'order' => 'DESC',
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
                  'meta_key' => 'visibility',
                  'meta_value' => "1",
                  'showposts' => 3,
                  'orderby' => 'date',
                  'order' => 'DESC',
                );
              }

              $bizs = new WP_Query($args);
              if($bizs->have_posts()):
                while($bizs->have_posts()):
                  $bizs->the_post();
                  $bizId = get_the_id();
                  $bizTitle = get_the_title();
                  $bCity = get_field('bcity', $bizId);
                  $city = get_post($bCity);
                  $bCity = $city->post_title;
                  $logo = $logo = get_field("logo", $bizId);
                  $link = get_permalink();
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
                      <a href="<?=$link ?>"><img src="<?=$logoSrc ?>"></a>
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
