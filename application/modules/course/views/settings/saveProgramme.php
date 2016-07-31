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
    <!--Degree id for degree name-->
    	<div class="control-group <?php if (form_error('deg_id')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_degree') . lang('bf_form_label_required'), 'deg_id', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<select name="deg_id" class="input-xxlarge chzn-select">
                    <option value="0" >Please select Degree type...</option>
                    <?php selectOption($listDegree, $post->deg_id); ?>
                </select>
                <?php if (form_error('deg_id')) echo '<span class="help-inline">'. form_error('deg_id') .'</span>'; ?>
    		</div>
    	</div>
    <!--Course id for course name-->
    	<div class="control-group <?php if (form_error('course_id')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_course') . lang('bf_form_label_required'), 'course_id', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<select name="course_id" class="input-xxlarge chzn-select">
                    <option value="0" >Please select Course...</option>
                    <?php selectOption($listCourseBank, $post->course_id); ?>
                </select>
                <?php if (form_error('course_id')) echo '<span class="help-inline">'. form_error('course_id') .'</span>'; ?>
    		</div>
    	</div>
    <!--Study type-->
    	<div class="control-group <?php if (form_error('studyTypeID')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_studyMode') . lang('bf_form_label_required'), 'studyTypeID', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<select name="studyTypeID" class="input-xxlarge chzn-select">
                    <option value="0" >Please select Study type...</option>
                    <?php selectOption($studyModes, $post->studyTypeID); ?>
                </select>
                <?php if (form_error('studyTypeID')) echo '<span class="help-inline">'. form_error('studyTypeID') .'</span>'; ?>
    		</div>
    	</div>
    <!--Programme Code-->
    	<div class="control-group <?php if (form_error('programmeCode')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_program_code') . lang('bf_form_label_required'), 'programmeCode', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<input type="text" name="programmeCode" class="input-xxlarge" placeholder="Type the Programme code here..."
                    value="<?php echo set_value('programmeCode', isset($post) ? $post->programmeCode : ''); ?>" />
    			<?php if (form_error('programmeCode')) echo '<span class="help-inline">'. form_error('programmeCode') .'</span>'; ?>
    		</div>
    	</div>
    <!--Description-->
    	<div class="control-group <?php if (form_error('description')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_description'), 'description', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<?php if (form_error('decription')) echo '<span class="help-inline">'. form_error('description') .'</span>'; ?>
    			<textarea name="description" class="input-xxlarge" placeholder="Describe the programme here...?">
                    <?php echo set_value('description', isset($post) ? $post->description : '') ?>
                </textarea>
    		</div>
    	</div>
    <!--duration-->
    	<div class="control-group <?php if (form_error('progDuration')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_duration') . lang('bf_form_label_required'), 'progDuration', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<select name="progDuration" class="input-xxlarge chzn-select">
    			<option value="0" >Please select programme duration...</option>
                <?php selectOption($durations, $post->progDuration); ?>
                </select>
    			<?php if (form_error('progDuration')) echo '<span class="help-inline">'. form_error('progDuration') .'</span>'; ?>
    		</div>
    	</div>
    <!--start level-->
    	<div class="control-group <?php if (form_error('startLevel')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_startLevel') . lang('bf_form_label_required'), 'startLevel', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<select name="startLevel" class="input-xxlarge chzn-select">
                    <option value="0" >Please select start level</option>
                    <?php selectOption($levels, $post->startLevel); ?>
                </select>
                <?php if (form_error('startLevel')) echo '<span class="help-inline">'. form_error('startLevel') .'</span>'; ?>
    		</div>
    	</div>
    <!--end level-->
    	<div class="control-group <?php if (form_error('endLevel')) echo 'error'; ?>">
    		<?php echo form_label(lang('pras_field_endLevel') . lang('bf_form_label_required'), 'endLevel', array('class' => 'control-label')); ?>
    		<div class="controls">
    			<select name="endLevel" class="input-xxlarge chzn-select">
                    <option value="0" >Please select the end level...</option>
                    <?php selectOption($levels, $post->endLevel); ?>
                </select>
                <?php if (form_error('endLevel')) echo '<span class="help-inline">'. form_error('endLevel') .'</span>'; ?>
    		</div>
    	</div>
    <!--Status-->
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
            <a href="<?php echo site_url(SITE_AREA .'/settings/course') ?>" class="btn btn-warning">Cancel</a>
            <?php if ($this->auth->has_permission('Course.Settings.Delete') && $id > 0) : ?>
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
