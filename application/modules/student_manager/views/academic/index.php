<div class="admin-box">
    <h3>List of Available Courses</h3>

    <?php echo form_open(current_url().'/delete_course'); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Course Name</th>
				<th>Department</th>
				<th style="width: 20%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Course(s)?')">
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($courses) && is_array($courses)) :
			foreach ($courses as $course) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $course->course_id ?>" /></td>
				<td>
					<a href="<?php echo site_url(SITE_AREA .'/academic/course/edit_course/'. $course->course_id) ?>">
						<?php e($course->courseName); ?>
					</a>
				</td>
				<td><?php e(isset($course->dept_id) ? $this->department_model->get_field($course->dept_id, 'dept_name'):'Not Available'); ?></td>
				<td><?php $status=config_item('miscellaneous.status');
                    e($status[$course->status]); ?>
                </td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="4">
					<br/>
					<div class="alert alert-warning">
						No Course found!
					</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
    </table>
</div>

