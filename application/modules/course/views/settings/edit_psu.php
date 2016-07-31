<div class="admin-box">
	<h3>Edit Programme Semester Unit</h3>
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
<!--Programme-->
	<div class="control-group <?php if (form_error('prog_id')) echo 'error'; ?>">
		<label for="prog_id">Programme</label>
		<div class="controls">
			<select name="prog_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the programme here...</option>
                <?php
                    $progs = $this->programme_model->select('prog_id, programme.course_id, programme.deg_id, progDuration')->order_by('progCode', 'ASC')->find_all_by('programme.deleted', 0);
                    foreach($progs as $prog){
                        $key = $prog->prog_id;
                        $dur = $prog->progDuration;
                        if ($key == $post->prog_id){
                            $selected = " selected=selected ";
                        } else {
                            $selected = "";
                        }
                        echo "<option $selected value=" .$key. ">";
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
<!--Minimum Unit-->
	<div class="control-group <?php if (form_error('minimumUnit')) echo 'error'; ?>">
		<label for="minimumUnit">Programme Minimum Unit</label>
		<div class="controls">
			<select name="minimumUnit" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right Minimum Unit</option>
                <?php $totalUnits=config_item('miscellaneous.totalUnit');
                foreach($totalUnits as $key=>$name){
                    if ($key == $post->minimumUnit){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
            <?php if (form_error('minimumUnit')) echo '<span class="help-inline">'. form_error('minimumUnit') .'</span>'; ?>
		</div>
	</div>
<!--Maximum Unit-->
	<div class="control-group <?php if (form_error('maximumUnit')) echo 'error'; ?>">
		<label for="maximumUnit">Programme Maximum Unit</label>
		<div class="controls">
			<select name="maximumUnit" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Maximum Unit...</option>
                <?php $totalUnits=config_item('miscellaneous.totalUnit');
                foreach($totalUnits as $key=>$name){
                    if ($key == $post->maximumUnit){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
            <?php if (form_error('maximumUnit')) echo '<span class="help-inline">'. form_error('maximumUnit') .'</span>'; ?>
		</div>
	</div>
<!--Course programme level-->
	<div class="control-group <?php if (form_error('progLevel')) echo 'error'; ?>">
		<label for="progLevel">Course Level</label>
		<div class="controls">
			<select name="progLevel" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right course level...</option>
			<?php $levels=config_item('miscellaneous.level');
                foreach($levels as $key=>$name){
                    if ($key == $post->progLevel){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('progLevel')) echo '<span class="help-inline">'. form_error('progLevel') .'</span>'; ?>
		</div>
	</div>
<!--Course programme semester-->
	<div class="control-group <?php if (form_error('progSemester')) echo 'error'; ?>">
		<label for="progSemester">Course Semester</label>
		<div class="controls">
			<select name="progSemester" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right course semester...</option>
			<?php $semesters=config_item('miscellaneous.semester');
                foreach($semesters as $key=>$name){
                    if ($key == $post->progSemester){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('progSemester')) echo '<span class="help-inline">'. form_error('progSemester') .'</span>'; ?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="submit" class="btn btn-primary" value="Save" />
		or <a href="<?php echo site_url(SITE_AREA .'/settings/course') ?>">Cancel</a>
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