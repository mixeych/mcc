<?php
/*
*	Template Name: Messages
*/
global $wpdb;
global $search;
global $current_user;
check_user_auth();
//recieve_message();
get_header();
$user_type = get_user_meta($current_user->ID, 'mcc_user_type', true);
if(!$current_user->caps['contributor']&&$user_type != 'business'){
	update_user_meta($current_user->ID, 'mcc_new_messages', '0');
}
?>
<div class="container">	

	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>
	
	<div id="primary" class="content-area">
		<header class="entry-header">
			<h1 class="entry-title">My Messages</h1>
		</header>
		<main id="main" class="" role="main">
				
				<?php
				$ids = get_delivered_messages($current_user->ID);
				$userRole = get_current_user_role();
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				if( $userRole == 'Subscriber'){

                    $args = array(
                        'post_type' => 'message',
                        'post__in' => $ids,
                        'showposts' => 10,
                        'paged' => $paged,
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(
                                'meta_key' => 'status',
                                'meta_value' => 'active',
                            ),
                            array(
                                'meta_key' => 'status',
                                'meta_value' => 'deleted',
                            ),
							array(
								'meta_key' => 'status',
								'meta_value' => 'expired',
							),
							array(
								'meta_key' => 'status',
								'meta_value' => 'sold out',
							)
                        )
                    );
                    
				}else{

					$ids = true;
					$args = array(
							'author' => $current_user->ID,
							'post_type' => 'message',
							'showposts' => 10,
							'paged' => $paged,
							'meta_query' => array(
								'relation' => 'OR',
								array(
									'key' => 'status',
									'value' => 'active',
								),
								array(
									'key' => 'status',
									'value' => 'expired',
								),
								array(
									'key' => 'status',
									'value' => 'sold out',
								)
							)
					);

				}
				$messages = new WP_Query( $args );
				if($messages->have_posts()&&$ids):
					while($messages->have_posts()):
						$messages->the_post();
						get_template_part( 'content', 'messages' );
					endwhile;
		
	            echo paginate_links( array(
	               'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
	               'format'       => '',
	               'add_args'     => '',
	               'current'      => $paged,
	               'total'        => $messages->max_num_pages,
	               'prev_text'    => '&larr;',
	               'next_text'    => '&rarr;',
	               'type'         => 'plain',
	                'end_size'     => 3,
	               'mid_size'     => 3
	            ) );   
				wp_reset_query();

				?>


			<?php 
				else:
			get_template_part( 'content', 'none' ); 
				endif;
			?>


		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php
			if ( is_active_sidebar( 'ads-widgets' ) ) { ?>
			<div id="ads">
				<?php dynamic_sidebar( 'ads-widgets' ); ?>
			</div>
		<?php } ?>
<?php get_footer(); ?>
