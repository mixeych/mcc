<?php
/*
* Template Name: Payment Hebrew
*/
global $current_user;
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    check_user_auth();
}
if(is_user_logged_in()&&isset($current_user->caps['subscriber'])){
	wp_redirect(home_url());
}
$sessStatus = session_status();
if($sessStatus == 'PHP_SESSION_DISABLED'||$sessStatus===0 ){
    session_start();
}
$_SESSION['paymentPage'] = 1;
global $sitepress;
get_header(); 


$args = array(
	'author' => $current_user->ID,
	'posts_per_page'   => 1,
	'post_type'        => 'business'
);
$business = get_posts( $args ); 

$messages_have = get_post_meta($business[0]->ID, 'messages_have', true);
$business_pack = get_field("business_pack", $business[0]->ID);

if(have_posts()){
	the_post();
}
$id = get_the_id();

?>
	<div class="container  primary-pyment">
            
		<div id="primary-pyment" class="content-area">
			<main id="main">
				<div class="static-text">
                                    <?php the_content() ?>
                                    
                                    <?php  
                                    $businessPackHe;
                                    switch($business_pack){
                                        case 'Premium': $businessPackHe = 'פרימיום';
                                            break;
                                        case 'Basic': $businessPackHe = 'בסיסית';
                                            break;
                                        default:
                                            $businessPackHe = 'חינמית';
                                            break;
                                    }
                                    ?>
                                    <p>חבילה נוכחית: <span class="orange"><?php echo $businessPackHe ?></span></p>
<?php 
$tranzillaInfo = unserialize(get_user_meta($current_user->ID, 'tranzillaInfo', true));
if(!empty($tranzillaInfo)&&is_array($tranzillaInfo)):
?>
                                        
                                        <?php 
                                            $paymentAmount = $tranzillaInfo['paymentAmount'].' ש"ח + מע"מ לחודש';
                                            if(isset($tranzillaInfo['stopPaying']) && $tranzillaInfo['stopPaying']){
                                                $paymentAmount = '';
                                            }
                                        ?>
                                        <p>סכום לתשלום: <?php echo $paymentAmount ?> </p>
                                        <?php 
                                        $cardNumber = $tranzillaInfo['cardNumber'];
                                        if(empty($cardNumber)&&!empty($tranzillaInfo['token'])){
                                            $cardNumber = substr($tranzillaInfo['token'], -4);
                                        }
                                        if(!empty($cardNumber)): ?>
                                        <p>מספר כרטיס: <span class="orange">xxxx-xxxx-xxxx-<?php echo $cardNumber ?></span></p>
                                        <?php endif; ?>
                                        <?php if($tranzillaInfo['expmonth']&&$tranzillaInfo['expyear']): ?>
                                        <p>תוקף כרטיס: <span class="orange"><?php echo $tranzillaInfo['expmonth'] ?>/<?php echo $tranzillaInfo['expyear'] ?></span></p>
                                        <?php endif; ?>
                                        <?php 
                                            $nextPaymentDate = date('d.m.Y' ,$tranzillaInfo['nextPaymentDate']);
                                            if(isset($tranzillaInfo['stopPaying']) && $tranzillaInfo['stopPaying']){
                                                
                                                $nextPaymentDate = '';
                                            }
                                            if($tranzillaInfo['business_pack']=== 'premium_year'){
                                                $nextPaymentDate = date('d.m.Y' ,$tranzillaInfo['paymentYear']);
                                            }
                                        ?>
                                        <p>חיוב הבא בתאריך: <span class="orange"><span class="next-payment-date"><?php echo $nextPaymentDate ?></span></span></p>
<?php endif; ?>
                                        <?php if($business_pack != 'Premium'): ?>
                                        <p>שדרג לחבילת פרמיון ותהנה מכל הטבות המערכת:</p>
<ul>
	<li>הופעה ב3 תת קטגוריות</li>
	<li>פרסום 10 מבצעים והטבות נוספות</li>
	<li>שליחת 1000 הודעות מבצע וקופונים בחודש</li>
