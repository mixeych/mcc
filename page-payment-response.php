<?php
/*
 * Template Name: Payment response
 */
$sessStatus = session_status();
if($sessStatus == 'PHP_SESSION_DISABLED'||$sessStatus===0 ){
    session_start();
}
if(isset($_SESSION['paymentPage'])){
    $_SESSION['paymentPage'] = 0;
}
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    wp_redirect(home_url());
    die();
}
$response = htmlspecialchars($_POST["Response"]);

$token = htmlspecialchars($_POST["TranzilaTK"]);
if (!$response&&!$token) {
    wp_redirect(home_url());
    die();
}elseif(!$response && $token){
    $user_id = (int) $_POST['MCCUserID'];
    $tranzillaInfo = unserialize(get_user_meta($user_id, 'tranzillaInfo', true));

    $tranzillaInfo['token'] = $_POST['TranzilaTK'];
    $tranzillaInfo['id'] = $_POST['myid'];
    $tranzillaInfo['expmonth'] = $_POST['expmonth'];
    $tranzillaInfo['expyear'] = $_POST['expyear'];
    $tranzillaInfo['cardNumber'] = $_POST['ccno'];
    $ser = serialize($tranzillaInfo);
    update_user_meta($user_id, 'tranzillaInfo', $ser);
}
//get_header();
?>
<div class="container">
<?php
if ($response !== '000') {
    
    ?>
    <p class="status status-failed">Transaction: Failed</p> 
    <p>Error Code: <?php echo $response; ?></p>
    <?php }else {
        $user_id = '';
        if(isset($_POST['MCCUserID'])){
            $user_id = (int) $_POST['MCCUserID'];
        }
        $paymentDate = time();
        $nextpaymentDate = $paymentDate+2592000;
        
        $args = array(
            'author' => $user_id,
            'posts_per_page'   => 1,
            'post_type'        => 'business'
        );
        $business = get_posts( $args ); 
        $business = $business[0];
        if($_POST['sum']&&$_POST['product'] == 'package'){
            $argsSchedule = array($user_id);
            wp_schedule_single_event($nextpaymentDate, 'sendRecurringPayment', $argsSchedule);
            $basic_price = '30';
            $val = get_option('basic_price');
            if($val){
                $basic_price = $val['input'];
            }
            $premium_price = '50';
            $val = get_option('premium_price');
            if($val){
                $premium_price = $val['input'];
            }
            $pay_for_year_price = '600';
            $val = get_option('pay_for_year_price');
            if($val){
                $pay_for_year_price = $val['input'];
            }
            $basic_to_premium = '20';
            $val = get_option('basic_to_premium');
            if($val){
                $basic_to_premium = $val['input'];
            }
            $basic_to_premium_year = '570';
            $val = get_option('basic_to_premium_year');
            if($val){
                $basic_to_premium_year = $val['input'];
            }
            switch($_POST['sum']){
                case $premium_price: update_field("business_pack", "Premium", $business->ID);
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+1000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    $business_back = "premium_month";
                    $paymentYear = '';
                    $paymentAmount = $_POST['sum'];
                    break;
                case $basic_price: update_field("business_pack", "Basic", $business->ID);
                    $business_back = "basic";
                    $paymentYear = '';
                    $paymentAmount = $_POST['sum'];
                    break;
                case $pay_for_year_price: update_field("business_pack", "Premium", $business->ID);
                    update_post_meta($business->ID, 'messages_have', 1500);
                    $business_back = "premium_year";
                    $paymentYear = $paymentDate+34128000;
                    $paymentAmount = $_POST['sum'];
                    break;
                case $basic_to_premium: 
                    $currentPack = get_field("business_pack", $business->ID);
                    if($currentPack == 'Basic'){
                        update_field("business_pack", "Premium", $business->ID);
                        $paymentAmount = $premium_price;
                        update_post_meta($business->ID, 'messages_have', 1000);
                        $business_back = "premium_month";
                        $paymentYear = '';
                    }
                    break;
                case $basic_to_premium_year: 
                    $currentPack = get_field("business_pack", $business->ID);
                    if($currentPack == 'Basic'){
                        update_field("business_pack", "Premium", $business->ID);
                        $paymentAmount = $pay_for_year_price;
                        update_post_meta($business->ID, 'messages_have', 1500);
                        $business_back = "premium_year";
                        $paymentYear = $paymentDate+34128000;
                    }
                    break;
            }
            $tranzillaArr = array(
                'token' => $token,
                'id' =>  $_POST['myid'],
                'expmonth' => $_POST['expmonth'],
                'expyear' => $_POST['expyear'],
                'cardNumber' => $_POST['ccno'],
                'paymentAmount' => $paymentAmount,
                'paymentDate' => time(),
                'nextPaymentDate' => $nextpaymentDate,
                'cred_type' => $_POST['cred_type'],
                'currency' => $_POST['currency'],
                'business_pack' => $business_back,
                'paymentYear' => $paymentYear,
            );
            $ser = serialize($tranzillaArr);
            update_user_meta($user_id, 'tranzillaInfo', $ser);
        }elseif($_POST['sum']&&$_POST['product'] == 'messages'){
            $t1_price = '20';
            $val = get_option('1000_messages');
            if($val){
                $t1_price = $val['input'];
            }
            $t2_price = '30';
            $val = get_option('2000_messages');
            if($val){
                $t2_price = $val['input'];
            }
            $t5_price = '60';
            $val = get_option('5000_messages');
            if($val){
                $t5_price = $val['input'];
            }
            $t10_price = '100';
            $val = get_option('10000_messages');
            if($val){
                $t10_price = $val['input'];
            }
           
            switch($_POST['sum']){
                case $t1_price: 
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+1000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    break;
                case $t2_price: 
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+2000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    break;
                case $t5_price: 
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+5000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    break;
                case $t10_price: 
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+10000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    break;
            }
            $tranzillaInfo = unserialize(get_user_meta($user_id, 'tranzillaInfo', true));
            if(!empty($tranzillaInfo)&&is_array($tranzillaInfo)){
                if(empty($tranzillaInfo['token'])){
                    $tranzillaInfo['token'] = $token;
                    $tranzillaInfo['expmonth'] = $_POST['expmonth'];
                    $tranzillaInfo['expyear'] = $_POST['expyear'];
                    $tranzillaInfo['cardNumber'] = $_POST['ccno'];
                }
                $ser = serialize($tranzillaInfo);
                update_user_meta($user_id, 'tranzillaInfo', $ser);
            }
            ?>
            <script>
//                setTimeout(function(){
//                    window.location = '<?php echo home_url('payment') ?>';
//                }, 1000);
            </script>
            <?php
        }
    ?>
      <p class="status status-success">Transaction: Succeed</p>
<?php
}

?>    
</div>
<?php //get_footer(); ?>