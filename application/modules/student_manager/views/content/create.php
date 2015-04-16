<div class="admin-box">
	<h3>Add New Student Details</h3>
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
	<!--Matric No.-->
		<div class="control-group <?php if (form_error('matricNo')) echo 'error'; ?>">
			<label class="control-label" for="matricNo"><?php echo 'Matric No'; ?></label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="matricNo" name="matricNo" placeholder="Please enter your Jamb Reg if your do not have Matric No." value="<?php echo set_value('matricNo', isset($post) ? $post->matricNo : '') ?>" />
            <?php if (form_error('matricNo')) echo '<span class="help-inline">'. form_error('matricNo') .'</span>'; ?>
			</div>
		</div>
	<!--Jamb Reg-->
		<div class="control-group <?php if (form_error('jamb_reg')) echo 'error'; ?>">
			<label class="control-label" for="jamb_reg"><?php echo 'Jamb Registration No.'; ?></label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="jamb_reg" name="jamb_reg" placeholder="Please enter your Jamb Registration Number" value="<?php echo set_value('jamb_reg', isset($post) ? $post->jamb_reg : '') ?>" />
            <?php if (form_error('jamb_reg')) echo '<span class="help-inline">'. form_error('jamb_reg') .'</span>'; ?>
			</div>
		</div>
	<!--user id-->
		<div class="control-group <?php if (form_error('user_id')) echo 'error'; ?>">
			<label for="user_id"><?php echo lang('user_fullname'); ?></label>
			<div class="controls">
	            <select name="user_id" class="input-xxlarge chzn-select">
	                <option value="0" >Please select the right student...</option>
	                <?php listUsers_byRole(7); ?>
	            </select>
			</div>
		</div>
	<!--Programme-->
		<div class="control-group <?php if (form_error('prog_id')) echo 'error'; ?>">
			<label for="prog_id">Programme Study</label>
			<div class="controls">
				<select name="prog_id" class="input-xxlarge chzn-select">
	                <option value="0" >Please select the programme here...</option>
	                <?php
	                    $progs = $this->programme_model->find_all_by('programme.deleted', 0);
	                    foreach($progs as $prog){
	                        $dur = $prog->progDuration;
	                        echo "<option value=" .$prog->prog_id. ">";
	                        get_fieldByID('degree_model', $prog->deg_id, 'degreeAbbreviation');
	                        echo ' ';
	                        get_fieldByID('coursebank_model', $prog->course_id, 'courseName');
	                        $durations=config_item('miscellaneous.duration');
	                        e(' - '.$durations[$dur]);
	                        echo "</option>";
	                } ?>
	            </select>
	            <?php if (form_error('prog_id')) echo '<span class="help-inline">'. form_error('prog_id') .'</span>'; ?>
			</div>
		</div>
	<!--Current programme level-->
		<div class="control-group <?php if (form_error('level')) echo 'error'; ?>">
			<label for="level">Course Level</label>
			<div class="controls">
				<select name="level" class="input-xxlarge chzn-select">
				<option value="0" >Please select the right course level...</option>
				<?php $levels=config_item('miscellaneous.level');
	                foreach($levels as $key=>$name){
	                    echo "<option value=" . $key. ">" . $name . "</option>";
	                }?>
	            </select>
				<?php if (form_error('level')) echo '<span class="help-inline">'. form_error('level') .'</span>'; ?>
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
	<!--Entry mode-->
		<div class="control-group <?php if (form_error('entryMode')) echo 'error'; ?>">
			<label for="entryMode">Entry Mode</label>
			<div class="controls">
				<select name="entryMode" class="input-xxlarge chzn-select">
	                <option value="0" >Please select the right Entry Mode...</option>
	                <?php $entryModes=config_item('miscellaneous.entryMode');
	                foreach($entryModes as $key=>$name){
	                    echo "<option value=" . $key. ">" . $name . "</option>";
	                }?>
	            </select>
	            <?php if (form_error('entryMode')) echo '<span class="help-inline">'. form_error('entryMode') .'</span>'; ?>
			</div>
		</div>
	<!--Status-->
		<div class="control-group <?php if (form_error('status')) echo 'error'; ?>">
			<label for="status">Status</label>
			<div class="controls">
				<select name="status" class="input-xxlarge chzn-select">
	                <option value="0" >Please select the right status...</option>
	                <?php $status=config_item('miscellaneous.student_status');
	                foreach($status as $key=>$name){
	                    echo "<option value=" . $key. ">" . $name . "</option>";
	                }?>
	            </select>
	            <?php if (form_error('status')) echo '<span class="help-inline">'. form_error('status') .'</span>'; ?>
			</div>
		</div>

		<div class="form-actions">
			<input type="submit" name="submit" class="btn btn-primary" value="Save" />
			or <a href="<?php echo site_url(SITE_AREA .'/content/student_manager') ?>">Cancel</a>
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