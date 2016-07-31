<div class="admin-box">
    <!--h3>List of Available Programme Subjects</h3-->
    <h3>List of Available Programme Course Titles</h3>

    <?= form_open(current_url()); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th colspan='3'></th>
				<th colspan='3'>
                    <div class="control" style="float:right;  margin-right: 5px;">
						<input type="search" name="search_term" style='margin-bottom: 0;' value="<?= set_value('search', isset($post) ? $post->search_term : ''); ?>" 
						placeholder="search course title ..." title='Search by Course code, Level, Programme' />
						<input type="submit" name="search" class="btn" value="Search" />
					</div>
				</th>
				<th colspan='2'>
                    <div class="control" style="float:left">
                        <a class="btn btn-success" href="<?= site_url(SITE_AREA.'/academic/subject/download_progsubject') ?>">download</a>
                    </div>
                    <?= '<div class="control" style="float:right;margin-top: 5px;">Total Count &rarr; '.$total.' </div>'; ?></th>
			</tr>
			<?= form_close()?>
			<?= form_open(SITE_AREA.'/academic/subject/delete_progSubject'); ?>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Programme</th>
				<th>Course</th>
				<th style="width: 9%">Level</th>
				<th style="width: 10%">Semester</th>
				<th style="width: 10%">Choice</th>
				<th style="width: 17%">Course Adviser</th>
				<th style="width: 9%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?= lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this programme Lecture Course(s)?')">
				</td>
				<td colspan="3"><?= $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($progSubjects) && is_array($progSubjects)) :
			foreach ($progSubjects as $ps) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?= $ps->progSubj_id ?>" /></td>
				<td>
					<a href="<?= site_url(SITE_AREA .'/academic/subject/edit_programme_subject/'. $ps->progSubj_id) ?>">
					<?= $ps->programme.' - <strong>'.config_item('miscellaneous.duration')[$ps->duration].'</strong>'; ?>
					</a>
				</td>
				<td><?= $ps->courseTitle; ?></td>
				<td><?= config_item('miscellaneous.level')[$ps->level]; ?></td>
                <td><?= config_item('miscellaneous.semester')[$ps->semester]; ?></td>
                <td><?= config_item('miscellaneous.choice')[$ps->choice]; ?></td>
				<td><?= $ps->courseAdviser ?></td>
				<td><?php $class = '';
					switch ($ps->status) {
						case 1:
							$class = " label-success";
							break;
						default:
							$class = " label-error";
							break;
					}
				?>
					<span class="label<?=($class); ?>">
					<?= config_item('miscellaneous.status')[$ps->status]; ?>
				</span>
                </td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="7">
					<br/>
					<div class="alert alert-warning">
						No Programme Lecture Course found!
					</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
    </table>
    <?= form_close();?>
</div>
