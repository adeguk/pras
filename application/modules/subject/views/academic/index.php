<div class="admin-box">
    <!--h3>List of Available Subjects</h3-->
    <h3>List of Available Course Titles</h3>

    <?= form_open(current_url()); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th colspan='3'></th>
                <th colspan='3'>
                    <div class="control" style="float:right">
                        <a class="btn btn-success" href="<?= site_url(SITE_AREA.'/academic/subject/download_subject') ?>">download</a>
                    </div>
                    <div class="control" style="float:right;  margin-right: 5px;">
						<input type="search" name="search_term" style='margin-bottom: 0;' 
                        	value="<?= set_value('search', isset($post) ? $post->search_term : ''); ?>" 
							placeholder="search course title ..." title='or Search by Course code' />
						<input type="submit" name="submit" class="btn" value="Search" />
					</div>
				</th>
				<th><?= '<div class="control" style="float:right">Total Count &rarr; '.$total.' </div>'; ?></th>
			</tr>
            <?= form_close()?>
            <?php echo form_open(SITE_AREA.'/academic/subject/delete_subject'); ?>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th style="width: 10%">Course Code</th>
				<th>Course Title</th>
				<th style="width: 15%">Allocated Unit</th>
				<th>Description</th>
				<th>Instructor</th>
				<th style="width: 12%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Course(s)?')">
				</td>
				<td colspan="3"><?= $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($subjects) && is_array($subjects)) :
			foreach ($subjects as $subject) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?= $subject->subject_id ?>" /></td>
				<td>
					<a href="<?= site_url(SITE_AREA .'/academic/subject/edit_subject/'. $subject->subject_id) ?>">
						<?php e($subject->subjectCode); ?></a>
				</td>
				<td><?php e($subject->subjectTitle); ?></td>
				<td><?= config_item('miscellaneous.unit')[$subject->subjectUnit]; ?>
                </td>
				<td><?php e($subject->description); ?></td>
                <td><?php isset($subject->instructor) ? e(strtoupper($subject->lastname).', '.$subject->firstname.' '.$subject->middlename) : "No User found!" ?></td>
				<td><?php 
					$class = '';
					switch ($subject->status) {
						case 1:
							$class = " label-success";
							break;
						default:
							$class = " label-error";
							break;
					}
				?>
					<span class="label<?php echo($class); ?>">
					<?= config_item('miscellaneous.status')[$subject->status]; ?>
				</span>
                </td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="7">
					<br/>
					<div class="alert alert-warning">
						No Course Title found!
					</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
    </table>
    <?php echo form_close(); ?>
</div>
