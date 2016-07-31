<div class="admin-box">
    <h3>Edit Student Details</h3>
    <?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
    <fieldset>
    <!--Matric No.-->
        <div class="control-group <?php echo iif( form_error('matricNo') , 'error') ;?>">
            <label class="control-label" for="matricNo"><?php echo 'Matric No'; ?></label>
            <div class="controls">
                <input class="input-xxlarge" type="text" id="matricNo" name="matricNo" placeholder="Please enter your Matric Number" value="<?php echo set_value('matricNo', isset($post) ? $post->matricNo : '') ?>" />
            </div>
            <?php if (form_error('matricNo')) echo '<span class="help-inline">'. form_error('matricNo') .'</span>'; ?>
        </div>
    <!--Jamb Reg-->
        <div class="control-group <?php echo iif( form_error('jamb_reg') , 'error') ;?>">
            <label class="control-label" for="jamb_reg"><?php echo 'Jamb Registration No.'; ?></label>
            <div class="controls">
                <input class="input-xxlarge" type="text" id="jamb_reg" name="jamb_reg" placeholder="Please enter your Jamb Registration Number" value="<?php echo set_value('jamb_reg', isset($post) ? strtoupper($post->jamb_reg) : '') ?>" />
            </div>
            <?php if (form_error('jamb_reg')) echo '<span class="help-inline">'. form_error('jamb_reg') .'</span>'; ?>
        </div>
    <!--user id-->
        <div class="control-group <?php if (form_error('user_id')) echo 'error'; ?>">
            <label for="user_id">Full Name</label>
            <div class="controls">
                <select name="user_id" class="input-xxlarge chzn-select">
                    <option value="0" >Please select the right student...</option>
                    <?php editUser_byRole($post->user_id,7); ?>
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
                        $progs = $this->programme_model->find_all();
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
    <!--Current programme level-->
        <div class="control-group <?php if (form_error('level')) echo 'error'; ?>">
            <label for="level">Course Level</label>
            <div class="controls">
                <select name="level" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right course level...</option>
                <?php $levels=config_item('miscellaneous.level');
                    foreach($levels as $key=>$name){
                        if ($key == $post->level){
                            $selected = " selected=selected ";
                        } else {
                            $selected = "";
                        }
                        echo "<option $selected value=" . $key. ">" . $name . "</option>";
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
                            if ($key == $post->studyMode){
                                $selected = " selected=selected ";
                            } else {
                                $selected = "";
                            }
                            echo "<option $selected value=" . $key. ">" . $name . "</option>";
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
                            if ($key == $post->entryMode){
                                $selected = " selected=selected ";
                            } else {
                                $selected = "";
                            }
                            echo "<option $selected value=" . $key. ">" . $name . "</option>";
                        }?>
                </select>
                <?php if (form_error('entryMode')) echo '<span class="help-inline">'. form_error('entryMode') .'</span>'; ?>
            </div>
        </div>
    <!--Student Status-->
        <div class="control-group <?php if (form_error('status')) echo 'error'; ?>">
            <label for="status">Status</label>
            <div class="controls">
                <select name="status" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right Status...</option>
                <?php $student_statuses=config_item('miscellaneous.student_status');
                    foreach($student_statuses as $key=>$name){
                        if ($key == $post->status){
                            $selected = " selected=selected ";
                        } else {
                            $selected = "";
                        }
                        echo "<option $selected value=" . $key. ">" . $name . "</option>";
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