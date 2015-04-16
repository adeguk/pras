<div class="admin-box">
    <h3>List of Available Departments</h3>

    <?php echo form_open(current_url()); ?>
    <table class="table table-striped">
        <thead>
			<tr><th colspan='3'></th>
				<th colspan='2'>
                    <div class="control" style="float:right">
                        <a class="btn btn-success" href="<?php echo site_url(SITE_AREA.'/academic/faculty/download_dept') ?>">download</a>
                    </div>
					<div class="control" style="float:right;  margin-right: 5px;">
						<input type="search" name="search_term" style='margin-bottom: 0;' value="<?php echo set_value('search', isset($post) ? $post->search_term : ''); ?>" 
						placeholder="search department ..." title='or Search by faculty' />
						<input type="submit" name="submit" class="btn" value="Search" />
					</div>
				</th>
				<th colspan='2'><?php echo '<div class="control" style="float:right">Total Count &rarr; '.$total.' </div>'; ?></th>
			</tr>
            <?= form_close()?>
            <?php echo form_open(SITE_AREA.'/academic/faculty/delete_department'); ?>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Departments</th>
				<th>Name of HOD</th>
				<th>Faculty</th>
				<th>Description</th>
				<th style="width: 12%">Date Created</th>
				<th style="width: 8%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Department(s)?')">
				</td>
				<td colspan="2"><?php echo $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($departments) && is_array($departments)) :
			foreach ($departments as $d) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $d->dept_id ?>" /></td>
				<td>
					<a href="<?php echo site_url(SITE_AREA .'/academic/faculty/edit_department/'. $d->dept_id) ?>">
						<?php e($d->dept_name); ?>
					</a>
				</td>
				<td><?php isset($d->dept_hod) ? e(strtoupper($d->lastname).', '.$d->firstname.' '.$d->middlename) : "No User found!" ?></td>
				<td><?php e($d->fac_name); ?></td>
				<td>
					<!--?php e(limit_words($d->description, 15)); ?>... -->
					<a class="inline" href="<?php echo site_url(SITE_AREA .'/academic/faculty/dreadmore/'. $d->dept_id) ?>" title="Read more about <?php echo $d->dept_name ?>">
					CLick to Learn More</a></p>
				</td>
				<td><?php e($d->created_on); ?></td>
				<td><?php e($d->status=='1'?'Enabled':'Disabled'); ?></td>
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
