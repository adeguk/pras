<div class="admin-box">
	<h3>Create New Study Programme</h3>
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--degree type-->
	<div class="control-group <?php if (form_error('deg_id')) echo 'error'; ?>">
		<label for="deg_id">Degree Type</label>
		<div class="controls">
			<select name="deg_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right Degree type...</option>
                <?php foreach($listDegree as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                } ?>
            </select>
            <?php if (form_error('deg_id')) echo '<span class="help-inline">'. form_error('deg_id') .'</span>'; ?>
		</div>
	</div>
<!--Course id for course name-->
	<div class="control-group <?php if (form_error('course_id')) echo 'error'; ?>">
		<label for="course_id">Course Name</label>
		<div class="controls">
			<select name="course_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Course here...</option>
                <?php foreach($listCourseBank as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                } ?>
            </select>
            <?php if (form_error('course_id')) echo '<span class="help-inline">'. form_error('course_id') .'</span>'; ?>
		</div>
	</div>
<!--Study type-->
	<div class="control-group <?php if (form_error('studyMode')) echo 'error'; ?>">
		<label for="studyMode">Study Mode</label>
		<div class="controls">
			<select name="studyMode" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right Study Mode...</option>
                <?php $studyModes=config_item('miscellaneous.studyMode');
                foreach($studyModes as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
            <?php if (form_error('studyMode')) echo '<span class="help-inline">'. form_error('studyMode') .'</span>'; ?>
		</div>
	</div>
<!--Programme Code-->
	<div class="control-group <?php if (form_error('progCode')) echo 'error'; ?>">
		<label for="progCode">Programme Code</label>
		<div class="controls">
			<input type="text" name="progCode" class="input-xxlarge" value="<?php echo set_value('progCode', isset($post) ? $post->progCode : ''); ?>" placeholder="Type the Programme code here..." />
			<?php if (form_error('progCode')) echo '<span class="help-inline">'. form_error('progCode') .'</span>'; ?>
		</div>
	</div>
<!--Description-->
	<div class="control-group <?php if (form_error('description')) echo 'error'; ?>">
		<label for="description">Description</label>
		<div class="controls">
			<?php if (form_error('decription')) echo '<span class="help-inline">'. form_error('description') .'</span>'; ?>
			<textarea name="description" class="input-xxlarge" rows="7" placeholder="Describe the faculty here...?"><?php echo set_value('description', isset($post) ? $post->description : '') ?></textarea>
		</div>
	</div>
<!--duration-->
	<div class="control-group <?php if (form_error('progDuration')) echo 'error'; ?>">
		<label for="progDuration">Programme Duration</label>
		<div class="controls">
			<select name="progDuration" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right programme duration...</option>
			<?php $duration=config_item('miscellaneous.duration');
                foreach($duration as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('progDuration')) echo '<span class="help-inline">'. form_error('progDuration') .'</span>'; ?>
		</div>
	</div>
<!--start level-->
	<div class="control-group <?php if (form_error('progStart_level')) echo 'error'; ?>">
		<label for="progStart_level">Programme Start Level</label>
		<div class="controls">
			<select name="progStart_level" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right start level</option>
                <?php $levels=config_item('miscellaneous.level');
                foreach($levels as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
            <?php if (form_error('progStart_level')) echo '<span class="help-inline">'. form_error('progStart_level') .'</span>'; ?>
		</div>
	</div>
<!--end level-->
	<div class="control-group <?php if (form_error('progEnd_level')) echo 'error'; ?>">
		<label for="progEnd_level">Programme End Level</label>
		<div class="controls">
			<select name="progEnd_level" class="input-xxlarge chzn-select">
                <option value="0" >Please select the end level...</option>
                <?php $levels=config_item('miscellaneous.level');
                foreach($levels as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
            <?php if (form_error('progEnd_level')) echo '<span class="help-inline">'. form_error('progEnd_level') .'</span>'; ?>
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
		or <a href="<?php echo site_url(SITE_AREA .'/academic/course/programme') ?>">Cancel</a>
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
