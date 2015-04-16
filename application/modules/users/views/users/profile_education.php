<section id="profile">
	<div class="page-header">
		<h1><?php echo lang('us_edit_profile').': '.lang('user_education').' Data'; ?></h1>
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

		<div class="span9">
		<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
			<fieldset>
				<legend><?php echo lang('user_education').' Data'; ?></legend>
				<div class="control-group <?php echo iif( form_error('edu_centre_name') , 'error') ;?>">
					<label class="control-label" for="edu_centre_name"><?php echo 'Institution/Exam Centre'; ?></label>
					<div class="controls">
						<?php if (form_error('edu_centre_name')) echo '<span class="help-inline">'. form_error('edu_centre_name') .'</span>'; ?>
						<input class="input-xxlarge" type="text" id="edu_centre_name" name="edu_centre_name" placeholder="Enter name of institution or examination Centre" value="<?php echo set_value('edu_centre_name', isset($post) ? $post->edu_centre_name : '') ?>" />
					</div>
				</div>

				<div class="control-group <?php echo iif( form_error('edu_start_date') , 'error') ;?>">
					<label class="control-label required" for="edu_start_date"><?php echo 'Start Date'; ?></label>
					<div class="controls">
						<?php if (form_error('edu_start_date')) echo '<span class="help-inline">'. form_error('edu_start_date') .'</span>'; ?>
						<input class="input-xxlarge datepicker" type="text" id="edu_start_date" name="edu_start_date" placeholder="Enter start date as DD/MM/YYYY" value="<?php echo set_value('edu_start_date', isset($post) ? $post->edu_start_date : '') ?>" />
					</div>
				</div>

				<div class="control-group <?php echo iif( form_error('edu_end_date') , 'error') ;?>">
					<label class="control-label required" for="edu_end_date"><?php echo 'End Date'; ?></label>
					<div class="controls">
						<?php if (form_error('edu_end_date')) echo '<span class="help-inline">'. form_error('edu_end_date') .'</span>'; ?>
						<input class="input-xxlarge datepicker" type="text" id="edu_end_date" name="edu_end_date" placeholder="Enter end date as DD/MM/YYYY" value="<?php echo set_value('edu_end_date', isset($post) ? $post->edu_end_date : '') ?>" />
					</div>
				</div>

				<div class="control-group <?php echo iif( form_error('edu_certificate') , 'error') ;?>">
					<label class="control-label required" for="edu_certificate"><?php echo 'Certificate'; ?></label>
					<div class="controls">
						<?php if (form_error('edu_certificate')) echo '<span class="help-inline">'. form_error('edu_certificate') .'</span>'; ?>
						<input class="input-xxlarge" type="text" id="edu_certificate" name="edu_certificate" placeholder="Enter certificate obtain here" value="<?php echo set_value('edu_certificate', isset($post) ? $post->edu_certificate : '') ?>" />
					</div>
				</div>

				<div class="control-group <?php if (form_error('edu_result')) echo 'error'; ?>">
					<label class="control-label required" for="edu_result">Result/Grade</label>
					<div class="controls">
						<?php if (form_error('edu_result')) echo '<span class="help-inline">'. form_error('edu_result') .'</span>'; ?>
						<textarea name="edu_result" class="input-xxlarge" rows="3" placeholder="Enter your result here"><?php echo set_value('edu_result', isset($post) ? $post->edu_result : '') ?></textarea>
					</div>
				</div>

				<?php
					// Allow modules to render custom fields
					Events::trigger('render_user_form', $user );
				?>

				<!-- Start of Form Actions -->
				<div class="form-actions">
					<input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('bf_action_save') .' '. lang('user_education') ?> " /> <?php echo lang('bf_or') ?>
					<?php echo anchor('/users/edit_profile', lang('bf_action_cancel')); ?>
				</div>
			</fieldset>
		<!-- End of Form Actions -->

		<?php echo form_close(); ?>

    	<h3>List of Added Educational Information</h3>
    	<?php echo form_open('users/delete_edu_data'); ?>
		<table class="table table-striped">
	        <thead>
				<tr>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<th>Institution/Exam Centre</th>
					<th>Certificate</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Result/Grade</th>
					<!--th style="width: 8%"></th-->
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="6">With selected:&nbsp;
						<input type="submit" name="delete" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Education Information(s)?')">
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php if (isset($education) && is_array($education)) :
				foreach ($education as $edu) : ?>
				<tr>
					<td><input type="checkbox" name="checked[]" value="<?php echo $edu->edu_id ?>" /></td>
					<td><a href="<?php echo site_url(SITE_AREA .'/users/users/edit_profile_education/'. $edu->edu_id) ?>">
						<?php e($edu->edu_centre_name); ?></a></td>
					<td><?php e($edu->edu_certificate); ?></td>
					<td><?php e($edu->edu_start_date); ?></td>
					<td><?php e($edu->edu_end_date); ?></td>
					<td><?php e($edu->edu_result); ?></td>
					<!--td><a class="edit" title="Click to edit" href="<?php echo site_url(SITE_AREA .'/users/users/edit_profile_education/'. $edu->edu_id) ?>"></a> 
						<a class="delete" title="Click to delete" href="<?php echo site_url(SITE_AREA .'/users/users/edit_profile_education/delete_edu_data/'. $edu->edu_id) ?>"></a></td-->
				</tr>
				<?php endforeach;
            else: ?>
				<tr>
					<td colspan="6">
						<br/>
						<div class="alert alert-warning">No Educational History found!</div>
					</td>
				</tr>

				<?php endif; ?>
			</tbody>
		</table>
		<?php echo form_close(); ?>
		</div>
	</div>
</section>
<?php
	$inline = <<<EOL
	$(".datepicker").datepicker();
EOL;
	Assets::add_js( $inline, 'inline' );
	unset ( $inline );
?>