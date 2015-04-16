<div class="admin-box">
	<h3>Edit Faculty Department</h3>	
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>
	<div class="control-group <?php if (form_error('dept_name')) echo 'error'; ?>">
		<label for="dept_name">Department Name</label>
		<div class="controls">
			<input type="text" name="dept_name" class="input-xxlarge" value="<?php echo set_value('dept_name', isset($post) ? $post->dept_name : ''); ?>" placeholder="Type Department name..." />
			<?php if (form_error('dept_name')) echo '<span class="help-inline">'. form_error('dept_name') .'</span>'; ?>
		</div>
	</div>

	<div class="control-group <?php if (form_error('dept_hod')) echo 'error'; ?>">
		<label for="dept_hod">Head of Department</label>
		<div class="controls">
			<select name="dept_hod" class="input-xxlarge chzn-select">
                <option value="0" >Please select the Head of Department...</option>
                <?php editUser_byRole($post->dept_hod, 4); ?>
            </select>
		</div>
	</div>

	<div class="control-group <?php if (form_error('description')) echo 'error'; ?>">
		<label for="description">Description</label>
		<div class="controls">
			<?php if (form_error('decription')) echo '<span class="help-inline">'. form_error('description') .'</span>'; ?>
			<textarea name="description" class="input-xxlarge" rows="7" placeholder="Describe the Department here...?"><?php echo set_value('description', isset($post) ? $post->description : '') ?></textarea>
		</div>
	</div>

	<div class="control-group <?php if (form_error('fac_id')) echo 'error'; ?>">
		<label for="fac_id">Faculty</label>
		<div class="controls">
            <select name="fac_id" class="input-xxlarge chzn-select">
                <option value="0" >Please select the right Faculty...</option>
                <?php foreach($listFaculty as $key=>$name){
                    if ($key==$post->fac_id){
                        $selected = " selected=selected ";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value=" . $key. ">" . $name . "</option>";
                }
                ?>
            </select>
		<?php if (form_error('fac_id')) echo '<span class="help-inline">'. form_error('fac_id') .'</span>'; ?>
       </div>
    </div>

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
		or <a href="<?php echo site_url(SITE_AREA .'/academic/faculty/department') ?>">Cancel</a>
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