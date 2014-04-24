<div class="wrap">
	<?php if(!empty($this->messages)){?>
		<?php foreach($this->messages as $message){?>
		<div class="<?php _e($message['type'],'easy-modal')?>"><strong><?php _e($message['message'],'easy-modal')?>.</strong></div>
		<?php }?>
	<?php }?>
	<?php screen_icon()?>
	<h2><?php _e('Import / Export','easy-modal')?></h2>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<h2 id="em-tabs" class="nav-tab-wrapper">
						<a href="#top#export" id="export-tab" class="nav-tab"><?php _e('Export','easy-modal')?></a>
						<a href="#top#import" id="import-tab" class="nav-tab"><?php _e('Import','easy-modal')?></a>
					</h2>
					<div class="tabwrapper">
						<div id="export" class="em-tab">
							<form method="post" action="admin.php?page=<?php echo EASYMODAL_SLUG?>-importexport">				
								<table class="form-table">
									<tbody>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="type"><?php _e('Export Type', 'easy-modal');?></label>
											</th>
											<td>
												<select name="type" id="type">
													<option value="full">Full</option>
													<option value="settings">Settings</option>
													<option value="themes">Themes</option>
													<option value="modals">Modals</option>
												</select>
												<p class="description"><?php _e('Choose what you want to export.','easy-modal')?></p>
											</td>
										</tr>
									</tbody>
								</table>							
								<div class="submit">
									<input type="submit" name="export" class="button-primary" value="<?php _e('Export','easy-modal')?>" />
								</div>
							</form>
						</div>
						<div id="import" class="em-tab">
							<form method="post" action="admin.php?page=<?php echo EASYMODAL_SLUG?>-importexport" enctype="multipart/form-data">				
								<table class="form-table">
									<tbody>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="file"><?php _e('Import File','easy-modal')?></label>
											</th>
											<td>
												<input type="file" id="file" name="import"/>
												<p class="description"><?php _e('Choose a backup XML file to import.','easy-modal')?></p>
											</td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="force_reset"><?php _e('Force Factory Reset','easy-modal')?></label>
											</th>
											<td>
												<label class="description">
													<input type="checkbox" id="force_reset" name="force_reset" value="true" style="width:auto"/>
													<?php _e('If checked current modals and themes will be lost.','easy-modal')?>
												</label>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="submit">
									<input type="submit" name="import" class="button-primary" value="<?php _e('Import','easy-modal')?>" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<?php require(EASYMODAL_DIR .'/pro/views/sidebar.php')?>
			</div>
		</div>
		<br class="clear"/>
	</div>
</div>