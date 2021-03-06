<div class="admin-box">
	<h3>Create New Degree</h3>
	<?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
	<fieldset>

	<div class="control-group <?php if (form_error('degreeName')) echo 'error'; ?>">
		<label for="degreeName">Degree Name</label>
		<div class="controls">
			<input type="text" name="degreeName" class="input-xxlarge" value="<?php echo set_value('degreeName', isset($post) ? $post->degreeName : ''); ?>" placeholder="Type Degree name..." />
			<?php if (form_error('degreeName')) echo '<span class="help-inline">'. form_error('degreeName') .'</span>'; ?>
		</div>
	</div>

	<div class="control-group <?php if (form_error('degreeAbbreviation')) echo 'error'; ?>">
		<label for="degreeAbbreviation">Abbreviation</label>
		<div class="controls">
			<input type="text" name="degreeAbbreviation" class="input-xxlarge" value="<?php echo set_value('degreeAbbreviation', isset($post) ? $post->degreeAbbreviation : ''); ?>" placeholder="Type Degree Abbreviation..." />
			<?php if (form_error('degreeAbbreviation')) echo '<span class="help-inline">'. form_error('degreeAbbreviation') .'</span>'; ?>
		</div>
	</div>

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
		or <a href="<?php echo site_url(SITE_AREA .'/academic/course/degree') ?>">Cancel</a>
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
