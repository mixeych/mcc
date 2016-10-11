<?php 
/**
* Add admin page 'Theme options' with custom theme options
*
*/


function add_admin_scripts(){
    wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin.css');
    wp_enqueue_style( 'custom_wp_admin_css' );
    wp_register_script( 'custom_wp_admin_js', get_template_directory_uri() . '/js/admin.js');
    wp_enqueue_script( 'custom_wp_admin_js' );
}

add_action('admin_enqueue_scripts', 'add_admin_scripts');

function promo_page(){
    require_once get_template_directory() . '/inc/promo_page.php';
}

function admin_my_menu(){
    add_menu_page('Theme options', 'Theme options', 'manage_options', 'theme-options', 'add_theme_options', '', 61);
    add_submenu_page('theme-options', 'Country managers', 'Country managers', 'manage_categories', 'country_managers', 'country_managers_page');
    add_submenu_page('theme-options', 'City managers', 'City managers', 'manage_categories', 'city-managers', 'city_managers_page');
    add_submenu_page('theme-options', 'Promotions', 'Promotions', 'manage_bens', 'promotions', 'promo_page');
    add_submenu_page('theme-options', 'Tranzilla Settings', 'Tranzilla Settings', 'manage_options', 'tranzilla-options', 'tranzilla_options_page');
}

add_action( 'admin_menu', 'admin_my_menu' );

function country_managers_page(){
    require_once get_template_directory() . '/inc/country_managers_page.php';
}

function city_managers_page(){
    require_once get_template_directory() . '/inc/city_managers_page.php';
}

