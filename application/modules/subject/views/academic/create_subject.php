<div class="admin-box">
	<h3>Create New Subject</h3>
	<?= form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--subject Code-->
	<div class="control-group <?php if (form_error('subjectCode')) echo 'error'; ?>">
		<label for="subjectCode">Course Code</label>
		<div class="controls">
			<input type="text" name="subjectCode" class="input-xxlarge" value="<?= set_value('subjectCode', isset($post) ? $post->subjectCode : ''); ?>" placeholder="Type Course Code here..." />
			<?php if (form_error('subjectCode')) echo '<span class="help-inline">'. form_error('subjectCode') .'</span>'; ?>
		</div>
	</div>
<!--subject Title-->
	<div class="control-group <?php if (form_error('subjectTitle')) echo 'error'; ?>">
		<label for="subjectTitle">Course Title</label>
		<div class="controls">
			<input type="text" name="subjectTitle" class="input-xxlarge" value="<?= set_value('subjectTitle', isset($post) ? $post->subjectTitle : ''); ?>" placeholder="Type Course Title here..." />
			<?php if (form_error('subjectTitle')) echo '<span class="help-inline">'. form_error('subjectTitle') .'</span>'; ?>
		</div>
	</div>
<!--Course Allocated Unit-->
	<div class="control-group <?php if (form_error('subjectUnit')) echo 'error'; ?>">
		<label for="subjectUnit">Course Unit</label>
		<div class="controls">
			<select name="subjectUnit" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right course unit...</option>
			<?php $unit=config_item('miscellaneous.unit');
                foreach($unit as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('subjectUnit')) echo '<span class="help-inline">'. form_error('subjectUnit') .'</span>'; ?>
		</div>
	</div>
<!--Course progUserId-->
	<div class="control-group <?php if (form_error('instructor')) echo 'error'; ?>">
		<label for="instructor">Course Instructor</label>
		<div class="controls">
            <select name="instructor" class="input-xxlarge chzn-select">
                <option value="0" >Please select the course instructor...</option>
                <?php listUsers_byRole(4); ?>
            </select>
			<?php if (form_error('instructor')) echo '<span class="help-inline">'. form_error('instructor') .'</span>'; ?>
		</div>
	</div>
<!--Description-->
	<div class="control-group <?php if (form_error('description')) echo 'error'; ?>">
		<label for="description">Description</label>
		<div class="controls">
			<?php if (form_error('decription')) echo '<span class="help-inline">'. form_error('description') .'</span>'; ?>
			<textarea name="description" class="input-xxlarge" rows="7" placeholder="Describe the Course Title here...?"><?php echo set_value('description', isset($post) ? $post->description : '') ?></textarea>
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
		or <a href="<?= site_url(SITE_AREA .'/academic/subject') ?>">Cancel</a>
	</div>
</fieldset>
	<?= form_close(); ?>
</div>
<?php
    $inline = <<<EOL
    $(".chzn-select").chosen();
EOL;
    Assets::add_js( $inline, 'inline' );
    unset ( $inline );
?>
