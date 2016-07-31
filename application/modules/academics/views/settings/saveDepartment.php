<?php if (validation_errors()) : ?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('pras_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
	endif;

	$id = isset($post->dept_id) ? $post->dept_id : '';
?>
<div class="admin-box">
	<h3><?php e($subHeader); ?></h3>

	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>
	<div class="control-group <?php if (form_error('dept_name')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_department') . lang('bf_form_label_required'), 'dept_name', array('class' => 'control-label')); ?>
		<div class="controls">
			<input type="text" name="dept_name" class="input-xxlarge" value="<?php echo set_value('dept_name', isset($post) ? $post->dept_name : ''); ?>" placeholder="Type Department name..." />
			<?php if (form_error('dept_name')) echo '<span class="help-inline">'. form_error('dept_name') .'</span>'; ?>
		</div>
	</div>
<!--department Code-->
	<div class="control-group <?php if (form_error('dept_code')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_departmentCode') . lang('bf_form_label_required'), 'dept_code', array('class' => 'control-label')); ?>
		<div class="controls">
			<input type="text" name="dept_code" class="input-xxlarge" value="<?php echo set_value('dept_code', isset($post) ? $post->dept_code : ''); ?>" placeholder="Type faculty name..." />
			<?php if (form_error('dept_code')) echo '<span class="help-inline">'. form_error('dept_code') .'</span>'; ?>
		</div>
	</div>
<!--HOD-->
	<div class="control-group <?php if (form_error('hod')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_hod') . lang('bf_form_label_required'), 'hod', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="hod" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Head of Department...</option>
                <?php editUser_byRole($post->hod, 4); ?>
            </select>
		</div>
	</div>

	<div class="control-group <?php if (form_error('fac_id')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_faculty') . lang('bf_form_label_required'), 'fac_id', array('class' => 'control-label')); ?>
		<div class="controls">
            <select name="fac_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right Faculty...</option>
                <?php selectOption($listFaculty, $post->fac_id); ?>
            </select>
		<?php if (form_error('fac_id')) echo '<span class="help-inline">'. form_error('fac_id') .'</span>'; ?>
       </div>
    </div>

	<div class="control-group <?php if (form_error('status')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_status') . lang('bf_form_label_required'), 'status', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="status" class="input-xxlarge chzn-select">
			    <option value="0" >Please select the right Status...</option>
			    <?php selectOption($status, $post->status); ?>
            </select>
			<?php if (form_error('status')) echo '<span class="help-inline">'. form_error('status') .'</span>'; ?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="save" class="btn btn-primary" value="Save" />
		<a href="<?php echo site_url(SITE_AREA .'/settings/academics/department') ?>" class="btn btn-warning">Cancel</a>
		<?php if ($this->auth->has_permission('Academics.Settings.Delete') && $id > 0) : ?>
			<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me'
				onclick="return confirm('<?php e(js_escape(lang('pras_delete_confirm'))); ?>');">
				<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('pras_delete'); ?>
			</button>
		<?php endif; ?>
	</div>
</fieldset>
<?php echo form_close(); ?>
</div>
<?php
    $inline = <<<EOL

    $(".chzn-select").chosen();
EOL;
    Assets::add_js( $inline, 'inline' );
    unset ( $inline );
?>
