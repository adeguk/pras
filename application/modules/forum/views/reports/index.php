<?php

$num_columns	= 5;
$can_delete	= $this->auth->has_permission('Forum.Reports.Delete');
$can_edit		= $this->auth->has_permission('Forum.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('forum_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('forum_field_field1'); ?></th>
					<th><?php echo lang('forum_field_field2'); ?></th>
					<th><?php echo lang('forum_field_field3'); ?></th>
					<th><?php echo lang('forum_field_field4'); ?></th>
					<th><?php echo lang('forum_field_field5'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('forum_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/reports/forum/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->field1); ?></td>
				<?php else : ?>
					<td><?php e($record->field1); ?></td>
				<?php endif; ?>
					<td><?php e($record->field2); ?></td>
					<td><?php e($record->field3); ?></td>
					<td><?php e($record->field4); ?></td>
					<td><?php e($record->field5); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('forum_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>