<div id="password-reset-form" class="widecolumn">

    <?php
        if(isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'])):
            if(isset($_REQUEST['error'])){
                switch($_REQUEST['error']){
                    case 'password_reset_mismatch': echo "<p>The two passwords you entered don't match.</p>";
                        break;
                    case 'password_reset_empty': echo '<p>Sorry, we don\'t accept empty passwords.</p>';
                        break;
                }
            }
    ?>
        <h3><?php _e( 'Pick a New Password', 'personalize-login' ); ?></h3>
        
    <form name="resetpassform" id="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
        <input type="hidden" id="user_login" name="rp_login" value="<?php echo $_REQUEST['login']; ?>" autocomplete="off" />
        <input type="hidden" name="rp_key" value="<?php echo $_REQUEST['key']; ?>" />

        <p>
            <label for="pass1"><?php _e( 'New password', 'personalize-login' ) ?></label>
            <input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
        </p>
        <p>
            <label for="pass2"><?php _e( 'Repeat new password', 'personalize-login' ) ?></label>
            <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
        </p>

        <p class="description"><?php echo wp_get_password_hint(); ?></p>

        <p class="resetpass-submit">
            <input type="submit" name="submit" id="resetpass-button"
                   class="button" value="<?php _e( 'Reset Password', 'personalize-login' ); ?>" />
        </p>
    </form>
        <?php else:
            echo '<p>Invalid password reset link.</p>';
            endif;
        ?>
</div>
