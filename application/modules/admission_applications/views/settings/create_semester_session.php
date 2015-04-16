<div class="admin-box">
<h3>Create New Semester Session</h3>
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--Course programme semester-->
	<div class="control-group <?php if (form_error('session_semester')) echo 'error'; ?>">
		<label for="session_semester">Session Semester</label>
		<div class="controls">
			<select name="session_semester" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right semester...</option>
			<?php $semesters = config_item('miscellaneous.semester');
                foreach($semesters as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('session_semester')) echo '<span class="help-inline">'. form_error('session_semester') .'</span>'; ?>
		</div>
	</div>
<!--Academic semester-->
	<div class="control-group <?php if (form_error('aca_session_id')) echo 'error'; ?>">
		<label for="aca_session_id">Academic Session</label>
		<div class="controls">
            <select name="aca_session_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Academic Session...</option>                
                <?php
                    $aca_sessions = $this->academic_session_model->select('aca_session_id, session, studyMode')->find_all_by('deleted', 0);
                    foreach($aca_sessions as $as){
                        echo "<option value=" .$as->aca_session_id. ">";
                        $sessions = config_item('miscellaneous.session');
                        e($sessions[$as->session]);
                        $studyModes=config_item('miscellaneous.studyMode');
                        e(' - '.$studyModes[$as->studyMode]);
                        echo "</option>";
                } ?>
            </select>
            <?php if (form_error('aca_session_id')) echo '<span class="help-inline">'. form_error('aca_session_id') .'</span>'; ?>
		</div>
	</div>
<!--Start Date-->
	<div class="control-group <?php if (form_error('startDate')) echo 'error'; ?>">
		<label for="startDate">Start Date</label>
		<div class="controls">
			<input type="text" name="startDate" class="input-xxlarge datepicker"  value="<?php echo set_value('startDate', isset($post) ? $post->startDate : ''); ?>" placeholder="Type Start Date here..." />
			<?php if (form_error('startDate')) echo '<span class="help-inline">'. form_error('startDate') .'</span>'; ?>
		</div>
	</div>
<!--End Date-->
	<div class="control-group <?php if (form_error('endDate')) echo 'error'; ?>">
		<label for="endDate">End Date</label>
		<div class="controls">
			<input type="text" name="endDate" class="input-xxlarge datepicker"  value="<?php echo set_value('endDate', isset($post) ? $post->endDate : ''); ?>" placeholder="Type End Date here..." />
			<?php if (form_error('endDate')) echo '<span class="help-inline">'. form_error('endDate') .'</span>'; ?>
		</div>
	</div>
<!--is Current-->
	<div class="control-group <?php if (form_error('isCurrent')) echo 'error'; ?>">
		<label for="isCurrent">Is Current?</label>
		<div class="controls">
			<select name="isCurrent" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right Status...</option>
			<?php $isCurrent = config_item('miscellaneous.status');
                foreach($isCurrent as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('isCurrent')) echo '<span class="help-inline">'. form_error('isCurrent') .'</span>'; ?>
		</div>
	</div>
<!--is Registration-->
	<div class="control-group <?php if (form_error('isRegistration')) echo 'error'; ?>">
		<label for="isRegistration">Is Registration?</label>
		<div class="controls">
			<select name="isRegistration" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right Status...</option>
			<?php $isRegistration = config_item('miscellaneous.status');
                foreach($isRegistration as $key=>$name){
                    echo "<option value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('isRegistration')) echo '<span class="help-inline">'. form_error('isRegistration') .'</span>'; ?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="submit" class="btn btn-primary" value="Save" />
		or <a href="<?php echo site_url(SITE_AREA .'/settings/academic/semester_session') ?>">Cancel</a>
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