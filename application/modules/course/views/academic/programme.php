<div class="admin-box">
    <h3>List of Accreditted Programmes Offerred</h3>

    <?= form_open(current_url()); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th colspan='2'></th>
				<th colspan='2'>
					<div class="control" style="float:right">
						<a class="btn btn-success" href="<?= site_url(SITE_AREA.'/academic/course/download_programme') ?>">download</a>
					</div>
					<div class="control" style="float:right; margin-right: 5px;">
						<input type="search" name="search_term" style='margin-bottom: 0;' 
                        	value="<?= set_value('search', isset($post) ? $post->search_term : ''); ?>" 
							placeholder="search course title ..." title='Search by Course, Department' />
						<input type="submit" name="submit" class="btn" value="Search" />
					</div>
				</th>
				<th colspan='2'><?='<div class="control" style="float:right">Total Count &rarr; '.$total.' </div>'; ?></th>
			</tr>
			<?= form_close()?>
			<?= form_open(SITE_AREA.'/academic/course/delete_programme'); ?>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Programme</th>
				<th>Department</th>
				<th style="width: 10%">Study Mode</th>
				<th style="width: 10%">Duration</th>
				<th style="width: 8%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?= lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Programme(s)?')">
				</td>
				<td colspan="3"><?= $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($programmes) && is_array($programmes)) :
			foreach ($programmes as $p) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?= $p->prog_id ?>" /></td>
				<td>
					<a href="<?= site_url(SITE_AREA .'/academic/course/edit_programme/'. $p->prog_id) ?>">
						<?= $p->programme; ?>
					</a>
				</td>
				<td><?= isset($p->department) ? $p->department :'Not Available'; ?></td>
				<td><?= config_item('miscellaneous.studyMode')[$p->studyMode]; ?></td>
				<td><?= config_item('miscellaneous.duration')[$p->duration]; ?></td>
				<td><?= config_item('miscellaneous.status')[$p->status]; ?></td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="7">
					<br/>
					<div class="alert alert-warning">No Programme found!</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
    </table>
    <?= form_close(); ?>
</div>

