<?php
$lost_password_sent = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';
if(!$lost_password_sent):
    if ( isset( $_REQUEST['errors'] ) ) {

        switch($_REQUEST['errors']){
            case 'empty_username': echo '<p>You need to enter your email address to continue.</p>';
                break;
            case 'invalid_email':
            case 'invalidcombo': echo '<p>There are no users registered with this email address</p>';
                break;
        }
        ?>
        <?php
    }
    if(isset($_REQUEST['login'])){
        echo '<p>The password reset link you used is not valid anymore.</p>';
    }
    ?>
    <div id="password-lost-form" class="widecolumn">
        <p>Lost your password? Please enter your email address. You will Receive a link to create a new password via email.</p>


        <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
            <p class="form-row">
                <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label><br>
                <input type="text" name="user_login" id="user_login">
            </p>

            <p class="lostpassword-submit">
                <input type="submit" name="submit" class="lostpassword-button"
                       value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
            </p>
        </form>
    </div>
<?php else: ?>
    <p class="login-info">
        <?php _e( 'Check your email for a link to reset your password.', 'personalize-login' ); ?>
    </p>
<?php endif; ?>