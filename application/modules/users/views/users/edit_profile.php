<section id="profile">

	<div class="page-header">
		<h1><?php echo lang('us_edit_profile'); ?></h1>
	</div>

	<?php if (validation_errors()) : ?>
	<div class="row-fluid">
		<div class="span8 offset2">
			<div class="alert alert-error">
				<?php echo validation_errors(); ?>
			</div>
		</div>
	</div>
	<?php endif;
		if (isset($user) && $user->role_name == 'Banned') : ?>
		<div data-dismiss="alert" class="alert alert-error">
			<?php echo lang('us_banned_admin_note'); ?>
		</div>
	<?php endif; ?>

	<div class="alert alert-info">
		<h4 class="alert-heading"><?php echo lang('bf_required_note'); ?></h4>
		<?php if (isset($password_hints)):
			echo $password_hints;
		endif;?>
	</div>

	<div class="row-fluid">
		<!-- Sub Nav -->
		<div class='span3'>
			<ul>
				<li><a href="<?php echo site_url('/users/edit_profile') ?>" id="personal_data">Personal data</a></li>
				<li><a href="<?php echo site_url('/users/profile_education') ?>" id="education_data">Education data</a></li>
				<li><?php $userRecord = $this->otherdata_model->find_by('user_id', $user->id);	
					if (!empty($userRecord))
						echo anchor(site_url('/users/other_data/' . $userRecord->otherD_id), 'Edit Other Details');
					else
						echo anchor(site_url('/users/create_other_data/'. $user->id), 'Create Other Details'); 
				?></li>
			</ul>
		</div>

		<!-- Upload form -->
		<div class="span9">
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
		<?php echo form_close();?>

		<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
			<fieldset>
				<legend>Personal Data</legend>
			<!--Last Name-->
				<div class="control-group <?php echo iif( form_error('lastname') , 'error') ;?>">
					<label class="control-label" for="lastname"><?php echo lang('user_lastname'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="lastname" name="lastname" placeholder="What is your father's name?" value="<?php echo set_value('lastname', isset($user) ? $user->lastname : '') ?>" />
					</div>
				</div>
			<!--First Name-->
				<div class="control-group <?php echo iif( form_error('firstname') , 'error') ;?>">
					<label class="control-label" for="firstname"><?php echo lang('user_firstname'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="firstname" name="firstname" placeholder="What is your first name?" value="<?php echo set_value('firstname', isset($user) ? $user->firstname : '') ?>" />
					</div>
				</div>
			<!--Middle Name-->
				<div class="control-group <?php echo iif( form_error('middlename') , 'error') ;?>">
					<label class="control-label" for="middlename"><?php echo lang('user_middlename'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="middlename" name="middlename" placeholder="What is your middle or other name?" value="<?php echo set_value('middlename', isset($user) ? $user->middlename : '') ?>" />
					</div>
				</div>

				<?php if (isset($user) && $user->role_id == '1' || isset($user) && $user->role_id == '2' || isset($user) && $user->role_id == '6') : ?>
				<div class="control-group <?php echo iif( form_error('display_name') , 'error') ;?>">
					<label class="control-label" for="display_name"><?php echo lang('bf_display_name'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="display_name" name="display_name" placeholder="Preferrably, please use your job tittle here" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : '') ?>" />
					</div>
				</div>
				<?php endif; ?>

				<div class="control-group <?php echo iif( form_error('email') , 'error') ;?>">
					<label class="control-label required" for="email"><?php echo lang('bf_email'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="email" name="email" placeholder="What is your email address?" value="<?php echo set_value('email', isset($user) ? $user->email : '') ?>" />
					</div>
				</div>

			<?php #if (isset($user) && $user->role_id == '1' || isset($user) && $user->role_id == '2' || isset($user) && $user->role_id =='6') : 
				if ( settings_item('auth.login_type') !== 'email' OR settings_item('auth.use_usernames')) : ?>
				<div class="control-group <?php echo iif( form_error('username') , 'error') ;?>">
					<label class="control-label required" for="username"><?php echo lang('bf_username'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="username" name="username" placeholder="Enter your Staff/Matric/Jamb number here" value="<?php echo set_value('username', isset($user) ? $user->username : '') ?>" />
					</div>
				</div>
				<?php endif;
			#endif; ?>

				<div class="control-group <?php echo iif( form_error('password') , 'error') ;?>">
					<label class="control-label" for="password"><?php echo lang('bf_password'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="password" id="password" name="password" placeholder="Enter your password; minimun of 8 characters" value="" />
					</div>
				</div>

				<div class="control-group <?php echo iif( form_error('pass_confirm') , 'error') ;?>">
					<label class="control-label" for="pass_confirm"><?php echo lang('bf_password_confirm'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="password" id="pass_confirm" name="pass_confirm" placeholder="Please, re-enter your password above" value="" />
					</div>
				</div>

					<?php if (isset($languages) && is_array($languages) && count($languages)) :
						if(count($languages) == 1): ?>
							<input type="hidden" id="language" name="language" value="<?php echo $languages[0]; ?>">
						<?php else: ?>
							<div class="control-group <?php echo form_error('language') ? 'error' : '' ?>">
								<label class="control-label required" for="language"><?php echo lang('bf_language') ?></label>
								<div class="controls">
									<select name="language" id="language" class="chzn-select">
									<?php foreach ($languages as $language) : ?>
										<option value="<?php e($language) ?>" <?php echo set_select('language', $language, isset($user->language) && $user->language == $language ? TRUE : FALSE) ?>>
											<?php e(ucfirst($language)) ?>
										</option>
									<?php endforeach; ?>
									</select>
									<?php if (form_error('language')) echo '<span class="help-inline">'. form_error('language') .'</span>'; ?>
								</div>
							</div>
						<?php endif;
					endif; ?>

					<?php if (isset($user) && $user->role_id == '1') : ?>
					<div class="control-group <?php echo form_error('timezone') ? 'error' : '' ?>">
						<label class="control-label required" for="timezones"><?php echo lang('bf_timezone') ?></label>
						<div class="controls">
							<?php echo timezone_menu(set_value('timezones', isset($user) ? $user->timezone : $current_user->timezone)); ?>
							<?php if (form_error('timezones')) echo '<span class="help-inline">'. form_error('timezones') .'</span>'; ?>
						</div>
					</div>
					<?php endif; ?>

					<?php
						// Allow modules to render custom fields
						Events::trigger('render_user_form', $user );
					?>

					<!-- Start User Meta -->
					<?php $this->load->view('users/user_meta', array('frontend_only' => TRUE));?>
					<!-- End of User Meta -->

				<!-- Start of Form Actions -->
				<div class="form-actions">
					<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') .' '. lang('bf_user') ?> " /> <?php echo lang('bf_or') ?>
					<?php echo anchor('/users/view_profile', lang('bf_action_cancel')); ?>
				</div>
			</fieldset>
		<!-- End of Form Actions -->

		<?php echo form_close(); ?>

		</div>
	</div>
</section>
<?php

	$inline = <<<EOL

	$(".chzn-select").chosen();
	$(".datepicker").datepicker();

EOL;

	Assets::add_js( $inline, 'inline' );
	unset ( $inline );

?>