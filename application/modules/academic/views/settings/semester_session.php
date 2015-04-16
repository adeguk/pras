<div class="admin-box">
    <h3>List of Academic Semester Sessions</h3>

    <?php echo form_open(site_url(SITE_AREA.'/settings/academic/delete_semester_session')); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Session Semester</th>
				<th>Academic Session</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Is Current?</th>
				<th>Is Registration?</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Semester Session(s)?')">
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($semester_sessions) && is_array($semester_sessions)) :
			foreach ($semester_sessions as $ss) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $ss->sem_session_id ?>" /></td>
				<td>
					<a href="<?php echo site_url(SITE_AREA .'/settings/academic/edit_semester_session/'. $ss->sem_session_id) ?>">
					<?php $semesters=config_item('miscellaneous.semester');
                    	e($semesters[$ss->session_semester]); ?>
					</a>
				</td>
				<td>
				<?php 
					if (isset($ss->aca_session_id)) {
						$aca_sessions = $this->academic_session_model->select('session, studyMode')->find_all_by('aca_session_id', $ss->aca_session_id);
		                foreach($aca_sessions as $as){
		                    $sessions = config_item('miscellaneous.session');
		                    e($sessions[$as->session]);
		                    $studyModes=config_item('miscellaneous.studyMode');
		                    e(' - '.$studyModes[$as->studyMode]);
						}
					}
				?>
				</td>				
				<td><?php e(date('d/m/Y', strtotime($ss->startDate))); ?></td>
				<td><?php e(date('d/m/Y', strtotime($ss->endDate))); ?></td>
				<td>
					<?php $isCurrent = config_item('miscellaneous.status');
                    e($isCurrent[$ss->isCurrent]); ?>
				</td>
				<td>
					<?php $isRegistration = config_item('miscellaneous.status');
                    e($isRegistration[$ss->isRegistration]); ?>
				</td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="7">
					<br/>
					<div class="alert alert-warning">
						No Department found!
					</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
    </table>
</div>
