<?php
   $num_columns	= 5;
   $can_delete	= $this->auth->has_permission('Academics.Settings.Delete');
   $can_edit	= $this->auth->has_permission('Academics.Settings.Edit');
   $has_records	= isset($records) && is_array($records) && count($records);

   $areaUrl = SITE_AREA . '/settings/academics/';
   $edit_icon = '<i class="fa fa-edit fa-fw"></i>&nbsp';

   if ($can_delete) $num_columns++;
?>

<div class="admin-box">
    <h3>List of <?php echo lang('pras_field_session'); ?></h3>

    <?php echo form_open(current_url()); ?>
    <table class="table table-striped table-hover table-bordered">
        <thead>
			<tr>
                <?php if ($can_delete) : ?>
                <th class='column-check'><input class='check-all' type='checkbox' /></th>
                <?php endif;?>
				<th><?= lang('pras_field_session'); ?></th>
				<th><?= lang('pras_field_startDate'); ?></th>
				<th><?= lang('pras_field_endDate'); ?></th>
				<th><?= lang('pras_field_studyMode'); ?></th>
				<th style="width: 8%"><?= lang('pras_field_status'); ?></th>
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
			    <td><input type="checkbox" name="checked[]" value="<?php echo $record->aca_Session_id ?>" /></td>
                <?php endif;

                if (($can_edit) && ($record->deleted == 1)) : ?>
                <td>
                    <?php echo anchor($areaUrl . 'editAcademicSession/' . $record->aca_Session_id, $edit_icon.$sessions[$record->session]); ?>
                </td>
                <?php elseif ($can_edit) : ?>
                <td>
                    <?php echo anchor($areaUrl . 'editAcademicSession/' . $record->aca_Session_id, $edit_icon.$sessions[$record->session]); ?>
                </td>
                <?php else : ?>
                <td><?php e($sessions[$record->session]); ?></td>
                <?php endif; ?>

				<td><?php e(date('d/m/Y', strtotime($record->startDate))); ?></td>
				<td><?php e(date('d/m/Y', strtotime($record->endDate))); ?></td>
				<td><?php e($studyModes[$record->studyMode]); ?>
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
