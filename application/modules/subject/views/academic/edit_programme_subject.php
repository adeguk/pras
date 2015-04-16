<div class="admin-box">
	<h3>Edit Programme Subject</h3>

	<?= form_open(current_url(), 'class="form-horizontal"'); ?>
    <fieldset>
<!--Programme-->
	<div class="control-group <?php if (form_error('prog_id')) echo 'error'; ?>">
		<label for="prog_id">Programme</label>
		<div class="controls">
			<select name="prog_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the programme here...</option>
                <?php
                    $progs = $this->programmeView_model->find_all();
                    foreach($progs as $p){
                        $key = $p->prog_id;
                        if ($key == $post->prog_id){
                            $selected = " selected=selected ";
                        } else {
                            $selected = "";
                        }
                        echo "<option $selected value=" .$key. ">".$p->programme.' - '.config_item('miscellaneous.duration')[$p->duration]."</option>";
                } ?>
            </select>
            <?php if (form_error('prog_id')) echo '<span class="help-inline">'. form_error('prog_id') .'</span>'; ?>
		</div>
	</div>
<!--subject Title-->
	<div class="control-group <?php if (form_error('subject_id')) echo 'error'; ?>">
		<label for="subject_id">Course Title</label>
		<div class="controls">
			<select name="subject_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Course here...</option>
                <?php
                    $subjs = $this->programmeSubjectView_model->find_all();
                    foreach($subjs as $s){
                        $key = $s->subject_id;
                        if ($key == $post->subject_id){
                            $selected = " selected=selected ";
                        } else {
                            $selected = "";
                        }
                        echo "<option $selected value=" .$key. ">".$s->courseTitle."</option>";
                    }
                ?>
            </select>
            <?php if (form_error('subject_id')) echo '<span class="help-inline">'. form_error('subject_id') .'</span>'; ?>
		</div>
	</div>
<!--Course programme level-->
	<div class="control-group <?php if (form_error('prog_level')) echo 'error'; ?>">
		<label for="prog_level">Course Level</label>
		<div class="controls">
			<select name="prog_level" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right course level...</option>
			<?php $levels=config_item('miscellaneous.level');
                foreach($levels as $key=>$name){
                    if ($key == $post->prog_level){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('prog_level')) echo '<span class="help-inline">'. form_error('prog_level') .'</span>'; ?>
		</div>
	</div>
<!--Course programme semester-->
	<div class="control-group <?php if (form_error('prog_semester')) echo 'error'; ?>">
		<label for="prog_semester">Course Semester</label>
		<div class="controls">
			<select name="prog_semester" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right course semester...</option>
			<?php $semesters=config_item('miscellaneous.semester');
                foreach($semesters as $key=>$name){
                    if ($key == $post->prog_semester){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('prog_semester')) echo '<span class="help-inline">'. form_error('prog_semester') .'</span>'; ?>
		</div>
	</div>
<!--Course choice-->
	<div class="control-group <?php if (form_error('compulsory')) echo 'error'; ?>">
		<label for="compulsory">Course Choice</label>
		<div class="controls">
			<select name="compulsory" class="input-xxlarge chzn-select">
			<option value="0" >Please select the right course choice...</option>
			<?php $choices=config_item('miscellaneous.choice');
                foreach($choices as $key=>$name){
                    if ($key == $post->compulsory){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }?>
            </select>
			<?php if (form_error('compulsory')) echo '<span class="help-inline">'. form_error('compulsory') .'</span>'; ?>
		</div>
	</div>
<!--Course progUserId-->
	<div class="control-group <?php if (form_error('progUserId')) echo 'error'; ?>">
		<label for="progUserId">Course Adviser</label>
		<div class="controls">
            <select name="progUserId" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Head of Department...</option>
                <?php editUser_byRole($post->progUserId, 4); ?>
            </select>
			<?php if (form_error('progUserId')) echo '<span class="help-inline">'. form_error('progUserId') .'</span>'; ?>
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
		or <a href="<?= site_url(SITE_AREA .'/academic/subject/programme_subject') ?>">Cancel</a>
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