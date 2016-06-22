<?php
/*
* Template Name: Payment
*/

global $current_user;
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    check_user_auth();
}
if(is_user_logged_in()&&isset($current_user->caps['subscriber'])){
	wp_redirect(home_url());
}
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
					<p>Become a Premium User and enjoy all of the MyCityCard

                                            system benefits for your business.</p>

                                        <p>You are currently a: <?php echo $business_pack ?> user.</p>
<?php 
$tranzillaInfo = unserialize(get_user_meta($current_user->ID, 'tranzillaInfo', true));
if(!empty($tranzillaInfo)&&is_array($tranzillaInfo)):
?>
                                        <p>Payment amount: <?php echo $tranzillaInfo['paymentAmount'] ?> NIS + vat per month ()</p>
                                        <?php if($tranzillaInfo['cardNumber']): ?>
                                        <p>Card number: xxxx-xxxx-xxxx-<?php echo $tranzillaInfo['cardNumber'] ?></p>
                                        <?php endif; ?>
                                        <?php if($tranzillaInfo['expmonth']&&$tranzillaInfo['expyear']): ?>
                                        <p>Card expiration date: <?php echo $tranzillaInfo['expmonth'] ?>/<?php echo $tranzillaInfo['expyear'] ?></p>
                                        <?php endif; ?>
                                        <p>Next Payment date: <?php echo date('d.m.Y' ,$tranzillaInfo['nextPaymentDate']) ?></p>
<?php endif; ?>
                                        <?php if($business_pack != 'Premium'): ?>
                                        <p>Upgrade to Premium Package and enjoy all system benefits:</p>
<ul>
	<li>Visible in 3 sub-categories</li>
	<li>Publishing additional 10 benefits.</li>
	<li>1000 benefit &amp; coupons messages every month</li>
</ul>
                                        <?php 
                                        endif; 
                                        if(!empty($tranzillaInfo)): ?>
                                        <p><a id="change-credit-card" href="#">Change card</a> | <a id="remove-credit-card" href="#">Remove card</a></p>
                                                <?php endif; ?>
				</div>
				<div class="sentence">
					<div class="free-sentence">
						<div class="header-sentence-item">
							<p>free</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<?php the_field('column_1') ?>
						</div>
						<?php
                                                        $className = "";
							if($business_pack == 'Free'){
								$buttonText = 'CURRENT';
                                                                $className = '';
							}else{
								$buttonText = 'DOWNGRADE';
                                                                $className = 'stop-paying';
							}
						?>
						<div class="footer-sentence-item">

							<a href="javascript:void(0)" id="free" class="pay-button <?php echo $className ?>"><?php echo $buttonText ?></a>
						</div>
					</div>
					<div class="premium-sentence">
						<div class="header-sentence-item">
							<p>premium</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<?php the_field('column_2') ?>
						</div>
						<div class="footer-sentence-item">
							<?php
                                                                $className = "";
								if($business_pack == 'Premium'){
									$buttonText = 'STOP PAYING';
                                                                        $className = 'stop-paying';
                                                                        
								}else{
                                                                    $className = "upgrade";
									$buttonText = 'UPGRADE';
								}
							?>
							<a data-currentPack="<?php echo $business_pack ?>" href="javascript:void(0)" id="basic" class="pay-button <?php echo $className ?>"><?php echo $buttonText ?></a>
						</div>
					</div>
					<div class="basic-sentence">
						<div class="header-sentence-item">
							<p>basic</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<?php the_field('column_3') ?>
						</div>
						<div class="footer-sentence-item">
							<?php
                                                                $className = "";
								if($business_pack == 'Basic'){
									$buttonText = 'STOP PAYING';
                                                                        $className = 'stop-paying';
								}elseif($business_pack == 'Premium'){
									$buttonText = 'DOWNGRADE';
                                                                        $className = 'downgrade';
								}else{
                                                                    $className = "upgrade";
									$buttonText = 'UPGRADE';
								}
							?>
							<a href="javascript:void(0)" id="premium" class="pay-button <?php echo $className ?>"><?php echo $buttonText ?></a>
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
                                    <p>You currently have: <?php echo $messages_have ?> messages</p>
                                                    <?php
                                                    
							the_field('bottom_table');
						}
					?>

				</div>
			</main> <!-- #main
		</div> --><!-- #primary-->
<?php
$sum = '50';
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
                                 sum=<?php echo $sum; // required field ?> 
                                 &currency=<?php echo $currency; // required field ?>
                                 &cred_type=<?php echo $cred_type; //required field ?>
                                 &lang=<?php echo $lang;?>
                                 &nologo=<?php echo $logo; ?>
                                 &trBgColor=<?php echo $trBgColor; ?>
                                 &trTextColor=<?php echo $trTextColor; ?>
                                 &trButtonColor=<?php echo $trButtonColor; ?>
                                 &buttonLabel=<?php echo $buttonLabel; ?>
                                 &tranmode=<?php echo $tranmode; ?>
                                 &MCCUserID=<?php echo $current_user->ID ?>
                                 &product=package
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
<?php 

get_footer(); ?>