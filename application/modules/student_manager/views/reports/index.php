<div class="row">
	<br style="clear:both">    
	<div class="column size1of3">
		<!-- Population Statistics -->
		<div class="admin-box">
			<h4><?= 'Top 5 Faculties (&uarr;)'; ?></h4>
			<?php if (isset($top_faculties) && is_array($top_faculties) && count($top_faculties)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?= 'Faculty'; ?></th>
							<th><?= 'Total Students'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($top_faculties as $top_faculty) : ?>
						<tr>
							<td>
								<strong><?= $top_faculty->fac_name; ?></strong>
							</td>
							<td><?= $top_faculty->total; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<?= lang('activity_no_top_faculties'); ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="column size1of3">
		<div class="admin-box">
			<h4><?= 'Top 5 Departments (&uarr;)'; ?></h4>
			<?php if (isset($top_faculties) && is_array($top_faculties) && count($top_faculties)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?= 'Departments'; ?></th>
							<th><?= 'No. of Students'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($top_departments as $top_department) : ?>
						<tr>
							<td>
								<strong><?= $top_department->dept_name; ?></strong>
							</td>
							<td><?= $top_department->total; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<?= lang('activity_no_top_departments'); ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="column  size1of3">
		<div class="admin-box">
			<h4><?= 'Down 5 Departments (&darr;)'; ?></h4>
			<?php if (isset($down_departments) && is_array($down_departments) && count($down_departments)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?= 'Departments'; ?></th>
							<th><?= 'Total No. of Students'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($down_departments as $down_department) : ?>
						<tr>
							<td>
								<strong><?= $down_department->dept_name; ?></strong>
							</td>
							<td><?= $down_department->total; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<?= lang('activity_no_top_departments'); ?>
			<?php endif; ?>
		</div>
	</div>
	<br style="clear:both">
<!-- Students' population Statistics by Faculty and level -->
	<div>
		<div class="admin-box">
			<h4><?= 'Overview of All Active Fulltime Students'; ?></h4>
			<?php if (isset($allCounts) && is_array($allCounts) && count($allCounts)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo 'Faculty'; ?></th>
							<th><?php echo '100 Level'; ?></th>
							<th><?php echo '200 Level'; ?></th>
							<th><?php echo '300 Level'; ?></th>
							<th><?php echo '400 Level'; ?></th>
							<th><?php echo '500 Level'; ?></th>
							<th><?php echo 'Total'; ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php echo 'Total'; ?></th>
							<th>
							<?php $x=null; 
								foreach ($allCounts as $allCount) {
									$x += $allCount->L1; 
								} 
								echo $x;
							?>
							</th>
							<th>
							<?php $x=null; 
								foreach ($allCounts as $allCount) {
									$x += $allCount->L2; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allCounts as $allCount) {
									$x += $allCount->L3; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allCounts as $allCount) {
									$x += $allCount->L4; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allCounts as $allCount) {
									$x += $allCount->L5; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allCounts as $allCount) {
									$x += $allCount->total; 
								} 
								echo $x;
							?></th>
						</tr>
					</tfoot>
					<tbody>
					<?php foreach ($allCounts as $allCount) : ?>
						<tr>
							<td><strong><?php e($allCount->fac_name); ?></strong></td>
							<td><?php e($allCount->L1); ?></td>
							<td><?php e($allCount->L2); ?></td>
							<td><?php e($allCount->L3); ?></td>
							<td><?php e($allCount->L4); ?></td>
							<td><?php e($allCount->L5); ?></td>
							<td><?php e($allCount->total);?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<?= '<h3><b>No record found!</b></h3>'; ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="column  size1of2">
		<div class="admin-box">
			<h4><?php echo 'Overview of Non-current Students'; ?></h4>
			<?php if (isset($allNons) && is_array($allNons) && count($allNons)) : ?>
			<table class="table table-striped">
				<thead>
						<tr>
							<th><?= 'Faculty'; ?></th>
							<th><?= '100 Level'; ?></th>
							<th><?= '200 Level'; ?></th>
							<th><?= '300 Level'; ?></th>
							<th><?= '400 Level'; ?></th>
							<th><?= '500 Level'; ?></th>
							<th><?= 'Total'; ?></th>
						</tr>
				</thead>
				<tfoot>
						<tr>
							<th><?= 'Total'; ?></th>
							<th>
							<?php $x=null; 
								foreach ($allNons as $allNon) {
									$x += $allNon->L1; 
								} 
								echo $x;
							?>
							</th>
							<th>
							<?php $x=null; 
								foreach ($allNons as $allNon) {
									$x += $allNon->L2; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allNons as $allNon) {
									$x += $allNon->L3; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allNons as $allNon) {
									$x += $allNon->L4; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allNons as $allNon) {
									$x += $allNon->L5; 
								} 
								echo $x;
							?></th>
							<th>
							<?php $x=null; 
								foreach ($allNons as $allNon) {
									$x += $allNon->total; 
								} 
								echo $x;
							?></th>
						</tr>
				</tfoot>
				<tbody>
				<?php foreach ($allNons as $allNon) : ?>
					<tr>
						<td><strong><?php e($allNon->fac_name); ?></strong></td>
						<td><?php e($allNon->L1); ?></td>
						<td><?php e($allNon->L2); ?></td>
						<td><?php e($allNon->L3); ?></td>
						<td><?php e($allNon->L4); ?></td>
						<td><?php e($allNon->L5); ?></td>
						<td><?php e($allNon->total);?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			<?php else : ?>
			<table class="table table-striped">
				<tr><td><?php echo '<h3><b>No record found!</b></h3>'; ?></td></tr>
			<?php endif; ?>
			</table>
		</div>
	</div>
	<div class="column  size1of4">
		<div class="admin-box">
			<h4><?= 'Breakdown by Study Mode'; ?></h4>
			<?php if (isset($studymodes) && is_array($studymodes) && count($studymodes)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?= 'Study Mode'; ?></th>
							<th><?= 'Counts'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($studymodes as $studymode) : ?>
						<tr>
							<td>
								<strong><?= config_item('miscellaneous.studyMode')[$studymode->studyMode]; ?></strong>
							</td>
							<td><?= $studymode->total; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<?= '<h3><b>No record found!</b></h3>'; ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="column  size1of4">
		<div class="admin-box">
			<h4><?= 'Breakdown by Students\' Status'; ?></h4>
			<?php if (isset($byStatus) && is_array($byStatus) && count($byStatus)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?= 'Status'; ?></th>
							<th><?= 'Counts'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($byStatus as $byS) : ?>
						<tr>
							<td>
								<strong><?= config_item('miscellaneous.student_status')[$byS->status]; ?></strong>
							</td>
							<td><?= $byS->total; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<?= '<h3><b>No record found!</b></h3>'; ?>
			<?php endif; ?>
		</div>
	</div>
	<br style="clear:both">
</div>