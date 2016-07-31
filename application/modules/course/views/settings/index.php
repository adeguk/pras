<?php
   $num_columns	= 7;
   $can_delete	= $this->auth->has_permission('Course.Settings.Delete');
   $can_edit	= $this->auth->has_permission('Course.Settings.Edit');
   $has_records	= isset($records) && is_array($records) && count($records);

   $areaUrl = SITE_AREA . '/settings/course/';
   $edit_icon = '<i class="fa fa-edit fa-fw"></i>&nbsp';

   if ($can_delete) $num_columns++;
?>

<div class="admin-box">
    <h3>List of <?php echo lang('pras_field_program'); ?></h3>

    <?php echo form_open(current_url()); ?>
    <table class="table table-striped table-hover table-bordered" style="margin-top: 7px; margin-bottom: 10px;">
        <tbody>
            <tr>
                <th>
                    <div class="control" style="float:right">
                        <a class="btn btn-success" href="<?php echo site_url($areaUrl.'/downloadProgramme') ?>">download</a>
                    </div>
                    <div class="control" style="float:right;  margin-right: 5px;">
                        <input type="search" name="search_term" style='margin-bottom: 0;'
                        value="<?php echo set_value('search', isset($post) ? $post->search_term : ''); ?>"
                        placeholder="search available Program ..." title='or Search by department' />
                        <input type="submit" name="submit" class="btn" value="Search" />
                    </div>
                </th>
                <th colspan='1'><?php echo "<div class='control' style='text-align:center;font-size:20px;margin-top:7px'>
                Total Count &rarr; $total_rows </div>"; ?></th>
            </tr>
        </tbody>
    </table>
    <?= form_close()?>

    <?php echo form_open(current_url()); ?>
    <table class="table table-striped table-hover table-bordered">
        <thead>
			<tr>
                <?php if ($can_delete) : ?>
                <th class='column-check'><input class='check-all' type='checkbox' /></th>
                <?php endif;?>
				<th><?= lang('pras_field_program'); ?></th>
				<th><?= lang('pras_field_department'); ?></th>
				<th><?= lang('pras_field_description'); ?></th>
				<th><?= lang('pras_field_studyMode'); ?></th>
				<th><?= lang('pras_field_startLevel'); ?></th>
				<th><?= lang('pras_field_endLevel'); ?></th>
				<th><?= lang('pras_field_status'); ?></th>
			</tr>
		</thead>
        <?php if ($has_records) : ?>
        <tfoot>
            <?php if ($can_delete) : ?>
			<tr>
				<td colspan='<?php echo $num_columns; ?>'>
                <?= lang('bf_with_selected') ?>
                <input type='submit' name='delete' id='delete-me' class='btn btn-danger'
                    value="<?php echo lang('bf_action_delete'); ?>"
                    onclick="return confirm('<?php e(js_escape(lang('pras_delete_confirm'))); ?>')" />
                </td>
			</tr>
            <?php endif; ?>
		</tfoot>
        <?php endif; ?>
		<tbody>
        <?php if ($has_records) :
            foreach ($records as $record) :
                if ($record->deleted == 1) {
                    echo '<tr class="deleted">' ;
                } else {
                    echo '<tr>';
                }
                if ($can_delete) : ?>
			    <td><input type="checkbox" name="checked[]" value="<?php echo $record->id ?>" /></td>
                <?php endif;

                if (($can_edit) && ($record->deleted == 1)) : ?>
                <td>
                    <?php echo anchor($areaUrl . 'editProgramme/' . $record->id, $edit_icon.$record->program." <strong>($record->programmeCode)</strong>"); ?>
                </td>
                <?php elseif ($can_edit) : ?>
                <td>
                    <?php echo anchor($areaUrl . 'editProgramme/' . $record->id, $edit_icon.$record->program." <strong>($record->programmeCode)</strong>"); ?>
                </td>
                <?php else : ?>
                <td><?php e($record->program." <strong>($record->programmeCode)</strong>"); ?></td>
                <?php endif; ?>

				<td><?php e($record->department.", Faculty of $record->faculty"); ?></td>

				<td><?php if (isset($record->description)) {
                    $shortDescription = limit_words($record->description, 25);
                    echo $shortDescription;
                } else echo 'Create new description for this item!'  ?>
                </td>
				<td><?php e($studyModes[$record->studyTypeID]); ?>
				<td><?php e($levels[$record->startLevel]); ?></td>
				<td><?php e($levels[$record->endlevel]); ?></td>
				</td>
				<td>
					<span class=" <?= statusSwitchCase($record->status, $record->deleted); ?>">
					<?= $status[$record->status]; ?>
					</span>
				</td>
			</tr>
            <?php
                endforeach;
            else:
            ?>
            <tr>
                <td colspan='<?php echo $num_columns; ?>'>
              <div class="alert alert-warning">
                 <?php echo lang('pras_records_empty'); ?>
              <div>
           </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php
    echo form_close();
    echo $this->pagination->create_links();
?>
</div>
