<div class="admin-box">
    <h3>List of all Programmes and their Set Total Required Units</h3>

    <?php echo form_open(current_url().'/delete'); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Course Name</th>
				<th>Minimum Unit</th>
				<th>Maximum Unit</th>
				<th>Level</th>
				<th>Semester</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Programme Unit(s)?')">
				</td>
				<td colspan="2"><?php echo $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($psUnits) && is_array($psUnits)) :
			foreach ($psUnits as $psu) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $psu->progSU_id ?>" /></td>
				<td>
					<a href="<?php echo site_url(SITE_AREA .'/settings/course/edit/'. $psu->progSU_id) ?>">
					<?php 
						if (isset($psu->prog_id)) {
							$progs = $this->programme_model->find_all_by('programme.course_id', $psu->prog_id);
			                foreach($progs as $prog){
			                    echo $prog->degreeAbbreviation.' '.$prog->courseName.' - <strong>'.config_item('miscellaneous.duration')[$prog->progDuration].'</strong>';
			              	}
						}
					?>
					</a>
				</td>
				<td><?php $totalUnits=config_item('miscellaneous.totalUnit');
                    e($totalUnits[$psu->minimumUnit]); ?>
                </td>
                <td><?php $totalUnits=config_item('miscellaneous.totalUnit');
                    e($totalUnits[$psu->maximumUnit]); ?>
                </td>
				<td><?php $levels=config_item('miscellaneous.level');
                    e($levels[$psu->progLevel]); ?>
                </td>
				<td><?php $semesters=config_item('miscellaneous.semester');
                    e($semesters[$psu->progSemester]); ?>
                </td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="6">
					<br/>
					<div class="alert alert-warning">
						No Programme Semester's Unit found!
					</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
    </table>
</div>