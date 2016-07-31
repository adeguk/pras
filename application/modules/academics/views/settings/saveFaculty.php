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

	$id = isset($post->fac_id) ? $post->fac_id : '';
?>
<div class="admin-box">
	<h3><?php e($subHeader); ?></h3>

	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--Faculty name-->
	<div class="control-group <?php if (form_error('fac_name')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_faculty') . lang('bf_form_label_required'), 'fac_name', array('class' => 'control-label')); ?>
		<div class="controls">
			<input type="text" name="fac_name" class="input-xxlarge" value="<?php echo set_value('fac_name', isset($post) ? $post->fac_name : ''); ?>" placeholder="Type faculty name..." />
			<?php if (form_error('fac_name')) echo '<span class="help-inline">'. form_error('fac_name') .'</span>'; ?>
		</div>
	</div>
<!--faculty Code-->
	<div class="control-group <?php if (form_error('fac_code')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_facultyCode') . lang('bf_form_label_required'), 'fac_code', array('class' => 'control-label')); ?>
		<div class="controls">
			<input type="text" name="fac_code" class="input-xxlarge" value="<?php echo set_value('fac_code', isset($post) ? $post->fac_code : ''); ?>" placeholder="Type faculty name..." />
			<?php if (form_error('fac_code')) echo '<span class="help-inline">'. form_error('fac_code') .'</span>'; ?>
		</div>
	</div>
<!--Dean-->
	<div class="control-group <?php if (form_error('dean')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_dean') . lang('bf_form_label_required'), 'dean', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="fac_dean" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Dean of Faculty...</option>
                <?php editUser_byRole($post->dean, 4); ?>
            </select>
		</div>
	</div>
<!--Status-->
	<div class="control-group <?php if (form_error('status')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_status') . lang('bf_form_label_required'), 'status', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="status" class="input-xxlarge chzn-select">
				<option value="0" >Please select the right Status...</option>
				<?php selectOption($status, $post->status);?>
            </select>
			<?php if (form_error('status')) echo '<span class="help-inline">'. form_error('status') .'</span>'; ?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="save" class="btn btn-primary" value="Save" />
		<a href="<?php echo site_url(SITE_AREA .'/settings/academics/faculty') ?>" class="btn btn-warning">Cancel</a>
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
    $(".datepicker").datepicker();
    EOL;
    Assets::add_js( $inline, 'inline' );
    unset ( $inline );
?>
