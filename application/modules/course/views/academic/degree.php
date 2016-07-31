<div class="admin-box">
    <h3>List of Accreditted Degree</h3>

    <?php echo form_open(SITE_AREA.'/academic/course/delete_degree'); ?>
    <table class="table table-striped">
        <thead>
        	<tr>
				<th colspan='2'></th>
				<th colspan='2'>
					<div class="control" style="float:right">
						<a class="btn btn-success" href="<?php echo site_url(SITE_AREA.'/academic/course/download_degree') ?>">download</a>
					</div>
				</th>
			</tr>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th>Degree Name</th>
				<th>Abbreviation</th>
				<th style="width: 20%">Status</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">With selected:&nbsp;
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('Are you sure you want to delete this Degree(s)?')">
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($degrees) && is_array($degrees)) :
			foreach ($degrees as $degree) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $degree->deg_id ?>" /></td>
				<td>
					<a href="<?php echo site_url(SITE_AREA .'/academic/course/edit_degree/'. $degree->deg_id) ?>">
						<?php e($degree->degreeName); ?>
					</a>
				</td>
				<td><?php e($degree->degreeAbbreviation); ?></td>
				<td><?php $status=config_item('miscellaneous.status');
                    e($status[$degree->status]); ?>
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

