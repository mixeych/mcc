<?php
/*
Template Name: עמוד עסק
*/
?>

<?php get_header(); ?>

  <div class="container">
    <div id="sidebar">
      <?php get_sidebar(); ?>
    </div>
    <div id="primary" class="content-area">
      <main id="main" class="site-main" role="main">

        <div class="business-wrapper">
          <img class="main-ad" src="<?php bloginfo('template_directory'); ?>/images/business/ad728.jpg" alt="">
          <div class="bus-header">
            <div class="bus-icons">
              <img src="<?php bloginfo('template_directory'); ?>/images/business/likeit.jpg">
              <img src="<?php bloginfo('template_directory'); ?>/images/business/fav.jpg">
              <img src="<?php bloginfo('template_directory'); ?>/images/business/facebook.jpg">
              <img src="<?php bloginfo('template_directory'); ?>/images/business/twitter.jpg">
              <img src="<?php bloginfo('template_directory'); ?>/images/business/email.jpg">              
            </div>
            <div class="bus-title">
              <img class="bus-thumb" src="<?php bloginfo('template_directory'); ?>/images/business/bus-logo.jpg">
              <h2>Loop Loop Restaurant</h2>
              <p>The place for sweets, ice cream, Great cakes, pancakes, chocolates and much. The Place for sweets, ice-cream, Great cakes, pancakes, chocolates and much.</p>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-8 nopadding wrapper-fix">
            <div class="slider">
              <img src="<?php bloginfo('template_directory'); ?>/images/business/bus_photo.jpg">
              <img class="ad2" src="<?php bloginfo('template_directory'); ?>/images/business/ad478.jpg">
          </div>
        </div>
          <div class="col-md-4 nopadding">
            <div class="bus-address">
                <h3>The Eating center, Sheshet Hayamim 23, Netanya, 42513</h3>
                <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/business/map.jpg"></a>

            </div>
            <div class="bus-details">
              <h3>09-123456, 054-1234567</h3>
        
              <h3>Mon-Sat <span> 09:00 - 18:00</span></h3>
              <a href="#">www.Looploop.com</a><br>
              <a href="#">Looploop in Facebook</a>

            </div>
          </div>
        </div><!-- END: row -->

        <div class="bus-deals">
          <h2>Business Benefits:</h2>
          <div class="bus-deal">
            <div class="bus-percent">
              <h2>50%</h2>
            </div>


            <div class="deal-text">

              <h3>Get 50% OFF the right menu!</h3>
              <h4><img class="deal-card" src="<?php bloginfo('template_directory'); ?>/images/business/card.png"> Netanya Card Holders Exclusive</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod </p>
                <p>empor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                <p>read more.</p>

            </div>


            <div class="bus-star">
              <img class="deal-star" src="<?php bloginfo('template_directory'); ?>/images/business/star.png">
            </div>
          </div>
        </div>

          <div class="bus-more">
            <h4>Some More Information About The Business</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
            </p>
            <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.  </p>
</p>
          </div>
                </main><!-- #main -->
        </div>


    </div><!-- #primary -->

<?php get_footer(); ?>
