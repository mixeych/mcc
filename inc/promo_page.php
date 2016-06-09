<?php 
global $current_user;
$cities;
if( current_user_can( 'administrator' )||current_user_can( 'country_manager' ) ){
	$cities = 'all';
	echo "<h3>COUNTRY MANAGER USER</h3>";
}else{

	echo "<h3>CITY MANAGER USER</h3>";
}
$categ = (int) trim(strip_tags($_GET['cat']));
if(!isset($paged)){
       $paged = $_GET['paged'];
    }else{
        $paged = 1;
    }
?>
<div class="wrap">
	<?php 
		if(current_user_can( 'city_manager' )){
			$cities = get_user_meta( $current_user->ID, 'manage_city', true );
			foreach($cities as $city):
				$cityTitle = get_the_title($city);
			?>
			<a href="?page=promotions&city=<?=$city ?>"><?=$cityTitle ?></a>|
			<?php
			endforeach;
		}

        if(current_user_can( 'administrator' ) || current_user_can( 'country_manager' )|| isset($_GET['city'])):
	?>
    	<?php 
            $args = array('type' => 'business', 'parent' => 0, 'taxonomy' => 'business_cat', 'hide_empty' => 0);
            $categories = get_categories($args);
        ?>

        <form method='get' action='?page=promotions<?=(isset($_GET['city']))?"&city=".$_GET['city']:'' ?>'>
            <select id='select-category' name='cat'>
            <option value="">All categories</option>
            <?php 
                foreach($categories as $cat){
                    ?>
                    <option value="<?=$cat->term_id ?>" <?php  if(isset($categ)&&$categ==$cat->term_id ){echo "selected";} ?> ><?=$cat->cat_name ?></option>
                    <?php
                }
            ?>
            </select>
            <br>
        </form>
        <?php endif; ?>
	<div class="table-benefit">
	<?php
	global $current_user;
    global $wpdb;
    
    
    if( current_user_can( 'administrator' ) || current_user_can( 'country_manager' ) ):

        if(empty($categ)){
            $args = array(
                'post_type' => 'business',
                'showposts' => 15,
                'paged' => $paged,
                'meta_key' => 'visibility',
                'meta_value' => '1',
                'orderby' => 'date',
                'order' => 'DESC'
            );
        }else{

            $args = array(
                'post_type' => 'business',
                'showposts' => 15,
                'paged' => $paged,
                'meta_key' => 'visibility',
                'meta_value' => '1',
                'orderby' => 'date',
                'order' => 'DESC',
                'tax_query' => array(
                        array(
                            'taxonomy' => 'business_cat',
                            'field'    => 'id',
                            'terms'    => $categ
                        ),
                    ),
            );
        }

        
        $caps = 'all';

    $biz = new WP_Query( $args );
    if($biz->have_posts()):
    ?>
        <table class="wp-list-table widefat fixed striped benefits">
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Category</th>
                    <?php if(empty($categ) ): ?>
                    <th>Main promo</th>
                <?php else: ?>
                    <th>Category promo</th>
                <?php endif; ?>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($biz->have_posts()):
                        $biz->the_post();
                        $bizId = get_the_id();
                        $title = get_the_title();
                        $logo = get_field('logo', $bizId);
                        $cityId = get_field('bcity', $bizId);
                        $city = get_the_title($cityId);
                        $short_desc = get_field("field_554775a23e29e", $bizId);
                        $address = get_field("address", $bizId);
                        $bizCategory = wp_get_object_terms(array($bizId), 'business_cat');
                        $bizCategory = $bizCategory[0]->name;
                        
                        if(empty($categ) ){
                            $query = "SELECT promo_id FROM $wpdb->promotions WHERE business_id = $bizId AND promo_city='all'
                                AND promo_area='mainPromo'";
                        }else{
                             $query = "SELECT promo_id FROM $wpdb->promotions WHERE business_id = $bizId AND promo_city='all'
                                AND promo_area='$categ'";

                        }
                        
                        $res = $wpdb->get_var( $query );
                        $promoArea = 0;
                        if(!empty($res)){
                            $promoArea = 1;
                        }
                        if(!empty($logo)){
                            if(is_numeric($logo)){
                                $logoSrc = wp_get_attachment_image_src($logo)[0];
                            }else{
                                $logoSrc = $logo["url"];
                            }
                        }
                        ?>
                            <tr>
                                <td><img class="biz-logo" src="<?=$logoSrc ?>" /></td>
                                <td><?=$title ?></td>
                                <td><?=$short_desc ?></td>
                                <td><?=$address ?></td>
                                <td><?=$city ?></td>
                                <td><?=$bizCategory ?></td>
                                <?php 
                                    if(empty($categ) ):
                                ?>
                                <td class="<?=$caps ?>"><img data-cat="" data-biz="<?=$bizId ?>" class="star main-promo <?php if($promoArea){echo "promo";} ?>" src="<?php bloginfo('template_url') ?>/images/star.png"></td>
                                    <?php else: ?>
                                <td class="<?=$caps ?>"><img data-cat="<?=$categ ?>" data-biz="<?=$bizId ?>" class="star category-promo <?php if( $promoArea  ){echo "promo";} ?>" src="<?php bloginfo('template_url') ?>/images/star.png"></td>
                                    <?php endif; ?>
                            </tr>
                        
                    <?php endwhile; ?>
                    
            </tbody>
            <tfoot>
                <tr>
                    
                </tr>
            </tfoot>
        </table>
        <?php
            echo paginate_links( array(
               'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
               'format'       => '',
               'add_args'     => '',
               'current'      => $paged,
               'total'        => $biz->max_num_pages,
               'prev_text'    => '&larr;',
               'next_text'    => '&rarr;',
               'type'         => 'plain',
                'end_size'     => 3,
               'mid_size'     => 3
            ) );   
    	?>
    <?php 
    	endif; 
    	wp_reset_query();
    ?>
	<?php else: 
		if(!empty($_GET['city'])):

			$city = (int) $_GET['city'];
            if(empty($categ)){
    			$args = array(
    	            'post_type' => 'business',
    	            'meta_query' => array(
    	                                array(
    	                                    'key'   => 'bcity',
    	                                    'value' => $city,
    	                                ),
    	                                array(
    	                                    'key'     => 'visibility',
    	                                    'value'   => "1",
    	                                ),
    	                            ),
    	            'showposts' => 15,
    	            'paged' => $paged,
    	            'orderby' => 'date',
    	            'order' => 'DESC'
    	        );
            }else{
                $args = array(
                    'post_type' => 'business',
                    'meta_query' => array(
                                        array(
                                            'key'   => 'bcity',
                                            'value' => $city,
                                        ),
                                        array(
                                            'key'     => 'visibility',
                                            'value'   => "1",
                                        ),
                                    ),
                    'tax_query' => array(
                                array(
                                'taxonomy' => 'business_cat',
                                'field'    => 'id',
                                'terms'    => $categ
                            ),
                        ),
                    'showposts' => 15,
                    'paged' => $paged,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
            }
        	$caps = 'city';

        	 $biz = new WP_Query( $args );
    		if($biz->have_posts()):
    ?>
        <table class="wp-list-table widefat fixed striped benefits">
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Category</th>
                    <?php if(empty($categ) ): ?>
                    <th>Main promo</th>
                <?php else: ?>
                    <th>Category promo</th>
                <?php endif; ?>
                    <?php 
                       /* if( current_user_can( 'administrator' ) ){
                            ?>
                            <th></th>
                            <?php
                        }*/
                    ?>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($biz->have_posts()):
                        $biz->the_post();
                        $bizId = get_the_id();
                        $title = get_the_title();
                        $logo = get_field('logo', $bizId);
                        $cityId = get_field('bcity', $bizId);
                        $city = get_the_title($cityId);
                        $short_desc = get_field("field_554775a23e29e", $bizId);
                        $address = get_field("address", $bizId);
                        $bizCategory = wp_get_object_terms(array($bizId), 'business_cat');
                        $bizCategory = $bizCategory[0]->name;
                        if(empty($categ) ){
                            $query = "SELECT promo_id FROM $wpdb->promotions WHERE business_id = $bizId AND promo_city='$cityId'
                                AND promo_area='mainPromo'";
                        }else{
                             $query = "SELECT promo_id FROM $wpdb->promotions WHERE business_id = $bizId AND promo_city='$cityId'
                                AND promo_area='$categ'";
                        }

                        $res = $wpdb->get_var( $query );

                        $promoArea = 0;
                        if(!empty($res)){
                            $promoArea = 1;
                        }
                        if(!empty($logo)){
                            if(is_numeric($logo)){
                                $logoSrc = wp_get_attachment_image_src($logo)[0];
                            }else{
                                $logoSrc = $logo["url"];
                            }
                        }
                        ?>
                            <tr>
                                <td><img class="biz-logo" src="<?=$logoSrc ?>" /></td>
                                <td><?=$title ?></td>
                                <td><?=$short_desc ?></td>
                                <td><?=$address ?></td>
                                <td><?=$city ?></td>
                                <td><?=$bizCategory ?></td>
                                <?php if(empty($categ)): ?>
                                <td class="<?=$caps ?>"><img data-cat="" data-biz="<?=$bizId ?>" class="star main-promo <?php if( 
                                $promoArea ){echo "promo";} ?>" src="<?php bloginfo('template_url') ?>/images/star.png"></td>
                            <?php else: ?>
                                <td class="<?=$caps ?>"><img data-cat="<?=$categ ?>" data-biz="<?=$bizId ?>" class="star category-promo <?php if( $promoArea ){echo "promo";} ?>" src="<?php bloginfo('template_url') ?>/images/star.png"></td>
                                <?php 
                                endif;
                                ?>
                            </tr>
                        <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    
                </tr>
            </tfoot>
        </table>
        <?php
            echo paginate_links( array(
               'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
               'format'       => '',
               'add_args'     => '',
               'current'      => $paged,
               'total'        => $biz->max_num_pages,
               'prev_text'    => '&larr;',
               'next_text'    => '&rarr;',
               'type'         => 'plain',
                'end_size'     => 3,
               'mid_size'     => 3,
            ) );   
    	?>

	<?php endif; endif; endif; ?>
	</div>

</div>