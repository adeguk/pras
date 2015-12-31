<?php
   $num_columns	= 5;
   $can_delete	= $this->auth->has_permission('Student_Manager.Content.Delete');
   $can_edit	= $this->auth->has_permission('Student_Manager.Content.Edit');
   $has_records	= isset($records) && is_array($records) && count($records);

   $areaUrl = SITE_AREA . '/content/student_manager/';
   $edit_icon = '<i class="fa fa-edit fa-fw"></i>&nbsp';

   if ($can_delete) $num_columns++;
?>

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
					<a href="<?= $current_url .'?filter=faculty&fac_id='. $faculty->id ?>">
						<?= $faculty->fac_name; ?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		</li>
		<li <?= $filter=='alumni' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=alumni'; ?>"><?= 'Alumni'; ?></a></li>
		<li <?= $filter=='spilled' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=spilled'; ?>"><?= 'Spilled'; ?></a></li>
		<li <?= $filter=='suspended' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=suspended'; ?>"><?= 'Suspended'; ?></a></li>
		<li <?= $filter=='leave' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=leave'; ?>"><?= 'On Leave'; ?></a></li>
		<li <?= $filter=='rusticated' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=rusticated'; ?>"><?= 'Rusticated'; ?></a></li>
		<li <?= $filter=='deleted' ? 'class="active"' : ''; ?>><a href="<?= $current_url .'?filter=deleted'; ?>"><?= 'Deleted' ?></a></li>
        <li>&nbsp;</li>
        <li style="margin-top: 8px; font-weight: bold;"><?= 'Total Count &rarr; '.$total; ?></li>
	</ul>

	<?= form_open(current_url(), array('class'=>'form-search')); ?>
    <div class="well" style="overflow:auto">
        <div class="input-append" style="float:left; margin-bottom:0">
            <input class="search-query input-xlarge" type="search" name="search_term"
                value="<?= set_value('search', isset($post) ? $post->search_term : ''); ?>"
                placeholder="search student ..." title='Search by Firstname, Middlename, Lastname, Matric or Jamr reg' />
            <button class="btn" name="submit" type="submit" ><i class="fa fa-search fa-fw"></i></button>
        </div>
        <!--make a batch upload to this table-->
        <div style="float:left; margin-left:10px">
            <a class="btn btn-success" href="<?= site_url() ?>"><i class="fa fa-upload fa-fw" style="color:#fff"></i> Upload Students</i></a>
        </div>
        <!--download this table-->
        <div style="float:left; margin-left:10px">
            <a class="btn btn-success" href="<?= site_url() ?>"><i class="fa fa-download fa-fw" style="color:#fff"></i> Download this</i></a>
        </div>
        <!--print this page-->
        <div style="float:left; margin-left:10px">
            <a class="btn btn-success" href="<?= site_url() ?>"><i class="fa fa-print fa-fw" style="color:#fff"></i> Print this</a>
        </div>
    </div>
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
                <?php if ($can_delete && $has_records) : ?>
                <th class='column-check'><input class='check-all' type='checkbox' /></th>
                <?php endif;?>

				<th>Matric Number</th>
				<th><?= lang('pras_full_name'); ?></th>
				<th><?= lang('pras_field_program'); ?></th>
				<th><?= lang('pras_field_level'); ?></th>
				<th><?= lang('us_status'); ?></th>
			</tr>
		</thead>
        <!--****************** table footer starts *****************-->
  			<?php if ($has_records) : ?>
  			<tfoot>
  				<?php if ($can_delete) : ?>
  				<tr>
  					<td colspan='<?php echo $num_columns; ?>'>
					<?= lang('bf_with_selected') ?>
					<input type="submit" name="submit" class="btn btn-success" value="Current" />
					<input type="submit" name="submit" class="btn btn-warning" value="Spill" />
					<input type="submit" name="submit" class="btn btn-info" value="Leave" />
					<input type="submit" name="submit" class="btn btn-inverse" value="Alumni" />

                    <input type='submit' name='delete' id='delete-me' class='btn btn-danger'
                 value="<?php echo lang('bf_action_delete'); ?>"
                 onclick="return confirm('<?php e(js_escape(lang('pras_delete_confirm'))); ?>')" />
				</td>
			</tr>
            <?php endif; ?>
        </tfoot>
        <?php endif; ?>
  <!--****************** table body starts *****************-->
		<tbody>
            <?php
            if ($has_records) :
                foreach ($records as $record) :
              if ($record->deleted == 1) {
                 echo '<tr class="deleted">' ;
              } else {
                  echo '<tr>';
              }

              if ($can_delete) : ?>
                <td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->student_id; ?>' /></td>
                <?php endif;

           if (($can_edit) && ($record->deleted == 1)) : ?>
                <td><?php e($record->matricNo); ?></td>
               <?php elseif ($can_edit) : ?>
                <td><?php echo anchor($areaUrl . 'edit/' . $record->student_id, $edit_icon . $record->matricNo); ?></td>
                <?php else : ?>
                <td><?php e($record->matricNo); ?></td>
               <?php endif; ?>

				<td><a href='<?= site_url(SITE_AREA.'/settings/users/view_user/'.$record->user_id); ?>'
                     class = 'inline' title='View student personal details'>
					<?= strtoupper($record->lastname).', '.$record->firstname.' '.$record->middlename; ?></a></td>
				<td><?= $record->programme.' - <strong>'.config_item('miscellaneous.duration')[$record->duration].'</strong>'; ?></td>
                <td><?= config_item('miscellaneous.level')[$record->level]; ?></td>
				<td><?php
					$class = '';
					switch ($record->status) {
						case 1:
							$class = " label-success";
							break;
						case 2:
							$class = " label-inverse";
							break;
						case 3:
							$class = " label-warning";
							break;
						case 4:
							$class = " label-warning";
							break;
						case 5:
							$class = " label-info";
							break;
						case 6:
						default:
							$class = " label-danger";
							break;
					}
				?>
					<span class="label<?=($class); ?>">
					<?= config_item('miscellaneous.student_status')[$record->status]; ?>
					</span>
				</td>
			</tr>
            <?php
                endforeach;
            else:
            ?>
            <tr>
                <td colspan='<?php echo $num_columns; ?>'>
              <div class="alert alert-warning">
                 <?php echo lang('pras_records_empty'); ?>
              <div>
           </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php
    echo form_close();
    echo $this->pagination->create_links();
?>
</div>
