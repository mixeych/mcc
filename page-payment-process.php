<?php
if(isset($_POST['messages'])){
    $tranz = new MCCTranzillaPayment();
    $res = $tranz->getMessages($_POST['messages']);
    if(!$res){
        wp_redirect(home_url('/payment/'));
        die();
    }
    echo $res;
}else{
    $tranz = new MCCTranzillaPayment();
    $res = $tranz->sendRecurringPayment();
    if(!$res){
        wp_redirect(home_url('/payment/'));
        die();
    }
    echo $res;
}



