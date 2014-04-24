<input type="hidden" name="safe_csrf_nonce_easy_modal" id="safe_csrf_nonce_easy_modal" value="<?php echo wp_create_nonce("safe_csrf_nonce_easy_modal"); ?>">
<table class="form-table">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="easy_modal_post_modals"><?php _e( "Select which modals to load", 'easy-modal' ); ?></label>
			</th>
			<td>
				<select class="widefat" multiple="multiple" name="easy_modal_post_modals[]" id="easy_modal_post_modals">
					<?php foreach($modals as $key => $name)
					{
						$modal = $this->getModalSettings($key);
						if(!$modal['sitewide'] && !in_array($key,array('Login','Register','Forgot'))){?>
						<option value="<?php esc_attr_e($key)?>"<?php echo (is_array($current_modals) && in_array($key,$current_modals)) ? esc_attr(' selected="selected"') : ''?>><?php esc_html_e($name)?></option>
						<?php }
					}?>
				</select>
				<p class="description"><?php _e( 'Select which modals to load.','easy-modal')?></p>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="easy_modal_post_autoOpen_id"><?php _e( "Auto Open Modal.", 'easy-modal' ); ?></label>
			</th>
			<td>
				<select name="easy_modal_post_autoOpen_id" id="easy_modal_post_autoOpen_id">
					<option></option>
					<?php foreach($modals as $key => $name){ ?>
					<option value="<?php esc_attr_e($key)?>"<?php echo $current_autoOpen_id ==  $key ? esc_attr(' selected="selected"') : ''?>><?php esc_html_e($name)?></option>
					<?php }?>
				</select>
				<p class="description"><?php _e( 'Select which modals to popup on first visit.','easy-modal')?></p>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="easy_modal_post_autoOpen_delay"><?php _e( "Auto Open Delay.", 'easy-modal' ); ?></label>
			</th>
			<td>
				<input type="text" name="easy_modal_post_autoOpen_delay" id="easy_modal_post_autoOpen_delay" style="width:100px" value="<?php esc_attr_e($current_autoOpen_delay)?>"/>ms
				<p class="description"><?php _e( 'How long to delay before showing.','easy-modal')?></p>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="easy_modal_post_autoOpen_timer"><?php _e( "Auto Open Timer.", 'easy-modal' ); ?></label>
			</th>
			<td>
				<input type="text" name="easy_modal_post_autoOpen_timer" id="easy_modal_post_autoOpen_timer" style="width:100px" value="<?php esc_attr_e($current_autoOpen_timer)?>"/>days
				<p class="description"><?php _e( 'Time set in cookie before modal will be shown again.','easy-modal')?></p>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="easy_modal_post_autoExit_id"><?php _e( "Exit Detected Modal", 'easy-modal' ); ?></label>
			</th>
			<td>
				<select name="easy_modal_post_autoExit_id" id="easy_modal_post_autoExit_id">
					<option></option>
					<?php foreach($modals as $key => $name){ ?>
					<option value="<?php esc_attr_e($key)?>"<?php echo $current_autoExit_id ==  $key ? esc_attr(' selected="selected"') : ''?>><?php esc_html_e($name)?></option>
					<?php }?>
				</select>
				<p class="description"><?php _e( "Select which modals to popup on vistor exit.",'easy-modal')?></p>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="easy_modal_post_autoExit_timer"><?php _e( "Auto Exit Timer.", 'easy-modal' ); ?></label>
			</th>
			<td>
				<input type="text" name="easy_modal_post_autoExit_timer" id="easy_modal_post_autoExit_timer" style="width:100px" value="<?php esc_attr_e($current_autoExit_timer)?>"/>days
				<p class="description"><?php _e( 'Time set in cookie before modal will be shown again.','easy-modal')?></p>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="easy_modal_post_force_user_login"><?php _e('Force User Login with Modal', 'easy-modal');?></label>
			</th>
			<td>
				<input style="width:auto;" type="checkbox" class="checkbox" id="easy_modal_post_force_user_login" name="easy_modal_post_force_user_login" value="true" <?php echo $current_force_user_login == true ? 'checked="checked"' : '' ?> />
				<p class="description"><?php _e('Force user login with a modal window.','easy-modal')?></p>
			</td>
		</tr>
	</tbody>
</table>