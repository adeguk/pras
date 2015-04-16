<div class="admin-box">
    <h3>List of Available Faculties</h3>

    <?php echo form_open(current_url().'/delete'); ?>
    <table class="table table-striped">
        <thead>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Faculty</th>
				<th>Dean</th>
				<th>Description</th>
				<th style="width: 12%">Date Created</th>
				<th style="width: 8%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Faculty(s)?')">
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($faculty) && is_array($faculty)) :
			foreach ($faculty as $f) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $f->fac_id ?>" /></td>
				<td>
					<a href="<?php echo site_url(SITE_AREA .'/academic/faculty/edit_faculty/'. $f->fac_id) ?>">
						<?php e($f->fac_name); ?>
					</a>
				</td>
				<td><?php e(strtoupper($f->lastname).', '.$f->firstname.' '.$f->middlename) ?></td>
				<td><?php e(limit_words($f->description, 15)); ?>... 
					<a class="inline" href="<?php echo site_url(SITE_AREA .'/academic/faculty/readmore/'. $f->fac_id) ?>" title="Read more about <?php echo $f->fac_name ?>">
					read more</a></p></td>
				<td><?php e($f->created_on); ?></td>
				<td><?php e($f->status=='1'?'Enabled':'Disabled'); ?></td>
			</tr>
			<?php endforeach;
            else: ?>
			<tr>
				<td colspan="5">
					<br/>
					<div class="alert alert-warning">
						No Faculty found.
					</div>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
		<?php echo form_close(); ?>
    </table>
</div>
