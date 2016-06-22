<?php
/*
 * Template Name: Payment response
 */
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    wp_redirect(home_url());
    die();
}
$response = htmlspecialchars($_POST["Response"]);

$token = htmlspecialchars($_POST["TranzilaTK"]);
if (!$response) {
    wp_redirect(home_url());
    die();
}
//get_header();
?>
<div class="container">
<?php
if ($response !== '000' || !$token) {
    
    ?>
    <p class="status status-failed">Transaction: Failed</p> 
    <p>Error Code: <?php echo $response; ?></p>
    <?php } else {
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
            switch($_POST['sum']){
                case '50': update_field("business_pack", "Premium", $business->ID);
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+1000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    $business_back = "premium_month";
                    $paymentYear = '';
                    $paymentAmount = $_POST['sum'];
                    break;
                case '30': update_field("business_pack", "Basic", $business->ID);
                    $business_back = "basic";
                    $paymentYear = '';
                    $paymentAmount = $_POST['sum'];
                    break;
                case '600': update_field("business_pack", "Premium", $business->ID);
                    update_post_meta($business->ID, 'messages_have', 1500);
                    $business_back = "premium_year";
                    $paymentYear = $paymentDate+34128000;
                    $paymentAmount = $_POST['sum'];
                    break;
                case '20': 
                    $currentPack = get_field("business_pack", $business->ID);
                    if($currentPack == 'Basic'){
                        update_field("business_pack", "Premium", $business->ID);
                        $paymentAmount = '50';
                        update_post_meta($business->ID, 'messages_have', 1000);
                        $business_back = "premium_month";
                        $paymentYear = '';
                    }
                    break;
                case '570': 
                    $currentPack = get_field("business_pack", $business->ID);
                    if($currentPack == 'Basic'){
                        update_field("business_pack", "Premium", $business->ID);
                        $paymentAmount = $_POST['sum'];
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
            switch($_POST['sum']){
                case '20': 
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+1000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    break;
                case '30': 
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+2000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    break;
                case '60': 
                    $mesHave = (int)get_post_meta($business->ID, 'messages_have', true);
                    $mesHave = $mesHave+5000;
                    update_post_meta($business->ID, 'messages_have', $mesHave);
                    break;
                case '100': 
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
        }
    ?>
      <p class="status status-success">Transaction: Succeed</p>
<?php
}

?>    
</div>
<?php //get_footer(); ?>