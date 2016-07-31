<div class="admin-box">
	<h3>Add New Course to Course Bank</h3>
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
	
	<div class="control-group <?php if (form_error('courseName')) echo 'error'; ?>">
		<label for="courseName">Course Name</label>
		<div class="controls">
			<input type="text" name="courseName" class="input-xxlarge" value="<?php echo set_value('courseName', isset($post) ? $post->courseName : ''); ?>" placeholder="Type Course name..." />
			<?php if (form_error('courseName')) echo '<span class="help-inline">'. form_error('courseName') .'</span>'; ?>
		</div>
	</div>

	<div class="control-group <?php if (form_error('dept_id')) echo 'error'; ?>">
		<label for="dept_id">Department Name</label>
		<div class="controls">
			<select name="dept_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right Department...</option>
                <?php foreach($listDepartment as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                } ?>
            </select>
            <?php if (form_error('dept_id')) echo '<span class="help-inline">'. form_error('dept_id') .'</span>'; ?>
		</div>
	</div>

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
		or <a href="<?php echo site_url(SITE_AREA .'/academic/course') ?>">Cancel</a>
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
