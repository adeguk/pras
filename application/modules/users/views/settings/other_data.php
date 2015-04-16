<section id="profile">
	<div class="page-header">
		<h1>Edit Other User Data</h1>
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
	</div>

	<div class="row-fluid">
		<div class='span3'>
			<ul>
				<li><a href="<?php echo site_url(SITE_AREA.'/settings/users/edit') ?>" id="personal_data">Personal data</a></li>
				<li><a href="<?php echo site_url(SITE_AREA.'/settings/users/other_data') ?>" id="other_data">Other data</a></li>
			</ul>
		</div>

		<div class="span9">
			<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
			<fieldset>
				<legend>Other Personal Data</legend>
			<!--religion-->
				<div class="control-group <?php echo iif( form_error('religion') , 'error') ;?>">
					<label class="control-label" for="religion"><?php echo lang('user_religion'); ?></label>
					<div class="controls">
						<select name="religion" class="input-xxlarge">
						<option value="0" >Please select the right religion...</option>
						<?php $religions = config_item('miscellaneous.religion');
			                foreach($religions as $key=>$name){
			                    if ($key == $post->religion){
			                        $selected = " selected=selected ";
			                    } else {
			                        $selected = "";
			                    }
			                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
			                }?>
			            </select>
						<?php if (form_error('religion')) echo '<span class="help-inline">'. form_error('religion') .'</span>'; ?>
					</div>
				</div>
			<!--marital status-->
				<div class="control-group <?php echo iif( form_error('marital_status') , 'error') ;?>">
					<label class="control-label" for="marital_status"><?php echo lang('user_marital_status'); ?></label>
					<div class="controls">
						<select name="marital_status" class="input-xxlarge">
						<option value="0" >Please select the right marital status...</option>
						<?php $ms = config_item('miscellaneous.marital_status');
			                foreach($ms as $key=>$name){
			                    if ($key == $post->marital_status){
			                        $selected = " selected=selected ";
			                    } else {
			                        $selected = "";
			                    }
			                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
			                }?>
			            </select>
						<?php if (form_error('marital_status')) echo '<span class="help-inline">'. form_error('marital_status') .'</span>'; ?>
					</div>
				</div>
			<!--health status-->
				<div class="control-group <?php echo iif( form_error('health_status') , 'error') ;?>">
					<label class="control-label" for="health_status"><?php echo lang('user_health_status'); ?></label>
					<div class="controls">
						<select name="health_status" class="input-xxlarge">
						<option value="0" >Please select the right health status...</option>
						<?php $hs = config_item('miscellaneous.health_status');
			                foreach($hs as $key=>$name){
			                    if ($key == $post->health_status){
			                        $selected = " selected=selected ";
			                    } else {
			                        $selected = "";
			                    }
			                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
			                }?>
			            </select>
						<?php if (form_error('health_status')) echo '<span class="help-inline">'. form_error('health_status') .'</span>'; ?>
					</div>
				</div>
			</fieldset>
		<!--------------------------------------start another fieldset------------------------------------------------------>
			<br />
			<fieldset>
				<legend>Next of Kin/Emergency Contact</legend>
			<!--Fullname-->
				<div class="control-group <?php echo form_error('nok_fullname') ? 'error' : '' ;?>">
					<label class="control-label required" for="nok_fullname"><?php echo lang('user_fullname'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="nok_fullname" name="nok_fullname" placeholder="Enter the fullname of your next of kin.." value="<?php echo set_value('nok_fullname', isset($post) ? $post->nok_fullname : '') ?>" />
					</div>
				</div>
			<!--FullAddress-->
				<div class="control-group <?php echo form_error('nok_full_address') ? 'error' : '' ;?>">
					<label class="control-label" for="nok_full_address">Full Address</label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="nok_full_address" name="nok_full_address" placeholder="Enter the contact address of your next of kin" value="<?php echo set_value('nok_full_address', isset($post) ? $post->nok_full_address : '') ?>" />
					</div>
				</div>
			<!--marital status-->
				<div class="control-group <?php echo form_error('nok_mobile') ? 'error' : '' ;?>">
					<label class="control-label" for="nok_mobile"><?php echo lang('user_meta_telephone'); ?></label>
					<div class="controls">
						<input class="input-xxlarge" type="text" id="nok_mobile" name="nok_mobile" placeholder="Enter your mobile/telephone number..." value="<?php echo set_value('nok_mobile', isset($post) ? $post->nok_mobile : '') ?>" />
					</div>
				</div>

				<!-- Start of Form Actions -->
				<div class="form-actions">
					<input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('bf_action_save') .' '. lang('bf_user') ?> " /> <?php echo lang('bf_or') ?>
					<?php echo anchor(SITE_AREA.'/settings/users', lang('bf_action_cancel')); ?>
				</div>
			</fieldset>
		<!-- End of Form Actions -->

		<?php echo form_close(); ?>

		</div>
	</div>
</section>
