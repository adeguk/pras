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

	$id = isset($post->sem_session_id) ? $post->sem_session_id : '';
?>
<div class="admin-box">
	<h3>Create New <?php echo lang('pras_field_semester'); ?></h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--Session semester-->
	<div class="control-group <?php if (form_error('session_semester')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_semester') . lang('bf_form_label_required'), 'session_semester', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="session_semester" class="input-xxlarge chzn-select">
				<option value="0" >Please select the right course semester...</option>
				<?php foreach($semesters as $key=>$name){
                    if ($key == $post->session_semester){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=$key>$name</option>";
                }?>
            </select>
			<?php if (form_error('session_semester')) echo '<span class="help-inline">'. form_error('session_semester') .'</span>'; ?>
		</div>
	</div>
<!--Academic semester-->
	<div class="control-group <?php if (form_error('aca_session_id')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_session') . lang('bf_form_label_required'), 'aca_session_id', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="aca_session_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the programme here...</option>
                <?php
                    $aca_sessions = $this->AcademicSession_Model->select('aca_Session_id, session, studyMode')->find_all();
                    foreach($aca_sessions as $as){
                        $key = $as->aca_Session_id;
                        if ($key == $post->aca_session_id){
                            $selected = " selected=selected ";
                        } else {
                            $selected = "";
                        }
                        echo "<option $selected value=$key>";
						e($sessions[$as->session] .' - '. $studyModes[$as->studyMode]);
						echo "</option>";
                } ?>
            </select>
            <?php if (form_error('aca_session_id')) echo '<span class="help-inline">'. form_error('aca_session_id') .'</span>'; ?>
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
<!--is Current-->
	<div class="control-group <?php if (form_error('isCurrent')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_isCurrent'), 'isCurrent', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="isCurrent" class="input-xxlarge chzn-select">
				<option value="0" >Please select the right Status...</option>
				<?php foreach($status as $key=>$name){
                    if ($key == $post->isCurrent){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=$key>$name</option>";
                }?>
            </select>
			<?php if (form_error('isCurrent')) echo '<span class="help-inline">'. form_error('isCurrent') .'</span>'; ?>
		</div>
	</div>
<!--is Registration-->
	<div class="control-group <?php if (form_error('isRegistration')) echo 'error'; ?>">
		<?php echo form_label(lang('pras_field_isRegistration'), 'isRegistration', array('class' => 'control-label')); ?>
		<div class="controls">
			<select name="isRegistration" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right Status...</option>
			<?php $isRegistration = config_item('miscellaneous.status');
                foreach($isRegistration as $key=>$name){
                    if ($key == $post->isRegistration){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=$key>$name</option>";
                }?>
            </select>
			<?php if (form_error('isRegistration')) echo '<span class="help-inline">'. form_error('isRegistration') .'</span>'; ?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="save" class="btn btn-primary" value="Save" />
		<a href="<?php echo site_url(SITE_AREA .'/settings/academics/semesterSession') ?>" class="btn btn-warning">Cancel</a>
		<?php if ($this->auth->has_permission('Academics.Settings.Delete') && $id > 0) : ?>
			<?php #echo lang('bf_or'); ?>
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
