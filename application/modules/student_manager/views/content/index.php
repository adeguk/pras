<div class="admin-box">
	<h3>All Students</h3>

	<ul class="nav nav-tabs" >
		<li <?= $filter=='' ? 'class="active"' : ''; ?>><a href="<?= $current_url; ?>" title='List of all current students expect spill-overs'>All Students</a></li>
		<li class="<?= $filter == 'studyMode' ? 'active ' : ''; ?>dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				By Study Mode <?= isset($filter_studymode) ? ": $filter_studymode" : ''; ?>
				<b class="caret light-caret"></b>
			</a>
			<ul class="dropdown-menu">
			<?php foreach ($studyModes as $key=>$name) : ?>
				<li>
					<a href="<?= $current_url .'?filter=studyMode&key='. $key ?>"><?= $name; ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</li>
		<li class="<?= $filter == 'faculty' ? 'active ' : ''; ?>dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				By Faculty <?= isset($filter_faculty) ? ": $filter_faculty" : ''; ?>
				<b class="caret light-caret"></b>
			</a>
			<ul class="dropdown-menu">
			<?php foreach ($faculties as $faculty) : ?>
				<li>
					<a href="<?= $current_url .'?filter=faculty&fac_id='. $faculty->fac_id ?>">
						<?= $faculty->fac_name; ?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		</li>
		<!--li class="< ?= $filter == 'department' ? 'active ' : ''; ?>dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				By Department < ?= isset($filter_department) ? ": $filter_department" : ''; ?>
				<b class="caret light-caret"></b>
			</a>
			<ul class="dropdown-menu">
			< ?php foreach ($departments as $department) : ?>
				<li>
					<a href="< ?= $current_url .'?filter=department&dept_id='. $department->dept_id ?>">< ?= $department->dept_name; ?></a>
				</li>
			< ?php endforeach; ?>
			</ul>
		</li-->
		<li <?= $filter=='alumni' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=alumni'; ?>"><?= 'Alumni'; ?></a></li>
		<li <?= $filter=='spilled' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=spilled'; ?>"><?= 'Spilled'; ?></a></li>
		<li <?= $filter=='suspended' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=suspended'; ?>"><?= 'Suspended'; ?></a></li>
		<li <?= $filter=='leave' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=leave'; ?>"><?= 'On Leave'; ?></a></li>
		<li <?= $filter=='rusticated' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=rusticated'; ?>"><?= 'Rusticated'; ?></a></li>
		<li <?= $filter=='deleted' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=deleted'; ?>"><?= 'Deleted' ?></a></li>
        <li>&nbsp;</li>
        <li style="margin-top: 8px; font-weight: bold;"><?= 'Total Count &rarr; '.$total; ?></li>
	</ul>

	<?= form_open(current_url()); ?>

	<table class="table table-striped">
		<thead>
			<tr>
				<th colspan='5'</th>
				<th colspan='2'>
					<div class="control" style="float:right">
						<input type="search" name="search_term" style='margin-bottom: 0;' 
                        	value="<?= set_value('search', isset($post) ? $post->search_term : ''); ?>" 
							placeholder="search student ..." title='Search by Firstname, Middlename, Lastname, Matric or Jamr reg' />
						<input type="submit" name="submit" class="btn" value="Search" />
					</div>
				</th>
			</tr>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Matric</th>
				<th><?= lang('user_fullname'); ?></th>
				<th colspan='2'>Course</th>
				<!--th>Gender</th-->
				<th>Level</th>
				<th><?= lang('us_status'); ?></th>
			</tr>
		</thead>
		<?php if (isset($students) && is_array($students) && count($students)) : ?>
		<tfoot>
			<tr>
				<td colspan="5">
					<?= lang('bf_with_selected') ?>
					<input type="submit" name="submit" class="btn btn-success" value="Current" />
					<input type="submit" name="submit" class="btn btn-primary" value="Spill" />
					<input type="submit" name="submit" class="btn btn-warning" value="Leave" />
					<input type="submit" name="submit" class="btn btn-success" value="Alumni" />
					<input type="submit" name="delete" class="btn btn-danger" id="delete-me" 
                    	value="<?= lang('bf_action_delete') ?>" style="margin-bottom: 0px; " 
                        onclick="return confirm('<?= lang('bf_action_delete'); ?>')" />
				</td>
				<td colspan='2'><?= $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<?php endif; ?>
		<tbody>

		<?php if (isset($students) && is_array($students) && count($students)) : ?>
			<?php foreach ($students as $student) : ?>
			<tr>
				<td>
					<input type="checkbox" name="checked[]" value="<?= $student->studentID ?>" />
				</td>
				<td><a href='<?= site_url(SITE_AREA.'/content/student_manager/edit/'.$student->studentID); ?>' title='Manage student academic details'>
					<?= $student->matricNo; ?>
				</a></td>
				<td><a href='<?= site_url(SITE_AREA.'/settings/users/edit/'.$student->user_id); ?>' target='_blank' title='Manage student personal details'>
					<?= $student->fullname; ?></a></td>
				<td colspan='2'><?= $student->programme.' - <strong>'.config_item('miscellaneous.duration')[$student->duration].'</strong>'; ?></td>
				<!--td>< ?= $student->gender; ?></td-->
                <td><?= config_item('miscellaneous.level')[$student->level]; ?></td>
				<td><?php 
					$class = '';
					switch ($student->status) {
						case 1:
							$class = " label-success";
							break;
						case 2:
							$class = " label-success";
							break;
						case 3:
							$class = " label-warning";
							break;
						case 4:
							$class = " label-error";
							break;
						case 5:
							$class = " label-info";
							break;
						case 6:
						default:
							$class = " label-error";
							break;
					}
				?>
					<span class="label<?=($class); ?>">
					<?= config_item('miscellaneous.student_status')[$student->status]; ?>
					</span>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="7">No students found that match your selection.</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<?= form_close(); ?>
</div>