</ul>
                                        <?php 
                                        endif; 
                                        if(!empty($tranzillaInfo)&&!empty($tranzillaInfo["token"])): ?>
                                        <p><a class='stop-paying' href="#" data-currentPack="<?php echo $business_pack ?>">הסרת כרטיס אשראי</a></p>
                                                <?php endif; ?>
				</div>
				<div class="sentence">
					<div class="free-sentence">
						<div class="header-sentence-item">
							<p>חינמית</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<?php the_field('column_1') ?>
						</div>
						<?php
                                                        $className = "";
							if($business_pack == 'Free'||$tranzillaInfo['stopPaying'] === true){
								$buttonText = 'CURRENT';
                                                                $className = '';
							}else{
								$buttonText = 'שנמוך';
                                                                $className = 'stop-paying';
							}
						?>
						<div class="footer-sentence-item">

							<a href="javascript:void(0)" id="free" class="pay-button <?php echo $className ?>"><?php echo $buttonText ?></a>
						</div>
					</div>
					<div class="premium-sentence">
						<div class="header-sentence-item">
							<p>פרימיום</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<?php the_field('column_2') ?>
						</div>
						<div class="footer-sentence-item">
							<?php
                                                                $className = "";
								if($business_pack == 'Premium'&&$tranzillaInfo['stopPaying'] !== true&&$tranzillaInfo['downgrade'] !== 'basic'){
									$buttonText = 'הפסק תשלום';
                                                                        $className = 'stop-paying';
                                                                        
								}else{
                                                                    $className = "upgrade";
                                                                    if($business_pack == 'Premium'){
                                                                        $className = 'back-to-premium';
                                                                    }
									$buttonText = 'שדרוג';
								}
                                                                $premiumPrice = '50';
                                                                $val = get_option('premium_price');
                                                                if($val){
                                                                   $premiumPrice = $val['input']; 
                                                                }
                                                                $priceForYear = '570';
                                                                $val = get_option('pay_for_year_price');
                                                                if($val){
                                                                    $priceForYear = $val['input'];
                                                                }
                                                                $basicPremium = '20';
                                                                $val = get_option('basic_to_premium');
                                                                if($val){
                                                                    $basicPremium = $val['input'];
                                                                }
                                                                $basicPremiumYear='570';
                                                                        $val = get_option('basic_to_premium_year');
                                                                        if($val){
                                                                            $basicPremiumYear = $val['input'];
                                                                        }
                                                                
							?>
							<a data-currentPack="<?php echo $business_pack ?>" data-price="<?php echo $premiumPrice ?>" data-foryear="<?php echo $priceForYear ?>" href="javascript:void(0)" id="basic" class="pay-button <?php echo $className ?>"><?php echo $buttonText ?></a>
                                                        <input id="basic-premium" type="hidden" value="<?php echo $basicPremium ?>" />
                                                        <input id="basic-premium-year" type="hidden" value="<?php echo $basicPremiumYear ?>" />
						</div>
					</div>
					<div class="basic-sentence">
						<div class="header-sentence-item">
							<p>בסיסית</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<?php the_field('column_3') ?>
						</div>
						<div class="footer-sentence-item">
							<?php
                                                                $className = "";
								if(($business_pack == 'Basic'||$tranzillaInfo['downgrade'] == 'basic')&&$tranzillaInfo['stopPaying'] !== true){
									$buttonText = 'הפסק תשלום';
                                                                        $className = 'stop-paying';
								}elseif($business_pack == 'Premium'&&$tranzillaInfo['stopPaying'] !== true){
									$buttonText = 'שנמוך';
                                                                        $className = 'downgrade';
								}else{
                                                                    $className = "upgrade";
									$buttonText = 'שדרוג';
                                                                        if($business_pack == 'Basic'){
                                                                        $className = 'back-to-basic';
                                                                    }
								}
                                                            $basicPrice = '30';
                                                            $val = get_option('basic_price');
                                                            if($val){
                                                                $basicPrice = $val['input'];
                                                            }
							?>
							<a href="javascript:void(0)" id="basic" data-price="<?php echo $basicPrice ?>" class="pay-button <?php echo $className ?>" data-currentPack="<?php echo $business_pack ?>"><?php echo $buttonText ?></a>
						</div>
					</div>
					</div>
					<div class="static-text-middle">
						<?php the_field('bottom_text') ?>
					</div>
				</div>

				<div class="bottom-content-payment">
					<?php
                                        
						if($business_pack == 'Premium') {
                                                    ?>
                                    <p>ברשותך: <span><?php echo $messages_have ?> הודעות</span></p>
                                                    <?php
                                                    
							the_field('bottom_table');
						}
					?>

				</div>
			</main> <!-- #main
		</div> --><!-- #primary-->
