<?php
/*
* Template Name: Payment hebrew
*/
check_user_auth();
if($current_user->caps['subscriber']||!is_user_logged_in() ){
	wp_redirect(home_url());
}
get_header(); 
global $current_user;

$args = array(
	'author' => $current_user->ID,
	'posts_per_page'   => 1,
	'post_type'        => 'business'
);
$business = get_posts( $args ); 
$business_pack = get_field("business_pack", $business[0]->ID);
?>
<div class="container  primary-pyment">

		<div id="primary-pyment" class="content-area">
			<main id="main">
				<div class="static-text">
				<p>Become a <span>Premium User</span> and enjoy all of the <span>MyCityCard</span> system benefits for your business.</p>
				<p>You are currently a: Basic User.</p>
				<p>Payment amount: 30 NIS + vat per month ()</p>
				<p>Next Payment date: DD.MM.YYYY ()</p>
				<p>Upgrade to Premium Package and enjoy all system benefits:</p>
				<ul>
					<li>Visible in 3 sub-categories</li>
					<li>Publishing additional 10 benefits.</li>
					<li>1000 benefit & coupons messages every month</li>
				</ul>
				</div>
				<div class="sentence">
					<div class="free-sentence">
						<div class="header-sentence-item">
							<p>free</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<ul>
							<li>logo</li>
								<li>Short description</li>
								<li>Extended description</li>
								<li>Changing main benefit once a month</li>
								<li>One photo</li>
								<li>One subcategory visibility</li>
								<li class="not-active-sentence"><span></span> No advertisements</li>
								<li class="not-active-sentence"><span></span> Homepage link</li>
								<li class="not-active-sentence"><span></span> Facebook link</li>
								<li class="not-active-sentence"><span></span> 1,000 benefit & coupons messages every mounth</li>
								<li class="not-active-sentence"><span></span> Publish 10 additional benefits</li>
								<li  class="price-sentence">FREE</li>
								</ul>
								<ul class="body-sentence-item-ul">
									<li> 
										<div class="checkbox-sentence">
										<input type="checkbox"/>
										</div> 
										By ordering this package I hereby approve the terms and conditions
									</li>
								</ul>
						</div>
						<div class="footer-sentence-item">
							<a href="" id="free" class="pay-button">DOWNGRADE</a>
						</div>
					</div>
					<div class="premium-sentence">
						<div class="header-sentence-item">
							<p>premium</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<ul>	
								<li>logo</li>
								<li>Short description</li>
								<li>Extended description</li>
								<li>Changing main benefit anytime</li>
								<li>5 dynamic photos </li>
								<li>3 subcategories visibility </li>
								<li>No advertisements</li>
								<li>Homepage link</li>
								<li>Facebook link</li>
								<li class="active-sentence"> 1,000 benefit & coupons messages every mounth</li>
								<li class="active-sentence"> Publish 10 additional benefits</li>
								<li  class="price-sentence">50 <span><p>NIS + VAT</p> per month</span></li>
								</ul>
								<ul class="body-sentence-item-ul">
									<li>
										<div class="checkbox-sentence">
										<input type="checkbox"/>
										</div>
										Pay one year in advance and get:
										<ul>
											<li><span class="plus-item">+</span> extra month free!</li>
											<li><span class="plus-item">+</span> extra 500 massages each month</li>
										</ul>			
									</li>
									<li> 
										<div class="checkbox-sentence">
										<input type="checkbox"/>
										</div> 
										By ordering this package I hereby approve the terms and conditions
									</li>
								</ul>
						</div>
						<div class="footer-sentence-item">
							
							<a href="" id="basic" class="pay-button">STOP PAYING</a>
						</div>
					</div>
					<div class="basic-sentence">
						<div class="header-sentence-item">
							<p>basic</p>
							<p></p>
						</div>
						<div class="body-sentence-item">
							<ul>	
								<li>logo</li>
								<li>Short description</li>
								<li>Extended description</li>
								<li>Changing main benefit anytime</li>
								<li>5 dynamic photos </li>
								<li>3 subcategories visibility </li>
								<li>No advertisements</li>
								<li>Homepage link</li>
								<li>Facebook link</li>
								<li class="not-active-sentence"><span></span> 1,000 benefit & coupons messages every mounth</li>
								<li class="not-active-sentence"><span></span> Publish 10 additional benefits</li>
								<li  class="price-sentence">30<span><p>NIS + VAT</p> per month</span></li>
								</ul>
								<ul class="body-sentence-item-ul">
								
									<li> 
										<div class="checkbox-sentence">
										<input type="checkbox"/>
										</div> 
										By ordering this package I hereby approve the terms and conditions
									</li>
								</ul>
						</div>
						<div class="footer-sentence-item">
							<a href="" id="premium" class="pay-button">DOWNGRADE</a>
						</div>
					</div>
					</div>
					<div class="static-text-middle">
						<p>Increase customers in your business – publish easily and simply benefits, special deals and coupons, and make your city neighbors to loyal customers who prefer you over others.</p>
						<ul>
							<li>The package you order will be renewed automatically in the end of each period. You can cancel it anytime, with a button click.</li>
							<li>Prices does not include VAT. VAT tax will be included to each charge by the law.</li>
						</ul>
					</div>
				</div>

				<div class="bottom-content-payment">
					<p>Send lots of messages? Buy additional <span>massages package</span>:</p>
					<table class="table-pyment">
						<tr class="messages-table">
						    <td>1.000 messages</td>
						    <td>2,000 messages</td>
						 	<td>5,000 messages</td>
						 	<td>10,000 messages</td>
						</tr>
						 <tr class="price-table">
						    <td><span>20</span> NIS 0.02 NIS per message</td>
						    <td><span>30</span> NIS 0.015 NIS per message</td>
						    <td><span>60</span> NIS 0.012 NIS per message </td>
						    <td><span>100</span> NIS 0.01 NIS per message</td>
						</tr>
						<tr class="chek-box-table">
							<td>
								<div class="checkbox-sentence">
								<input type="checkbox"/>
								</div> 
								By ordering this package I hereby approve the terms and conditions
							</td>
						    <td>
								<div class="checkbox-sentence">
								<input type="checkbox"/>
								</div> 
								By ordering this package I hereby approve the terms and conditions
							</td>
							<td>
								<div class="checkbox-sentence">
								<input type="checkbox"/>
								</div> 
								By ordering this package I hereby approve the terms and conditions
							</td>
							<td>
								<div class="checkbox-sentence">
								<input type="checkbox"/>
								</div> 
								By ordering this package I hereby approve the terms and conditions
							</td>
						    
						</tr>
						<tr class="by-package">
						    <td><a href="#" class="btn-by-package">Buy package</a></td>
						    <td><a href="#" class="btn-by-package">Buy package</a></td>
						    <td><a href="#" class="btn-by-package">Buy package</a></td>
						    <td><a href="#" class="btn-by-package">Buy package</a></td>
						</tr>
					</table>
				</div>
				
			</main> <!-- #main
		</div> --><!-- #primary-->
		<div class="custom-popup" style="display:none">
			<span class="popup-close">X</span>
			<div class="popup-content">
				
				<form action="https://direct.tranzila.com/ttxmycitytok/" method="post">
					<input type="hidden"  name="supplier"  value="ttxmycitytok" >
					<input type="hidden"  name="sum"  value="12" >
					<input type="hidden"  name="cred_type"  value="1">
					<input type="hidden"  name="currency"  value="1">
					
					<div class="card-info">
						<h4>Payment info</h4>
						<input type="text" name="ccno"	value="" placeholder="Card number" />
						<input type="text" name="expmonth"	value="" placeholder="MM" maxlength="2"/>
						<input type="text" name="expyear"	value="" placeholder="YY" maxlength="2"/>
						<input type="text" name="expdate"	value="" placeholder="MMYY" maxlength="4"/>
						<input type="text" name="mycvv"	value="" placeholder="CVV" maxlength="4"/>
						<input type="text" name="myid"	value="" placeholder="ID" maxlength="9"/>
					</div>
					<div class="customer-info">
						<h4>Customer info</h4>
						<input type="text" name="company" placeholder="Company"/>
						<input type="text" name="contact" placeholder="Contact Name"/>
						<input type="text" name="email" placeholder="email"/>
						<input type="text" name="address" placeholder="address"/>
						<input type="text" name="phone" placeholder="phone"/>
						<input type="text" name="city" placeholder="city"/>
						<input type="text" name="pdesc" placeholder="desc"/>
						<input type="text" name="remarks" placeholder="remarks"/>
					</div>
					<input type="submit" value="Send" class="send-btn">
				</form>
			</div>
		</div>
	</div>
<?php get_footer(); ?>