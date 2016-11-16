<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package mycitycard
 */
$role = get_current_user_role();
global $sitepress;
$current_language = $sitepress->get_current_language();
?>

	</div><!-- #content -->
	<div class='popmake-city-not-active'></div>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container clearfix">
			<div class="container-inner clearfix ">
				<div class="categories-box ">
				 <?php 
                                    global $sitepress;
                                    $current_language = $sitepress->get_current_language();
                                    if($current_language === 'en'): 
                                    ?>
					<h5>Categories</h5>
					<?php else: ?>
                                   <h5>קטגוריות</h5>
                                    <?php endif; ?>
					<?php  
						$args = array('type' => 'business', 'parent' => 0, 'taxonomy' => 'business_cat', 'hide_empty' => 0, 'orderby' => 'name', 'order' => 'ASC');
						$categories = get_categories($args);
						$i = 0;
						foreach ($categories as $cat) {
							if($i==0){
								echo "<ul>";
							}
							$term_id = (int) $cat->term_id;
							$link =  get_term_link($term_id, 'business_cat');
							?>
							<li><a href="<?php echo $link ?>"><?php echo $cat->name ?></a></li>
							<?php
							$i++;
							if($i==7){
								echo "</ul>";
								$i=0;
							}
						}
					?>
				</div>
				<div class="more-box">
				 <?php 
                                    global $sitepress;
                                    $current_language = $sitepress->get_current_language();
                                    if($current_language === 'en'): 
                                    ?>
					<h5>More</h5>
					<ul>
                                   
										<li><a href="<?php echo get_permalink(1753) ?>">About</a></li>
										<!-- <li><a href="<?php echo get_permalink(1755) ?>">Help</a></li> -->
										<li><a href="<?php echo get_permalink(1757) ?>">Contact Us</a></li>
					
                                    <?php else: ?>
                                    	<h5>עוד</h5>
					<ul>	
                                        <li><a href="<?php echo get_permalink(1753) ?>">אודות</a></li>
									<!-- 	<li><a href="<?php echo get_permalink(1755) ?>">Help</a></li> -->
										<li><a href="<?php echo get_permalink(1757) ?>">צור קשר</a></li>
                                    <?php endif; ?>
                                    </ul>
					<?php
						$val = get_option('facebook_link');
    					$val = $val['input'];
					?>
					<a href="<?php echo $val; ?>">
						<i class="icon-facebook-circled"></i>
					</a>
					<?php
						$val = get_option('twitter_link');
    					$val = $val['input'];
					?>
					<a href="<?php echo $val; ?>">
						<i class="icon-twitter-circled"></i>
					</a>
					<?php
						$val = get_option('contact_email');
    					$val = $val['input'];
					?>
					<a href="mailto:<?php echo $val; ?>">
						<i class="icon-mail-circled"></i>
					</a>
				</div>
				<div class="join-box">
					<?php  
						if(!is_user_logged_in()):
					?>
					<h5>Join Us!</h5>
					<ul class="join-list">
					<li><a href="#" class="popmake-customer-register">I’m a customer</a></li>
					<li><a href="#" class="popmake-business-registration">I’m a Business owner</a></li>
					</ul>
					<?php endif; ?>
					<?php 
                                    global $sitepress;
                                    $current_language = $sitepress->get_current_language();
                                    if($current_language === 'en'): 
                                    ?>
					<h5>Work with Us</h5>
					<ul>
								
										<li><a href="#">Become a city owner!</a></li>
					
                                    <?php else: ?>
                                    	<h5>עבוד איתנו</h5>
					<ul>
                                 	 <li><a href="#">הפוך לראש עיר</a></li>
                                    <?php endif; ?>
						
					</ul>
					
				</div>
			</div>
			<div class="container-inner-bot clearfix">
				<ul>
					 <?php 
                                    global $sitepress;
                                    $current_language = $sitepress->get_current_language();
                                    if($current_language === 'en'): 
                                    ?>
										<li><a href="#">All Rights Reserved to MCC</a></li>
										<li><a href="#">Terms of Use</a></li>
										<li><a href="#">Privacy Policy</a></li>
					
                                    <?php else: ?>
                                     <li><a href="#">All Rights Reserved to MCC</a></li>
									<li><a href="#">תנאי שימוש</a></li>
									<li><a href="#">מדיניות פרטיות</a></li>
                                    <?php endif; ?>
					
				</ul>
				<span>
					Built by Gal, Designed by Ofri
				</span>
			</div>
		</div>
		<div class="site-info">
		<!-- 	<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'mycitycard' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'mycitycard' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'mycitycard' ), 'mycitycard', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?> -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<div id="responsive-menu">
	<div id="responsive-menu-title">
		<?php
