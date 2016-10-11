<?php
if(!class_exists('MCCTranzillaPayment')){
    add_action('wp_ajax_byNewMessages', array( 'MCCTranzillaPayment', 'getMessages' ));
    
    class MCCTranzillaPayment
    {
        private $terminalName = '';
        private $password = '';
        private $tokenLogin = '';
        private $tokenPassword = '';
        private $tranzillaInfo = array();
        
        public function __construct()
        {
            global $current_user;
            $val = get_option('tranzilla_terminal_name');
            if($val){
                $this->terminalName = $val['input'];
            }
            
//            $val = get_option('tranzilla_password');
//            if($val){
//                $this->password = $val['input'];
//            }
            $val = get_option('token_login');
            if($val){
                $this->tokenLogin = $val['input'];
            }
            $val = get_option('token_password');
            if($val){
                $this->tokenPassword = $val['input'];
            }
            if(!empty(get_user_meta($current_user->ID, 'tranzillaInfo', true))){
                $this->tranzillaInfo = unserialize(get_user_meta($current_user->ID, 'tranzillaInfo', true));
            }
        }
        
        public function sendTransaction ($poststring)
        {
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, 'https://secure5.tranzila.com/cgi-bin/tranzila71pme.cgi' );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_REFERER, "http://www.online-kharkov.com/payment/");
            $result = curl_exec( $ch );
            $error = curl_error( $ch );
            if(!empty($error)){
                return false;
            }
            curl_close( $ch );
            return $result;
        }
        
        public function sendRecurringPayment($current_user)
        {
            if(empty($this->tranzillaInfo)||empty($this->tokenLogin)||empty($this->tokenPassword)){
                return false;
            }
            $currentTime = time();
            $args = array(
                'author' => $current_user->ID,
                'posts_per_page'   => 1,
                'post_type'        => 'business'
            );
            update_field("business_pack", "Free", $business->ID);
            if(!isset($this->tranzillaInfo['nextPaymentDate'])||empty($this->tranzillaInfo['nextPaymentDate'])){
                return false;
            }
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
            
            if(isset($this->tranzillaInfo['downgrade'])&&$this->tranzillaInfo['downgrade'] === 'basic'){
                $currentPack = 'Basic';
            }else{
                $currentPack = get_field("business_pack", $business->ID);
            }
            if(empty($this->tranzillaInfo['token'])){
                return false;
            }
            $formdata = array();
            $formdata['supplier']=$this->tokenLogin; 
            $formdata['TranzilaPW']=$this->tokenPassword; 
            $formdata['TranzilaTK']=$this->tranzillaInfo['token']; 
            $formdata['expdate']=$this->tranzillaInfo['expmonth'].$this->tranzillaInfo['expyear'];
            $formdata['sum']=$this->tranzillaInfo['paymentAmount'];
            $formdata['currency']=$this->tranzillaInfo['currency'];
            $formdata['cred_type']=1;
            $formdata['product']='package';
            $formdata['MCCUserID']=$current_user->ID;
            $formdata['email']=$current_user->user_email;
            $formdata['contact']=$current_user->display_name;
            $formdata['myid'] = $this->tranzillaInfo['id'];
            $poststring = '';
            foreach($formdata AS $key => $val){
                $poststring .= $key . "=" . $val . "&";
            }
            $poststring = htmlentities(substr($poststring, 0, -1));
            
            $answer = $this->sendTransaction ($poststring);
            if(!$answer){
                return false;
            }
            
            return $answer;
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
        
        public function getMessages($mes)
        {
            global $current_user;
            $tranzillaInfo = get_user_meta($current_user->ID, 'tranzillaInfo', true);
            
            if(empty($this->tranzillaInfo)||empty($this->tokenLogin)||empty($this->tokenPassword)){
                return false;
            }
            
            $sum = (int) $mes;
            if(!$sum){
                return false;
            }
            $formdata = array();
            $formdata['supplier']=$this->tokenLogin; 
            $formdata['TranzilaPW']=$this->tokenPassword; 
            $formdata['TranzilaTK']=$this->tranzillaInfo['token']; 
            $formdata['expdate']=$this->tranzillaInfo['expmonth'].$this->tranzillaInfo['expyear'];
            $formdata['sum']=$sum;
            $formdata['currency']=$this->tranzillaInfo['currency'];
            $formdata['cred_type']=1;
            $formdata['product']='messages';
            $formdata['MCCUserID']=$current_user->ID;
            $formdata['email']=$current_user->user_email;
            $formdata['contact']=$current_user->display_name;
            $formdata['myid'] = $this->tranzillaInfo['id'];

            $poststring = '';
            foreach($formdata AS $key => $val){
                
                $poststring .= $key . "=" . $val . "&";
            }
            $poststring = htmlentities(substr($poststring, 0, -1));
            var_dump($poststring);
            die();
            $answer = $this->sendTransaction ($poststring);
            if(!$answer){
                return false;
            }
            return $answer;
        }
    }
}


