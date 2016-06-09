<?php
if(!class_exists('MCCTranzillaPayment')){
    add_action('wp_ajax_byNewMessages', array( 'MCCTranzillaPayment', 'getMessages' ));
    
    class MCCTranzillaPayment
    {
        private $terminalName = '';
        private $password = '';
        private $tranzillaInfo = array();
        
        public function __construct()
        {
            global $current_user;
            $val = get_option('tranzilla_terminal_name');
            if($val){
                $this->terminalName = $val['input'];
            }
            
            $val = get_option('tranzilla_password');
            if($val){
                $this->password = $val['input'];
            }
            if(!empty(get_user_meta($current_user->ID, 'tranzillaInfo', true))){
                $this->tranzillaInfo = unserialize(get_user_meta($current_user->ID, 'tranzillaInfo', true));
            }
        }
        
        private function sendTransaction ($poststring)
        {
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, 'https://secure5.tranzila.com/cgi-bin/tranzila71pme.cgi' );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec( $ch );
            $error = curl_error( $ch );
            if(!empty($error)){
                return false;
            }
            curl_close( $ch );
            $response =explode('&', $result);
            foreach($response as $key=>$value){
                unset($tmparr);
                $tmparr=explode("=",$value);
                $answer[$tmparr[0]]=$tmparr[1];
            }
            return $answer;
        }
        
        public function sendRecurringPayment()
        {
            global $current_user;
            if(empty($this->tranzillaInfo)||empty($this->terminalName)||empty($this->password)){
                return false;
            }
            $currentTime = time();
            if($currentTime < $this->tranzillaInfo['nextPaymentDate']){
                return false;
            }
            $args = array(
                'author' => $current_user->ID,
                'posts_per_page'   => 1,
                'post_type'        => 'business'
            );
            $business = get_posts( $args ); 
            $business = $business[0];
            if(isset($this->tranzillaInfo['stopPaying'])&&true===$this->tranzillaInfo['stopPaying']){
                $this->tranzillaInfo = array();
                update_field("business_pack", "Free", $business->ID);
                update_user_meta($current_user->ID, 'tranzillaInfo', '');
                return;
            }
            if($this->tranzillaInfo['business_pack'] == 'premium_year'){
                $this->premiumYearUserUpdate();
                return;
            }
            
            if(isset($this->tranzillaInfo['downgrade'])&&$this->tranzillaInfo['downgrade'] === 'basic'){
                $currentPack = 'Basic';
            }else{
                $currentPack = get_field("business_pack", $business->ID);
            }
            update_field("business_pack", "Free", $business->ID);
            
            $formdata = array();
            $formdata['supplier']=$this->terminalName; 
            $formdata['TranzilaPW']=$this->password; 
            $formdata['TranzilaTK']=$this->tranzillaInfo['token']; 
            $formdata['expdate']=$this->tranzillaInfo['expmonth'].$this->tranzillaInfo['expyear'];
            $formdata['sum']=$this->tranzillaInfo['paymentAmount'];
            $formdata['currency']=$this->tranzillaInfo['currency'];
            $formdata['cred_type']=$this->tranzillaInfo['cred_type'];
            $formdata['myid']=$this->tranzillaInfo['id'];
            foreach($formdata AS $key => $val){
                $poststring .= $key . "=" . $val . "&";
            }
            $poststring = substr($poststring, 0, -1);
            $answer = $this->sendTransaction ($poststring);
            if(!$answer){
                return false;
            }
            
            if(isset($answer['Response'])&&$answer['Response']==='000'){
                
                $nextpaymentDate = $currentTime+2592000;
                $this->tranzillaInfo['paymentDate'] = $currentTime;
                $this->tranzillaInfo['nextPaymentDate'] = $nextpaymentDate;
                $ser = serialize($this->tranzillaInfo);
                update_user_meta($current_user->ID, 'tranzillaInfo', $ser);
                update_field("business_pack", $currentPack, $business->ID);
                if($currentPack === "Premium"){
                    update_post_meta($business->ID, 'messages_have', 1000);
                }
                return true;
            }
            return false;
        }
        
        private function premiumYearUserUpdate(){
            global $current_user;
            $currentTime = time();
            $args = array(
                'author' => $current_user->ID,
                'posts_per_page'   => 1,
                'post_type'        => 'business'
            );
            $business = get_posts( $args ); 
            $business = $business[0];
            if($currentTime >= $this->tranzillaInfo['paymentYear']){
                $this->tranzillaInfo = array();
                update_user_meta($current_user->ID, 'tranzillaInfo', '');
                update_field("business_pack", "Free", $business->ID);
                wp_redirect(home_url('/payment/'));
                die();
            }
            
            update_post_meta($business->ID, 'messages_have', 1500);
            $nextpaymentDate = $currentTime+2592000;
            $this->tranzillaInfo['nextPaymentDate'] = $nextpaymentDate;
            $ser = serialize($this->tranzillaInfo);
            update_user_meta($current_user->ID, 'tranzillaInfo', $ser);
            return true;
        }
        
        public function getMessages()
        {
            global $current_user;
            $tranzillaInfo = get_user_meta($current_user->ID, 'tranzillaInfo', true);
            $val = get_option('tranzilla_terminal_name');
            if($val){
                $terminalName = $val['input'];
            }
            $val = get_option('tranzilla_password');
            if($val){
                $password = $val['input'];
            }
            if(empty($tranzillaInfo)||empty($password)||empty($terminalName)){
                echo json_encode(array('success' => false));
                die();
            }
            
            $sum = $_POST['price'];
            $formdata = array();
            $formdata['supplier']=$terminalName; 
            $formdata['TranzilaPW']=$password; 
            $formdata['TranzilaTK']=$tranzillaInfo['token']; 
            $formdata['expdate']=$tranzillaInfo['expmonth'].$tranzillaInfo['expyear'];
            $formdata['sum']=$sum;
            $formdata['currency']=$tranzillaInfo['currency'];
            $formdata['cred_type']=1;
            $formdata['myid']=$tranzillaInfo['id'];
            foreach($formdata AS $key => $val){
                $poststring .= $key . "=" . $val . "&";
            }
            $poststring = substr($poststring, 0, -1);
            $answer = $this->sendTransaction ($poststring);
            if(!$answer||!isset($answer['Response'])||$answer['Response']!=='000'){
                echo json_encode(array('success' => false));
                die();
            }
             $args = array(
                'author' => $current_user->ID,
                'posts_per_page'   => 1,
                'post_type'        => 'business'
            );
            $business = get_posts( $args ); 
            $business = $business[0];
            $currentMessages = (int) get_post_meta($business->ID, 'messages_have', true);
            switch($answer['sum']){
                case '20': $newAmount = $currentMessages+1000;
                    break;
                case '30': $newAmount = $currentMessages+2000;
                    break;
                case '60': $newAmount = $currentMessages+5000;
                    break;
                case '100': $newAmount = $currentMessages+10000;
                    break;
            }
            update_post_meta($business->ID, 'messages_have', $newAmount);
            echo json_encode(array('success' => true, "amount" => $newAmount));
            die();
        }
    }
}


