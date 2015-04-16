<div class="admin-box">
    <h3>List of Available Courses</h3>

    <?= form_open(current_url()); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th colspan='2'>
                    <div class="control" style="float:right">
                        <a class="btn btn-success" href="<?= site_url(SITE_AREA.'/academic/course/download_cbank') ?>">download</a>
                    </div>
                    <div class="control" style="float:right; margin-right: 5px;">
                        <input type="search" name="search_term" style='margin-bottom: 0;' 
                        	value="<?= set_value('search', isset($post) ? $post->search_term : ''); ?>" 
                        	placeholder="search course title ..." title='Search by Course, Department' />
                        <input type="submit" name="submit" class="btn" value="Search" />
                    </div>
                </th>
                <th><?= '<div class="control" style="float:right">Total Count &rarr; '.$total.' </div>'; ?></th>
            </tr>
            <?= form_close()?>
            <?= form_open(current_url().'/delete_course'); ?>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Course Name</th>
				<th>Department</th>
				<th style="width: 20%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="2">With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?= lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Course(s)?')">
				</td>
				<td colspan="2"><?= $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($courses) && is_array($courses)) :
			foreach ($courses as $course) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $course->course_id ?>" /></td>
				<td>
					<a href="<?= site_url(SITE_AREA .'/academic/course/edit_course/'. $course->course_id) ?>">
						<?= $course->courseName; ?>
					</a>
				</td>
				<td><?= isset($course->dept_id) ? $course->dept_name : 'Not Available'; ?></td>
				<td><?= config_item('miscellaneous.status')[$course->status]; ?>
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

