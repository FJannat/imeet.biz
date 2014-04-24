<?php 
/*
 * This is the page users will see logged out. 
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>

	<div  class="lwa lwa-default"><?php //class must be here, and if this is a template, class name should be that of template directory ?>
    <div class="login_show" id="front_login">
        <form class="lwa-form" action="<?php echo esc_attr(LoginWithAjax::$url_login); ?>" method="post">
        	<span class="lwa-status"></span>
 
                        <input type="text" name="log" placeholder="Username" />
                        <input type="password" name="pwd" placeholder="Password" />
                    <?php do_action('login_form'); ?>
                        <input type="submit" name="wp-submit" id="lwa_wp-submit" value="<?php esc_attr_e('sign in', 'login-with-ajax'); ?>" tabindex="100" />
                        <input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr($lwa_data['profile_link']); ?>" />
                        <input type="hidden" name="login-with-ajax" value="login" />
                  <div class="check_grup">
                        <input name="rememberme" type="checkbox" class="lwa-rememberme" value="forever" /> <label><?php esc_html_e( 'Keep me logged in','login-with-ajax' ) ?></label>
                        </div>
                        <p style="display:block;">
  						<a  class="lwa-links-remember log_in_left" href="<?php echo esc_attr(LoginWithAjax::$url_remember); ?>" title="<?php esc_attr_e('Password Lost and Found','login-with-ajax') ?>"><?php esc_attr_e('Forgot your password?','login-with-ajax') ?></a>
  						<a href="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" class="lwa-links-register lwa-links-modal log_in_right"><?php esc_html_e('Register','login-with-ajax') ?></a>
                        </p>
          </form>
    </div>     
        <?php if( !empty($lwa_data['remember']) ): ?>
        <form class="lwa-remember" action="<?php echo esc_attr(LoginWithAjax::$url_remember) ?>" method="post" style="display:none;">
        	<span class="lwa-status"></span>
            <table>
                <tr>
                    <td>
                        <strong><?php esc_html_e("Forgotten Password", 'login-with-ajax'); ?></strong>         
                    </td>
                </tr>
                <tr>
                    <td class="lwa-remember-email">  
                        <?php $msg = __("Enter username or email", 'login-with-ajax'); ?>
                        <input type="text" name="user_login" class="lwa-user-remember" value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}" />
                        <?php do_action('lostpassword_form'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="lwa-remember-buttons">
                        <input type="submit" value="<?php esc_attr_e("Get New Password", 'login-with-ajax'); ?>" class="lwa-button-remember" />
                        <a href="#" class="lwa-links-remember-cancel"><?php esc_html_e("Cancel", 'login-with-ajax'); ?></a>
                        <input type="hidden" name="login-with-ajax" value="remember" />
                    </td>
                </tr>
            </table>
        </form>
        <?php endif; ?>
		<?php if( get_option('users_can_register') && !empty($lwa_data['registration']) ): ?>
		<div class="lwa-register lwa-register-default lwa-modal" style="display:none;">
			<h4><?php esc_html_e('Register For This Site','login-with-ajax') ?></h4>
			<p><em class="lwa-register-tip"><?php esc_html_e('A password will be e-mailed to you.','login-with-ajax') ?></em></p>
			<form class="lwa-register-form" action="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" method="post">
				<span class="lwa-status"></span>
				<p class="lwa-username">
					<label><?php esc_html_e('Username','login-with-ajax') ?><br />
					<input type="text" name="user_login" id="user_login" class="input" size="20" tabindex="10" /></label>
				</p>
				<p class="lwa-email">
					<label><?php esc_html_e('E-mail','login-with-ajax') ?><br />
					<input type="text" name="user_email" id="user_email" class="input" size="25" tabindex="20" /></label>
				</p>
				<?php do_action('register_form'); ?>
				<?php do_action('lwa_register_form'); ?>
				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e('Register', 'login-with-ajax'); ?>" tabindex="100" />
				</p>
		        <input type="hidden" name="login-with-ajax" value="register" />
			</form>
		</div>
		<?php endif; ?>
	</div>