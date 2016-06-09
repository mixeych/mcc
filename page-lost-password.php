<?php
/**
 * Template Name: Lost Password
 */
if(is_user_logged_in()){
    wp_redirect(home_url());
}

get_header(); ?>
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                    $password_updated = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';
                    if(isset($_REQUEST['login'])&&isset($_REQUEST['key'])){
                        get_template_part( 'content', 'new_pass_form' );
                    }elseif($password_updated){
                        echo '<p>Your password has been changed. You can sign in now</p>';
                    }else{
                        get_template_part( 'content', 'lost-password' );
                    }

                    ?>

                </div><!-- .entry-content -->

            </article>

        <?php endwhile; // end of the loop. ?>
    </div>

<?php get_footer(); ?>