<?php
$val = get_option('basic_price');
$sum = '50';
if($val){
    $sum = $val['input'];
}

$lang = 'he';
if('he' ===  $sitepress->get_current_language()){
   $lang = 'il'; 
   $buttonLabel = 'בצע תשלום';
}else{
    $lang = 'us';
    $buttonLabel = 'Pay now';
}
$trBgColor = "ffffff";
$trTextColor = "525252";
$trButtonColor = "F56C6A";
$val = get_option('tranzilla_terminal_name');
if($val):
$terminal_name = $val['input'];
$cred_type = 1;
$currency = 1;
$logo = 1;
$tranmode = 'AK';

?>
		<div class="popup custom-popup" style="display:none">
                    <span class="popup-close">X</span>
                    <div class="popup-content">
                        <iframe
                            width="455px"
                            height="500px;" 
                            src="https://direct.tranzila.com/<?php echo $terminal_name ?>/iframe.php?
                             &sum=<?php echo $sum ?>
                             &currency=<?php echo $currency ?>
                             &cred_type=<?php echo $cred_type; ?>
                             &MCCUserID=<?php echo $current_user->ID ?>
                             &lang=<?php echo $lang;?>
                             &nologo=<?php echo $logo; ?>
                             &trBgColor=<?php echo $trBgColor; ?>
                             &trTextColor=<?php echo $trTextColor; ?>
                             &trButtonColor=<?php echo $trButtonColor; ?>
                             &buttonLabel=<?php echo $buttonLabel; ?>
                             &tranmode=<?php echo $tranmode; ?>
                             &product=package
                             &email=<?php echo $current_user->user_email ?>
                             &contact=<?php echo $current_user->display_name ?>
                           "
                            frameborder="0"
                            >
                         </iframe>
                    </div>
		</div>
                        
                <?php 
                    $tranzillaInfo = get_user_meta($current_user->ID, 'tranzillaInfo', true);
                    $tranzillaInfo = unserialize($tranzillaInfo);
                    if(!empty($tranzillaInfo)):
                        $tranilaPW = 'wiBVEw';
                        if($tranilaPW):
                            $terminal_name = 'ttxmycitytok';
                            //$tranilaPW = $tranilaPW['token'];
                            $token = $tranzillaInfo['token'];
                            $expdate = $tranzillaInfo['expmonth'].$tranzillaInfo['expyear'];
                            $sum = 20;
                            $currency = $tranzillaInfo['currency'];
                            $cred_type = 1;
                            
                            
                ?>
                <?php 
                    if(isset($tranzillaInfo['token'])&&!empty($tranzillaInfo['token'])):
                ?>
		<div class="popup message-popup" style="display:none">
			<span class="popup-close">X</span>
                       
			<div class="popup-content">
                            <h3>You want to buy <span class="number"></span>messages</h3>
                            <form action="<?php echo home_url('/payment-process/') ?>" method="post">
                                <input class="sum" type="hidden" name="messages" value="">
                                <button class="btn btn-info">Pay</button>
                            </form>
			</div>
		</div>
                <?php endif; endif; endif; ?>
<?php endif; ?>
	</div>
        <script>
            jQuery(function(){
                var package = '<?php echo $business_pack ?>'.toLowerCase();
                $('.'+package+'-sentence').find('.body-sentence-item-ul').remove();
            });
        </script>
<?php 

get_footer(); ?>