<?php if (isset($user) && $user->banned) : ?>
<div class="alert alert-warning fade in">
	<h4 class="alert-heading"><?php echo lang('us_banned_admin_note'); ?></h4>
</div>
<?php endif; 

if (isset($password_hints) ) : ?>
<div class="row-fluid">
	<div class="span8 offset2">
		<div class="alert alert-info fade in">
		  <a data-dismiss="alert" class="close">&times;</a>
			<?php echo $password_hints; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<div class="alert alert-info">
	<h4 class="alert-heading"><?php echo lang('bf_required_note'); ?></h4>
</div>

<div class="row-fluid">
	<!-- Upload form -->
		<?php echo form_open_multipart('do_upload', array('class' => "form-horizontal", 'autocomplete' => 'off'));	?>
		<fieldset>
			<legend><?php echo lang('user_meta_upload_image'); ?></legend>
			<div class="control-group <?php echo iif( form_error('passport') , 'error') ;?>">
				<label class="control-label" for="passport"><?php echo 'passport'; ?></label>
				<div class="controls">
					<input class="span6" type="file" id="passport" name="passport" value="<?php #echo set_value('passport', isset($user) ? $user->passport : '') ?>" />
					<input type="submit" name="upload" class="btn btn-primary" value="Upload" />
				</div>
			</div>
		</fieldset>
		<?php echo form_close();
		// Choose user role
			echo form_open($this->uri->uri_string(), 'class="form-horizontal" autocomplete="off"');
			if (has_permission('Bonfire.Roles.Manage') &&
          		(!isset($user) || (isset($user) && has_permission('Permissions.'.$user->role_name.'.Manage'))))
		:?>
		<fieldset>
			<legend><?php echo lang('us_role'); ?></legend>
			<div class="control-group">
				<label for="role_id" class="control-label"><?php echo lang('us_role'); ?></label>
				<div class="controls">
					<select name="role_id" id="role_id" class="chzn-select">
					<?php if (isset($roles) && is_array($roles) && count($roles)) :
						foreach ($roles as $role) :
							if (has_permission('Permissions.'. ucfirst($role->role_name) .'.Manage')) : 
								// check if it should be the default
								$default_role = FALSE;
								if ((isset($user) && $user->role_id == $role->role_id) || (!isset($user) && $role->default == 1)) {
									$default_role = TRUE;
								} ?>
						<option value="<?php echo $role->role_id ?>" <?php echo set_select('role_id', $role->role_id, $default_role) ?>>
							<?php e(ucfirst($role->role_name)) ?>
						</option>
							<?php endif; 
						endforeach;
					endif; ?>
					</select>
				</div>
			</div>
		</fieldset>
		<br />
		<?php endif;
			
			if (isset($user) && has_permission('Permissions.'. ucfirst($user->role_name).'.Manage') && $user->id != $this->auth->user_id() && ($user->banned || $user->deleted)) : ?>
		<fieldset>
				<legend><?php echo lang('us_account_status') ?></legend>
			<?php
				$field = 'activate';
				if ($user->active) :
						$field = 'de'.$field;
				endif; ?>
				<div class="control-group">
					<div class="controls">
						<label for="<?php echo $field; ?>">
						<input type="checkbox" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="1">
							<?php echo lang('us_'.$field.'_note') ?>
						</label>
					</div>
				</div>

				<?php if ($user->deleted) : ?>
				<div class="control-group">
					<div class="controls">
						<label for="restore">
							<input type="checkbox" name="restore" id="restore" value="1">
							<?php echo lang('us_restore_note') ?>
						</label>
					</div>
				</div>

				<?php elseif ($user->banned) :?>
				<div class="control-group">
					<div class="controls">
						<label for="unban">
							<input type="checkbox" name="unban" id="unban" value="1">
							<?php echo lang('us_unban_note') ?>
						</label>
					</div>
				</div>
				<?php endif; ?>
		</fieldset>
		<?php endif; ?>
		<!-- Biodata form-->
		<fieldset>
			<legend><?php echo 'Personal '.lang('us_account_details') ?></legend>
			<!--Last Name-->
			<div class="control-group <?php echo iif( form_error('lastname') , 'error') ;?>">
				<label class="control-label" for="lastname"><?php echo lang('user_lastname'); ?></label>
				<div class="controls">
					<input class="input-xxlarge" type="text" id="lastname" name="lastname" placeholder="What is your father's name?" value="<?php echo set_value('lastname', isset($user) ? $user->lastname : '') ?>" />
				<?php if (form_error('lastname')) echo '<span class="help-inline">'. form_error('lastname') .'</span>'; ?>
				</div>
			</div>
			<!--First Name-->
			<div class="control-group <?php echo iif( form_error('firstname') , 'error') ;?>">
				<label class="control-label" for="firstname"><?php echo lang('user_firstname'); ?></label>
				<div class="controls">
					<input class="input-xxlarge" type="text" id="firstname" name="firstname" placeholder="What is your first name?" value="<?php echo set_value('firstname', isset($user) ? $user->firstname : '') ?>" />
				<?php if (form_error('firstname')) echo '<span class="help-inline">'. form_error('firstname') .'</span>'; ?>
				</div>
			</div>
			<!--Middle Name-->
			<div class="control-group <?php echo iif( form_error('middlename') , 'error') ;?>">
				<label class="control-label" for="middlename"><?php echo lang('user_middlename'); ?></label>
				<div class="controls">
					<input class="input-xxlarge" type="text" id="middlename" name="middlename" placeholder="What is your middle or other name?" value="<?php echo set_value('middlename', isset($user) ? $user->middlename : '') ?>" />
				<?php if (form_error('middlename')) echo '<span class="help-inline">'. form_error('middlename') .'</span>'; ?>
				</div>
			</div>
			<!--Display Name-->
			<div class="control-group <?php echo iif( form_error('display_name') , 'error') ;?>">
				<label class="control-label" for="display_name"><?php echo lang('bf_display_name'); ?></label>
				<div class="controls">
					<input class="input-xxlarge" type="text" id="display_name" name="display_name" placeholder="Preferrably, please use your job tittle here" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : '') ?>" />
				<?php if (form_error('display_name')) echo '<span class="help-inline">'. form_error('display_name') .'</span>'; ?>
				</div>
			</div>
			<!-- Account Email-->
			<div class="control-group <?php echo form_error('email') ? 'error' : '' ?>">
				<label for="email" class="control-label"><?php echo lang('bf_email') ?></label>
				<div class="controls">
					<input type="email" name="email" id="email" value="<?php echo set_value('email', isset($user) ? $user->email : '') ?>">
					<?php if (form_error('email')) echo '<span class="help-inline">'. form_error('email') .'</span>'; ?>
				</div>
			</div>
			<!-- Account Username-->
			<div class="control-group <?php echo form_error('username') ? 'error' : '' ?>">
				<label for="username" class="control-label"><?php echo lang('bf_username').'/Registration No.' ?></label>
				<div class="controls">
					<input type="text" name="username" id="username" placeholder="Enter your Staff/Matric/Jamb number here" value="<?php echo set_value('username', isset($user) ? $user->username : '') ?>">
					<?php if (form_error('username')) echo '<span class="help-inline">'. form_error('username') .'</span>'; ?>
				</div>
			</div>
			<!-- Account Password-->
			<div class="control-group <?php echo form_error('password') ? 'error' : '' ?>">
				<label for="password" class="control-label"><?php echo lang('bf_password') ?></label>
				<div class="controls">
					<input type="password" id="password" name="password" value="">
					<?php if (form_error('password')) echo '<span class="help-inline">'. form_error('password') .'</span>'; ?>
				</div>
			</div>

			<div class="control-group <?php echo form_error('pass_confirm') ? 'error' : '' ?>">
				<label class="control-label" for="pass_confirm"><?php echo lang('bf_password_confirm') ?></label>
				<div class="controls">
					<input type="password" name="pass_confirm" id="pass_confirm" value="">
					<?php if (form_error('pass_confirm')) echo '<span class="help-inline">'. form_error('pass_confirm') .'</span>'; ?>
				</div>
			</div>
			<!-- Account language-->
			<div class="control-group <?php echo form_error('language') ? 'error' : '' ?>">
				<label class="control-label" for="language"><?php echo lang('bf_language') ?></label>
				<div class="controls">
					<select name="language" id="language" class="chzn-select">
					<?php if (isset($languages) && is_array($languages) && count($languages)) : ?>
						<?php foreach ($languages as $language) : ?>
							<option value="<?php e($language) ?>" <?php echo set_select('language', $language, isset($user->language) && $user->language == $language ? TRUE : FALSE) ?>>
								<?php e(ucfirst($language)) ?>
							</option>
						<?php endforeach;
						endif; ?>
					</select>
					<?php if (form_error('language')) echo '<span class="help-inline">'. form_error('language') .'</span>'; ?>
				</div>
			</div>

			<div class="control-group <?php echo form_error('timezone') ? 'error' : '' ?>">
				<label class="control-label" for="timezones"><?php echo lang('bf_timezone') ?></label>
				<div class="controls">
					<?php echo timezone_menu(set_value('timezones', isset($user) ? $user->timezone : $current_user->timezone)); ?>
					<?php if (form_error('timezones')) echo '<span class="help-inline">'. form_error('timezones') .'</span>'; ?>
				</div>
			</div>
		<?php
			// Allow modules to render custom fields
			Events::trigger('render_user_form');
		
			//<!-- Start of User Meta -->
			$this->load->view('users/user_meta');
			//<!-- End of User Meta -->
			?>

		<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') .' '. lang('bf_user') ?> " /> <?php echo lang('bf_or') ?>
				<?php echo anchor(SITE_AREA .'/settings/users', lang('bf_action_cancel')); ?>
		</div>
		<?php echo form_close(); ?>
</div>
<?php

	$inline = <<<EOL

	$(".chzn-select").chosen();
	$("#dob").datepicker();

EOL;

	Assets::add_js( $inline, 'inline' );
	unset ( $inline );

?>
