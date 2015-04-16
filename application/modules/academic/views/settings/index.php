<div class="admin-box">
    <h3>List of Academic Sessions</h3>

    <?php echo form_open(current_url().'/delete_session'); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Session</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Study Mode</th>
				<th style="width: 8%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this session(s)?')">
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($academic_sessions) && is_array($academic_sessions)) :
			foreach ($academic_sessions as $as) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $as->aca_session_id ?>" /></td>
				<td>
					<a href="<?php echo site_url(SITE_AREA .'/settings/academic/edit_academic_session/'. $as->aca_session_id) ?>">
					<?php $sessions=config_item('miscellaneous.session');
                    	e($sessions[$as->session]); ?>
					</a>
				</td>
				<td><?php e(date('d/m/Y', strtotime($as->startDate))); ?></td>
				<td><?php e(date('d/m/Y', strtotime($as->endDate))); ?></td>
				<td><?php $studyModes = config_item('miscellaneous.studyMode');
                    e($studyModes[$as->studyMode]); ?>
				</td>
				<td><?php $status = config_item('miscellaneous.status');
                    e($status[$as->status]); ?>
				</td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="6">
					<br/>
					<div class="alert alert-warning">
						No Academic Session found.
					</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
    </table>
</div>
