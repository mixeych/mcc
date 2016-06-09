<?php
if(!class_exists('MCCShortcodes')){
    class MCCShortcodes
    {
        public function __construct()
        {
            add_shortcode('mcc_custom_login_form', array($this, 'customLoginFormShortcode'));
        }
        
        public function customLoginFormShortcode($atts)
        {
            
            if(empty($atts)){
                $atts = array();
            }
            $args = array(
                'echo' => true,
                'redirect' => site_url(), 
                'form_id' => 'loginform',
                'label_username' => __( 'Email' ),
                'label_password' => __( 'Password' ),
                'label_remember' => __( 'Remember Me' ),
                'label_log_in' => __( 'Log In' ),
                'id_username' => 'user_login',
                'id_password' => 'user_pass',
                'id_remember' => 'rememberme',
                'id_submit' => 'wp-submit',
                'remember' => true,
                'value_username' => NULL,
                'value_remember' => false 
            );
            
            $args = array_merge($args, $atts);
            if(isset($_GET['checkemail'])&&$_GET['checkemail']=='confirm'){
                echo '<p class="error">Check your email for verification link</p>';
            }
            if(isset($_GET['user'])&&$_GET['user']=='notactivated'){
                echo '<p class="error">Your user still not active</p>';
            }
            if(isset($_GET['user'])&&$_GET['user']=='invalid'){
                echo '<p class="error">Bad username or password</p>';
            }
            wp_login_form( $args );
            do_action( 'wordpress_social_login' );
            global $sitepress;
            $current_language = $sitepress->get_current_language();
            if($current_language == 'en') {
                echo '<a href="#" class="popmake-business-registration" style="cursor: pointer;">Business Registration</a> | <a class="popmake-customer-register" href="javascript:void(0)">User Registration</a>';
            }
            if($current_language == 'he') {
                    echo '<a href="#" class="popmake-business-registration" style="cursor: pointer;">רישום עסק</a> | <a class="popmake-customer-register" href="javascript:void(0)">רישום משתמש</a';
            }?>
            <div class='on-page'>
                <a class="popmake-resend-verification-link" href="#">resend verification link</a>
            
            </div>
        <?php
        }
        
    }
    $MCCShortcodes = new MCCShortcodes();
}