function tranzilla_options_page(){
    ?>
    <div class="wrap">
        <form action="options.php" method="POST">
            <?php settings_fields( 'tranzilla_settings' ); ?>                    
            <?php do_settings_sections( 'tranzilla-options' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
	<?php
}

function add_theme_options(){
	?>
	<div class="wrap">
        <form action="options.php" method="POST">
            <?php settings_fields( 'theme_setting' ); ?>                      
            <?php do_settings_sections( 'theme-options' ); ?>
            <?php do_settings_sections( 'contact-links' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
	<?php
}
function tranzilla_password_callback(){
    
    $val = get_option('tranzilla_password');
    if($val){
        $val = $val['input'];
    }
    
    ?>
    
    <input name="tranzilla_password[input]" type="password" value="<?php echo $val ?>" />
    <?php
}

function tranzilla_terminal_name_callback(){
    $val = get_option('tranzilla_terminal_name');
    if($val){
        $val = $val['input'];
    }
    ?>
    <input name="tranzilla_terminal_name[input]" type="test" value="<?php echo $val ?>" />
    <?php
}

add_action('admin_init', 'add_download_setting');
function add_download_setting(){
    register_setting( 'theme_setting', 'categories_order' );
    register_setting( 'theme_setting', 'facebook_link' );
    register_setting( 'theme_setting', 'twitter_link' );
    register_setting( 'theme_setting', 'contact_email' );
    register_setting('tranzilla_settings', 'tranzilla_terminal_name');
    register_setting('tranzilla_settings', 'token_password');
    register_setting('tranzilla_settings', 'token_login');
    register_setting('tranzilla_settings', 'basic_price');
    register_setting('tranzilla_settings', 'premium_price');
    register_setting('tranzilla_settings', 'pay_for_year_price');
    register_setting('tranzilla_settings', 'basic_to_premium');
    register_setting('tranzilla_settings', 'basic_to_premium_year');
    register_setting('tranzilla_settings', '1000_messages');
    register_setting('tranzilla_settings', '2000_messages');
    register_setting('tranzilla_settings', '5000_messages');
    register_setting('tranzilla_settings', '10000_messages');
    add_settings_section( 'theme_options', 'Theme options', '', 'theme-options' );
    add_settings_section( 'contact-links', 'Contact Links', '', 'theme-options' );
    add_settings_section( 'tranzilla_sections', 'Tranzilla Settings', '', 'tranzilla-options' );
    
    add_settings_field(
        'tranzilla_terminal_name',
        'Terminal Name',
        'tranzilla_terminal_name_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        'token_login',
        'Token Login',
        'token_login_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        'token_password',
        'Token password',
        'token_password_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        'basic_price',
        'Basic price',
        'basic_price_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        'premium_price',
        'Premium price',
        'premium_price_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        'pay_for_year_price',
        'Pay for year premium price',
        'pay_for_year_price_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        'basic_to_premium',
        'From basic to premium price',
        'basic_to_premium_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        'basic_to_premium_year',
        'From basic to premium for year price',
        'basic_to_premium_year_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        '1000_messages',
        '1000 messages price',
        't1_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        '2000_messages',
        '2000 messages price',
        't2_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        '5000_messages',
        '5000 messages price',
        't5_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    add_settings_field(
        '10000_messages',
        '10000 messages price',
        't10_callback',
        'tranzilla-options', // page
        'tranzilla_sections' // section
    );
    
    add_settings_field(
        'categories_order',
        'Order of the main categories',
        'categories_order_callback',
        'theme-options', // page
        'theme_options' // section
    );
    add_settings_field(
        'facebook_link',
        'Facebook link',
        'facebook_link_callback',
        'theme-options', // page
        'contact-links' // section
    );
    add_settings_field(
        'twitter_link',
        'Twitter link',
        'twitter_link_callback',
        'theme-options', // page
        'contact-links' // section
    );
    add_settings_field(
        'contact_email',
        'Contact Email',
        'contact_email_callback',
        'theme-options', // page
        'contact-links' // section
    );
    
}

function categories_order_callback(){
    
    $val = get_option('categories_order');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <ul class='categories-order'>
        <li><label>Sort by name <input name="categories_order[input]" type="radio" value="name" <?php if($val == 'name'){echo 'checked'; } ?> /></label></li>
        <li><label>Sort by date   <input name="categories_order[input]" type="radio" value="ID" <?php if($val == 'ID'){echo 'checked'; } ?> /></label></li>
        <li><label>Sort by count <input name="categories_order[input]" type="radio" value="count" <?php if($val == 'count'){echo 'checked'; } ?> /></label></li>
        <li><label>Sort by number of visible businesses <input name="categories_order[input]" type="radio" value="visible" <?php if($val == 'visible'){echo 'checked'; } ?> /></label></li>
        <li><label>Sort by Yaron <input name="categories_order[input]" type="radio" value="yaron" <?php if($val == 'yaron'){echo 'checked'; } ?> /></label></li>
    </ul>
    <?php
}

function basic_price_callback(){
    
    $val = get_option('basic_price');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="basic_price[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function t1_callback(){
    
    $val = get_option('1000_messages');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="1000_messages[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function t2_callback(){
    
    $val = get_option('2000_messages');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="2000_messages[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function t5_callback(){
    
    $val = get_option('5000_messages');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="5000_messages[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function t10_callback(){
    
    $val = get_option('10000_messages');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="10000_messages[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function basic_to_premium_year_callback(){
    
    $val = get_option('basic_to_premium_year');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="basic_to_premium_year[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function basic_to_premium_callback(){
    
    $val = get_option('basic_to_premium');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="basic_to_premium[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function pay_for_year_price_callback(){
    
    $val = get_option('pay_for_year_price');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="pay_for_year_price[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function premium_price_callback(){
    
    $val = get_option('premium_price');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="premium_price[input]" type="number" value="<?php echo $val ?>" />
    <?php
}
function facebook_link_callback(){
    
    $val = get_option('facebook_link');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="facebook_link[input]" type="text" value="<?php echo $val ?>" />
    <?php
}
function token_login_callback(){
    
    $val = get_option('token_login');
    if($val){
        $val = $val['input'];
    }
    
    ?>
    
    <input name="token_login[input]" type="text" value="<?php echo $val ?>" />
    <?php
}
function token_password_callback(){
    
    $val = get_option('token_password');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="token_password[input]" type="password" value="<?php echo $val ?>" />
    <?php
}

function twitter_link_callback(){
    
    $val = get_option('twitter_link');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="twitter_link[input]" type="text" value="<?php echo $val ?>" />
    <?php
}

function contact_email_callback(){
	
    $val = get_option('contact_email');
    if($val){
        $val = $val['input'];
    }
    ?>
    
    <input name="contact_email[input]" type="text" value="<?php echo $val ?>" />
    <?php
}


add_action('wp_ajax_manageCountry', 'add_manage_country_to_user');
function add_manage_country_to_user(){
    $json = $_POST['data'];
    $data = json_decode(stripcslashes($_POST['data']));
    foreach ($data as $id => $country) {
        update_user_meta($id, 'manage_country', $country);
    }
}

add_action('wp_ajax_manageCity', 'add_manage_city_to_user');
function add_manage_city_to_user(){
    $json = $_POST['data'];
    $data = json_decode(stripcslashes($_POST['data']));
    foreach ($data as $key => $cities) {
        $arr = explode('_', $key);
        $userId = $arr[1];
        update_user_meta($userId, 'manage_city', $cities); 
    }
}

add_action('wp_ajax_selectBenefitsByCat', 'selectBenefitsByCat');
function selectBenefitsByCat(){
    global $current_user;
    global $wpdb;
    $cat = $_POST['cat'];
    /*if(!isset($paged)){
       $paged = $_POST['paged'];
   }else{
        $paged = 1;
   }*/
    
    if( current_user_can( 'administrator' ) || current_user_can( 'country_manager' ) ){
        $args = array(
            'post_type' => 'business',
            'business_cat' => $cat,
            'showposts' => -1,
            'meta_key' => 'visibility',
            'meta_value' => '1',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $caps = 'all';
    }elseif( current_user_can('city_manager') ){

        $cityUser = get_user_meta( $current_user->ID, 'manage_city', true );
        $city = trim(strip_tags($_POST['city']));
        $city = (empty($city))?$cityUser:$city;
        $args = array(
            'post_type' => 'business',
            'business_cat' => $cat,
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
            'showposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $caps = 'city';
    }
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
                    <th>Main promo</th>
                    <th>Category promo</th>
                    <?php 
                        if( current_user_can( 'administrator' ) ){
                            ?>
                            <th></th>
                            <?php
                        }
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
                        if($caps == 'all'){
                            $query = "SELECT promo_area FROM $wpdb->promotions WHERE business_id = $bizId AND promo_city='all'";
                        }else{
                            $query = "SELECT promo_area FROM $wpdb->promotions WHERE business_id = $bizId AND promo_city='$cityId'";
                        }
                        $res = $wpdb->get_results( $query );
                        $promoArea = array();
                        if(!empty($res)){
                            foreach ($res as $row) {
                                $promoArea[] = $row->promo_area;
                            }
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
                                <td class="<?=$caps ?>"><img data-biz="<?=$bizId ?>" class="star main-promo <?php if( in_array('mainPromo', $promoArea)  ){echo "promo";} ?>" src="<?php bloginfo('template_url') ?>/images/star.png"></td>
                                <td class="<?=$caps ?>"><img data-biz="<?=$bizId ?>" data-category="<?=$cat ?>" class="star category-promo <?php if( in_array('categoryPromo', $promoArea)  ){echo "promo";} ?>" src="<?php bloginfo('template_url') ?>/images/star.png"></td>
                                <?php 
                                    if( current_user_can( 'administrator' ) ){
                                        ?>
                                        <td>
                                        <select class="select-caps" name="caps">
                                            <option value="all">All cities</option>
                                            <option value="city">Business city</option>
                                        </select>
                                        </td>
                                        <?php
                                    }
                                ?>
                            </tr>

                        <?php
                            
                        
                ?>
                        
                    <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
    <?php
    die();
}


add_action('wp_ajax_addPromoBusiness', 'addPromoBusiness');
function addPromoBusiness(){
    header("Content-type:application/json"); 
    global $current_user;
    global $wpdb;
    $city = $_POST['city'];
    if($city == 'all' && !current_user_can( 'administrator' ) && !current_user_can( 'country_manager' )){
        echo json_encode(array('success' => false));
        die();
    }
    $bizId = (int) $_POST['bizId'];
    $area = $_POST['area'];
    if($city == 'city'){
        $city = get_post_meta($bizId, 'bcity', true);
    }
    $query = "SELECT promo_id FROM $wpdb->promotions WHERE business_id = $bizId
                AND promo_city = '$city'
                AND promo_area = '$area'";
    $res = $wpdb->get_var( $query );
    if(!empty($res)){
        echo json_encode(array('success' => false, 'message' => 'you already added promotion for this business'));
        die();
    }
   
    $query = "SELECT business_id FROM $wpdb->promotions
                    WHERE  promo_city = '$city' 
                    AND promo_area = '$area' ";
    $res = $wpdb->get_results($query);
    if( $area == 'mainPromo' ){
        $limit = 0;
    }else{
        $limit = 2;
    }
    if( count($res) > $limit ){
        echo json_encode(array('success' => false, 'message' => 'you already have promotions for this place'));
        die();
    }
    $res = $wpdb->insert( $wpdb->promotions, array('business_id' =>$bizId, 'promo_city' => $city, 'promo_area' => $area ), array('%d', '%s', '%s') );
    if($res){
        echo json_encode(array('success' => true));
        die();
    }else{
        echo json_encode(array('success' => false));
        die();
    } 
}

add_action('wp_ajax_removePromoBusiness', 'removePromoBusiness');
function removePromoBusiness(){
    header("Content-type:application/json"); 
    global $current_user;
    global $wpdb;
    $city = $_POST['city'];
    if($city == 'all' && !current_user_can( 'administrator' ) && !current_user_can( 'country_manager' )){
        echo json_encode(array('success' => false));
        die();
    }
    $bizId = (int) $_POST['bizId'];
    $area = $_POST['area'];
    if($city == 'city'){
        $city = (int) get_post_meta($bizId, 'bcity', true);
    }
    $res = $wpdb->delete( $wpdb->promotions, array( 'business_id' => $bizId, 'promo_city'=> $city, 'promo_area'=> $area), array( '%d', '%s', '%s' ) );
    if(!empty($res)){
        echo json_encode(array('success' => true));
        die();
    }else{
        echo json_encode(array('success' => false));
        die();
    }
}

add_action('wp_ajax_checkPromoBusiness', 'checkPromoBusiness');
function checkPromoBusiness(){
    header("Content-type:application/json"); 
    global $current_user;
    global $wpdb;
    $city = $_POST['city'];
    if($city == 'all' && !current_user_can( 'administrator' ) && !current_user_can( 'country_manager' )){
        echo json_encode(array('success' => false));
        die();
    }
    $bizId = (int) $_POST['bizId'];
    if($city == 'city'){
        $city = (int) get_post_meta($bizId, 'bcity', true);
    }
    $query = "SELECT promo_area FROM $wpdb->promotions WHERE business_id = $bizId
                AND promo_city = '$city'";
    $res = $wpdb->get_results($query);
    if(empty($res)){
        echo json_encode(array('success' => false));
        die();
    }else{
        $main = false;
        $categ = false;
        if(is_array($res)){
            foreach($res as $row){
                if($row->promo_area == 'categoryPromo'){
                    $categ = true;
                }elseif($row->promo_area == 'mainPromo'){
                    $main = true;
                }
            }
        }
        echo json_encode(array('success' => true, 'main'=>$main, 'category' =>$categ  ));
        die();
    }
}

?>