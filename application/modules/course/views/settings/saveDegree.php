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

	$id = isset($post->deg_id) ? $post->deg_id : '';
?>
<div class="admin-box">
	<h3><?php e($subHeader); ?></h3>

	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--Degree name-->
	<div class="control-group <?php if (form_error('degreeName')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_degree') . lang('bf_form_label_required'), 'degreeName', array('class' => 'control-label')); ?>
		<div class="controls">
			<input type="text" name="degreeName" class="input-xxlarge" placeholder="Type Degree name..."
				value="<?php echo set_value('degreeName', isset($post) ? $post->degreeName : ''); ?>" />
			<?php if (form_error('degreeName')) echo '<span class="help-inline">'. form_error('degreeName') .'</span>'; ?>
		</div>
	</div>
<!--degreeAbbreviation-->
	<div class="control-group <?php if (form_error('degreeAbbreviation')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_abbreviation') . lang('bf_form_label_required'), 'degreeAbbreviation', array('class' => 'control-label')); ?>
		<div class="controls">
			<input type="text" name="degreeAbbreviation" class="input-xxlarge" placeholder="Type Degree Abbreviation..."
				value="<?php echo set_value('degreeAbbreviation', isset($post) ? $post->degreeAbbreviation : ''); ?>" />
			<?php if (form_error('degreeAbbreviation')) echo '<span class="help-inline">'. form_error('degreeAbbreviation') .'</span>'; ?>
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
		<a href="<?php echo site_url(SITE_AREA .'/settings/course/degree') ?>" class="btn btn-warning">Cancel</a>
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
