<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('forum_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($forum->id) ? $forum->id : '';

?>
<div class='admin-box'>
    <h3>Forum</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('field1') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forum_field_field1') . lang('bf_form_label_required'), 'field1', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='field1' type='text' required='required' name='field1' maxlength='150' value="<?php echo set_value('field1', isset($forum->field1) ? $forum->field1 : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('field1'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('field2') ? ' error' : ''; ?>">
                <div class='controls'>
                    <label class='checkbox' for='field2'>
                        <input type='checkbox' id='field2' name='field2' required='required'  value='1' <?php echo set_checkbox('field2', 1, isset($forum->field2) && $forum->field2 == 1); ?> />
                        <?php echo lang('forum_field_field2') . lang('bf_form_label_required'); ?>
                    </label>
                    <span class='help-inline'><?php echo form_error('field2'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('field3') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forum_field_field3'), '', array('class' => 'control-label', 'id' => 'field3_label')); ?>
                <div class='controls' aria-labelled-by='field3_label'>
                    <label class='radio' for='field3_option1'>
                        <input id='field3_option1' name='field3' type='radio' value='option1' <?php echo set_radio('field3', 'option1', isset($forum->field3) && $forum->field3 == 'option1'); ?> />
                        Radio option 1
                    </label>
                    <label class='radio' for='field3_option2'>
                        <input id='field3_option2' name='field3' type='radio' value='option2' <?php echo set_radio('field3', 'option2', isset($forum->field3) && $forum->field3 == 'option2'); ?> />
                        Radio option 2
                    </label>
                    <span class='help-inline'><?php echo form_error('field3'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    10 => 10,
                );
                echo form_dropdown(array('name' => 'field4'), $options, set_value('field4', isset($forum->field4) ? $forum->field4 : ''), lang('forum_field_field4'));
            ?>

            <div class="control-group<?php echo form_error('field5') ? ' error' : ''; ?>">
                <?php echo form_label(lang('forum_field_field5'), 'field5', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='field5' type='text' name='field5' maxlength='255' value="<?php echo set_value('field5', isset($forum->field5) ? $forum->field5 : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('field5'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('forum_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/academic/forum', lang('forum_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Forum.Academic.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('forum_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('forum_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>