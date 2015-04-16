<div class="admin-box">
	<h3>Create New Academic Session</h3>
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--Session Name-->
	<div class="control-group <?php if (form_error('session')) echo 'error'; ?>">
		<label for="session">Session Name</label>
		<div class="controls">
			<select name="session" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right session...</option>
			<?php $sessions =config_item('miscellaneous.session');
                foreach($sessions as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
		</div>
	</div>
<!--Start Date-->
	<div class="control-group <?php if (form_error('startDate')) echo 'error'; ?>">
		<label for="startDate">Start Date</label>
		<div class="controls">
			<input type="text" name="startDate" class="input-xxlarge datepicker" value="<?php echo set_value('startDate', isset($post) ? $post->startDate : ''); ?>" placeholder="Type Start Date here..." />
			<?php if (form_error('startDate')) echo '<span class="help-inline">'. form_error('startDate') .'</span>'; ?>
		</div>
	</div>
<!--End Date-->
	<div class="control-group <?php if (form_error('endDate')) echo 'error'; ?>">
		<label for="endDate">End Date</label>
		<div class="controls">
			<input type="text" name="endDate" class="input-xxlarge datepicker" value="<?php echo set_value('endDate', isset($post) ? $post->endDate : ''); ?>" placeholder="Type End Date here..." />
			<?php if (form_error('endDate')) echo '<span class="help-inline">'. form_error('endDate') .'</span>'; ?>
		</div>
	</div>
<!--Study Mode-->
	<div class="control-group <?php if (form_error('studyMode')) echo 'error'; ?>">
		<label for="studyMode">Study Mode</label>
		<div class="controls">
			<select name="studyMode" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right Study Mode...</option>
			<?php $studyModes =config_item('miscellaneous.studyMode');
                foreach($studyModes  as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('studyMode')) echo '<span class="help-inline">'. form_error('studyMode') .'</span>'; ?>
		</div>
	</div>
<!--Status-->
	<div class="control-group <?php if (form_error('status')) echo 'error'; ?>">
		<label for="status">Status</label>
		<div class="controls">
			<select name="status" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right Status...</option>
			<?php $status=config_item('miscellaneous.status');
                foreach($status as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('status')) echo '<span class="help-inline">'. form_error('status') .'</span>'; ?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="submit" class="btn btn-primary" value="Save" />
		or <a href="<?php echo site_url(SITE_AREA .'/settings/academic') ?>">Cancel</a>
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