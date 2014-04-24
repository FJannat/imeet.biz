<?php
	$settings = $this->getSettings();
	$messages = $this->messages;
	$license_status = get_option('EasyModal_License_Status');
	$valid = is_array($license_status) && !empty($license_status['status']) && in_array($license_status['status'], array(2000,2001,3003)) ? true : false;
	$modals = $this->getModalList();
	$themes = $this->getThemeList();
?>
<div class="wrap">
	<?php if(!empty($this->messages)){?>
		<?php foreach($this->messages as $message){?>
		<div class="<?php _e($message['type'],'easy-modal')?>"><strong><?php _e($message['message'],'easy-modal')?>.</strong></div>
		<?php }?>
	<?php }?>
	<?php screen_icon()?>
	<h2>
		<?php _e('Settings','easy-modal')?>
	</h2>
	<?php if(!$valid){?>
	<div class="error">
		<p>If you purchased the Pro version and havent already recieved a key please email us at <a href="mailto:danieliser@wizardinternetsolutions.com">danieliser@wizardinternetsolutions.com</a></p>
	</div>   
	<?php }?>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<h2 id="em-tabs" class="nav-tab-wrapper">
						<a href="#top#general" id="general-tab" class="nav-tab"><?php _e('General','easy-modal')?></a>
						<a href="#top#login_modal" id="login_modal-tab" class="nav-tab"><?php _e('Login Modal','easy-modal')?></a>
					</h2>
					<div class="tabwrapper">
						<form method="post" action="admin.php?page=<?php echo EASYMODAL_SLUG?>-settings">
							<input type="hidden" name="em_settings" value="settings"/>
							<div id="general" class="em-tab">
								<table class="form-table">
									<tbody>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="name"><?php _e('License Key', 'easy-modal');?> <span class="description">(required)</span></label>
											</th>
											<td>
												<input <?php echo $valid ? 'style="background-color:#0f0;border-color:#090;"' : '' ?> type="password" id="license" name="license" value="<?php esc_attr_e(get_option('EasyModal_License'))?>"/>
												<p class="description"><?php _e( is_array($license_status) && !empty($license_status['message']) ? $license_status['message'] : 'Enter a key to unlock Easy Modal Pro.','easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="autoOpen_id"><?php _e( "Auto Open Modal.", 'easy-modal' ); ?></label>
											</th>
											<td>
												<select name="autoOpen_id" id="autoOpen_id">
													<option></option>
													<?php foreach($modals as $key => $name){ ?>
													<option value="<?php esc_attr_e($key)?>"<?php echo $settings['autoOpen_id'] ==  $key ? esc_attr(' selected="selected"') : ''?>><?php esc_html_e($name)?></option>
													<?php }?>
												</select>
												<p class="description"><?php _e( 'Select which modals to popup on first visit.','easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="autoOpen_delay"><?php _e( "Auto Open Delay.", 'easy-modal' ); ?></label>
											</th>
											<td>
												<input type="text" name="autoOpen_delay" id="autoOpen_delay" style="width:100px" value="<?php esc_attr_e($settings['autoOpen_delay'])?>"/>ms
												<p class="description"><?php _e( 'How long to delay before showing.','easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="autoOpen_timer"><?php _e( "Auto Open Timer.", 'easy-modal' ); ?></label>
											</th>
											<td>
												<input type="text" name="autoOpen_timer" id="autoOpen_timer" style="width:100px" value="<?php esc_attr_e($settings['autoOpen_timer'])?>"/>days
												<p class="description"><?php _e( 'Time set in cookie before modal will be shown again.','easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="autoExit_id"><?php _e( "Exit Detected Modal", 'easy-modal' ); ?></label>
											</th>
											<td>
												<select name="autoExit_id" id="autoExit_id">
													<option></option>
													<?php foreach($modals as $key => $name){ ?>
													<option value="<?php esc_attr_e($key)?>"<?php echo $settings['autoExit_id'] ==  $key ? esc_attr(' selected="selected"') : ''?>><?php esc_html_e($name)?></option>
													<?php }?>
												</select>
												<p class="description"><?php _e( "Select which modals to popup on vistor exit.",'easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="autoExit_timer"><?php _e( "Auto Exit Timer.", 'easy-modal' ); ?></label>
											</th>
											<td>
												<input type="text" name="autoExit_timer" id="autoExit_timer" style="width:100px" value="<?php esc_attr_e($settings['autoExit_timer'])?>"/>days
												<p class="description"><?php _e( 'Time set in cookie before modal will be shown again.','easy-modal')?></p>
											</td>
										</tr>
									</tbody>
								</table>							
							</div>
							<div id="login_modal" class="em-tab">
								<table class="form-table">
									<tbody>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="login_modal_enabled"><?php _e('Login Modal Enabled', 'easy-modal');?></label>
											</th>
											<td>
												<p class="field switch" style="clear:both; overflow:auto; display:block;">
													<label class="cb-enable"><span>Yes</span></label>
													<label class="cb-disable selected"><span>No</span></label>
													<input type="checkbox" class="checkbox" id="login_modal_enabled" name="login_modal_enabled" value="true" <?php echo $settings['login_modal_enabled'] == true ? 'checked="checked"' : '' ?> />
												</p>
												<p class="description"><?php _e('Enable login modal?','easy-modal')?>To customize the login modal click <a href="admin.php?page=<?php echo EASYMODAL_SLUG?>&modal_id=Login">here</a>.</p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="force_user_login"><?php _e('Force User Login', 'easy-modal');?></label>
											</th>
											<td>
												<p class="field switch" style="clear:both; overflow:auto; display:block;">
													<label class="cb-enable"><span>Yes</span></label>
													<label class="cb-disable selected"><span>No</span></label>
													<input type="checkbox" class="checkbox" id="force_user_login" name="force_user_login" value="true" <?php echo $settings['force_user_login'] == true ? 'checked="checked"' : '' ?> />
												</p>
												<p class="description"><?php _e('Force users to login, otherwise they get login modal.','easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="registration_modal[enable_password]"><?php _e('Register with Password', 'easy-modal');?></label>
											</th>
											<td>
												<p class="field switch" style="clear:both; overflow:auto; display:block;">
													<label class="cb-enable"><span>Show</span></label>
													<label class="cb-disable selected"><span>Hide</span></label>
													<input type="checkbox" class="checkbox" id="registration_modal[enable_password]" name="registration_modal[enable_password]" value="true" <?php echo $settings['registration_modal']['enable_password'] == true ? 'checked="checked"' : '' ?> />
												</p>
												<p class="description"><?php _e('Show password field in registration modal.','easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="registration_modal[autologin]"><?php _e('Autologin New User', 'easy-modal');?></label>
											</th>
											<td>
												<p class="field switch" style="clear:both; overflow:auto; display:block;">
													<label class="cb-enable"><span>Yes</span></label>
													<label class="cb-disable selected"><span>No</span></label>
													<input type="checkbox" class="checkbox" id="registration_modal[autologin]" name="registration_modal[autologin]" value="true" <?php echo $settings['registration_modal']['autologin'] == true ? 'checked="checked"' : '' ?> />
												</p>
												<p class="description"><?php _e('Automatically login user after registration.','easy-modal')?></p>
											</td>
										</tr>
									</tbody>
								</table>							
							</div>
							<div class="submit">
								<input type="hidden" name="safe_csrf_nonce_easy_modal" id="safe_csrf_nonce_easy_modal" value="<?php echo wp_create_nonce("safe_csrf_nonce_easy_modal"); ?>">
								<input type="submit" value="<?php _e('Save Settings','easy-modal')?>" name="submit" class="button-primary">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<?php require(EASYMODAL_DIR.'/pro/views/sidebar.php')?>
			</div>
		</div>
		<br class="clear"/>
	</div>
</div>