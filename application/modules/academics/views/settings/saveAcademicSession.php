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

	$id = isset($post->aca_Session_id) ? $post->aca_Session_id : '';
?>

<div class="admin-box">
	<h3><?php e($subHeader); ?></h3>

	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>
	<!--Session Name-->
		<div class="control-group<?php if (form_error('session')) echo 'error'; ?>">
			<?php echo form_label(lang('pras_field_session') . lang('bf_form_label_required'), 'session', array('class' => 'control-label')); ?>
			<div class="controls">
				<select name="session" class="input-xxlarge chzn-select">
					<option value="0" >Please select the right session...</option>
					<?php foreach($sessions as $key=>$name){
		                if ($key == $post->session){
		                    $selected = ' selected=selected ';
		                } else {
		                    $selected = '';
		                }
		                echo "<option $selected value=$key>$name</option>";
		            }?>
	            </select>
			</div>
		</div>
	<!--Start Date-->
		<div class="control-group <?php if (form_error('startDate')) echo 'error'; ?>">
			<?php echo form_label(lang('pras_field_startDate') . lang('bf_form_label_required'), 'status', array('class' => 'control-label')); ?>
			<div class="controls">
				<input type="text" name="startDate" class="input-xxlarge datepicker" placeholder="Type Start Date here..."
					value="<?php echo set_value('startDate', isset($post) ? $post->startDate : ''); ?>" />
				<?php if (form_error('startDate')) echo '<span class="help-inline">'. form_error('startDate') .'</span>'; ?>
			</div>
		</div>
	<!--End Date-->
		<div class="control-group <?php if (form_error('endDate')) echo 'error'; ?>">
			<?php echo form_label(lang('pras_field_endDate') . lang('bf_form_label_required'), 'status', array('class' => 'control-label')); ?>
			<div class="controls">
				<input type="text" name="endDate" class="input-xxlarge datepicker" placeholder="Type End Date here..."
					value="<?php echo set_value('endDate', isset($post) ? $post->endDate : ''); ?>" />
				<?php if (form_error('endDate')) echo '<span class="help-inline">'. form_error('endDate') .'</span>'; ?>
			</div>
		</div>
	<!--Study Mode-->
		<div class="control-group <?php if (form_error('studyMode')) echo 'error'; ?>">
			<?php echo form_label(lang('pras_field_studyMode') . lang('bf_form_label_required'), 'status', array('class' => 'control-label')); ?>
			<div class="controls">
				<select name="studyMode" class="input-xxlarge chzn-select">
					<option value="0" >Please select the right Study Mode...</option>
					<?php foreach($studyModes as $key=>$name){
	                    if ($key == $post->studyMode){
	                        $selected = " selected=selected ";
	                    } else {
	                        $selected = "";
	                    }
	                    echo "<option $selected value=$key>$name</option>";
	                }?>
	            </select>
				<?php if (form_error('studyMode')) echo '<span class="help-inline">'. form_error('studyMode') .'</span>'; ?>
			</div>
		</div>
	<!--Status-->
		<div class="control-group<?php if (form_error('status')) echo 'error'; ?>">
			<?php echo form_label(lang('pras_field_status') . lang('bf_form_label_required'), 'status', array('class' => 'control-label')); ?>
			<div class="controls">
				<select name="status" class="input-xxlarge chzn-select">
					<option value="0" >Please select the right Status...</option>
					<?php foreach($status as $key=>$name){
		                if ($key == $post->status){
		                    $selected = ' selected=selected ';
		                } else {
		                    $selected = "";
		                }
		                echo "<option $selected value=$key>$name</option>";
		            }?>
				</select>
				<?php if (form_error('status')) echo '<span class="help-inline">'. form_error('status') .'</span>'; ?>
			</div>
		</div>

		<div class="form-actions">
			<input type="submit" name="save" class="btn btn-primary" value="Save" />
			<a href="<?php echo site_url(SITE_AREA .'/settings/academics') ?>" class="btn btn-warning">Cancel</a>
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