//		if( $role == 'Subscriber' ){
//			wp_nav_menu( array('menu' => 'Cusomer menu' ) );
//		}else{
//			wp_nav_menu( array('menu' => 'Main Menu english' ) );
//		}
                echo do_shortcode('[side_categories]');
		?>
	</div>
</div>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css' type='text/css' media='all' />
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/i18n/en.js'></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
<script src="<?=bloginfo("template_url");?>/js/js.cookie.js"></script>
<script src="<?=bloginfo("template_url");?>/js/chosen.jquery.js"></script>
<script type="text/javascript">

	jQuery( document ).ready(function() {
		jQuery('.logo-choose').append(jQuery(".main-logo"));
                <?php 
                if($current_language === 'en'):
                ?>
		jQuery('.logo-choose').append(jQuery('<div class="gfield_description">Square sized, at least 90x90 pixels.</div>'));
                <?php else: ?>
                    jQuery('.logo-choose').append(jQuery('<div class="gfield_description">ריבוע, לפחות 90*90 פיקסלים</div>'));
                <?php endif; ?>
		jQuery('.logo-choose').append(jQuery("#logo_preview"));
	});

	

	jQuery(".ben").click(function(){
		jQuery(".ben").addClass("active-tab");
		jQuery(".biz").removeClass("active-tab")
		});

	jQuery(".biz").click(function(){
		jQuery(".biz").addClass("active-tab");
		jQuery(".ben").removeClass("active-tab")
	});


	if (jQuery("body").hasClass("rtl")){
		jQuery('#click-menu').click (function(){
			//alert("ASDSD");

			// destroy default Gravity Form datepicker
			jQuery("#RMX").toggleClass('hide-menu');
			jQuery("#RM3Lines").toggleClass('show-menu');
			jQuery("#responsive-menu").toggleClass("active-menu-he");
			// create new custom datepicker
		});
	}
	else {
		jQuery('#click-menu').click (function(){
			//alert("ASDSD");

			// destroy default Gravity Form datepicker
			jQuery("#RMX").toggleClass('hide-menu');
			jQuery("#RM3Lines").toggleClass('show-menu');
			jQuery("#responsive-menu").toggleClass("active-menu");
			// create new custom datepicker
		});
	}




</script>
<script type="text/javascript">

    jQuery(document).bind('gform_post_render', function(){
		//alert("ASDSD");
        
        // destroy default Gravity Form datepicker
        jQuery(".date_exp input").datepicker('destroy');
        
        // create new custom datepicker
        jQuery(".date_exp #input_7_5").datepicker({
			minDate: 0,
			dateFormat: 'dd/mm/yy',
			defaultDate: '+1m'
		});
		
		jQuery(".date_exp #input_7_5").datepicker('setDate', '+1m');
    });

</script>
<script>
	jQuery(function($) {

		$("#cities span a").click(function(e) {
			e.preventDefault();
			$(this).parent().hide();
			$("#cities select").show();
		});
		
		$("#cities select").change(function() {
			//console.log($(this).val());
			//$.cookie('my_city', $(this).val());
			mycityz = $(this).val();
			$.ajax({
				type: 'POST',
				url: ajaxurl+'/?action=update_city_cookie',
				data: { mcityz: mycityz },
				success: function(data) {
					console.log(data);
					if(data.success == true)
						location.reload();
				}
			});
			
		});
		
		function matchStart (term, text) {
		  if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
			return true;
		  }
		 
		  return false;
		}
		
		$.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
			$(".cities_dropdown select").select2({
				placeholder: "Select a city", 
				width: '100%',
				matcher: oldMatcher(matchStart)
			});
		});	
	});
		$(document).ready(function(){
			if($('body').hasClass('rtl')){
				$("#input_17_1").addClass('chosen-rtl');
			}
		$("#input_17_1").addClass('chosen-select');
		 $("#input_17_1").chosen(); 
		})
</script>

<?php wp_footer(); ?>

</body>
</html>
