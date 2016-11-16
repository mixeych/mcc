<?php
$sessStatus = session_status();
if($sessStatus == 'PHP_SESSION_DISABLED'||$sessStatus===0 ){
    session_start();
}
if($_SERVER['REQUEST_METHOD'] === 'POST'&&($_SERVER['HTTP_REFERER']===home_url('/payment/')||$_SERVER['HTTP_REFERER']===home_url('he/payment/'))&&isset($_POST['messages'])&&isset($_SESSION['paymentPage'])){
    global $current_user;
    $_SESSION['paymentPage'] = 0;
    $tranz = new MCCTranzillaPayment($current_user);

    $res = $tranz->getMessages($_POST['messages']);
    if(!$res){
        wp_redirect(home_url($_SERVER['HTTP_REFERER']));
        die();
    }
    echo $res;
}else{
    if(isset($_GET['requiringpayment'])&&$_GET['requiringpayment']=='1'){
        global $current_user;
        $tranz = new MCCTranzillaPayment();
        $res = $tranz->sendRecurringPayment($current_user);
        if(!$res){
            wp_redirect(home_url('/payment/'));
            die();
        }
        echo $res;
    }else{
        wp_redirect(home_url('/payment/'));
        die();
    }
}



