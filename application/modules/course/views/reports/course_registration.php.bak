<div class="row">
	<div class="column size1of3">

		<!-- Population Statistics -->
		<div class="admin-box">
			<h3><?php echo 'Population Statistics'; ?></h3>
			<?php# if (isset($registrations) && is_array($registrations) && count($registrations)) : ?>

				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo 'activity_module'; ?></th>
							<th><?php echo 'activity_logged'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php #foreach ($registrations as $registration) : ?>
						<tr>
							<td>
								<strong><?php echo 'row A1';#echo ucwords($registration->module); ?></strong>
							</td>
							<td><?php echo 'row A2';#echo $registration->activity_count; ?></td>
						</tr>
					<?php #endforeach; ?>
					</tbody>
				</table>

			<?php #else : ?>
				<?php #echo lang('activity_no_registrations'); ?>
			<?php #endif; ?>
		</div>

	</div>
<!-- Students' Registration Statistics by Faculty -->
	<div class="column size1of3">

		<!-- Active Modules -->
		<div class="admin-box">
			<h3><?php echo lang('registration_by_faculty'); ?></h3>
			<?php# if (isset($registrations) && is_array($registrations) && count($registrations)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo 'Faculty'; ?></th>
							<th><?php echo 'This Week Reading'; ?></th>
							<th><?php echo 'Last Week Reading'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php #foreach ($registrations as $registration) : ?>
						<tr>
							<td>
								<strong><?php echo 'row A1';#echo ucwords($registration->faculty); ?></strong>
							</td>
							<td><?php echo 'row A2';#echo $registration->student_count; ?></td>
							<td><?php echo 'row A2';#echo $registration->student_count; ?></td>
						</tr>
					<?php #endforeach; ?>
					</tbody>
				</table>
			<?php #else : ?>
				<?php #echo lang('activity_no_registrations'); ?>
			<?php #endif; ?>
		</div>
	</div>
<!-- Students' Registration Statistics by level -->
	<div class="column size1of3 last-column">
		<div class="admin-box">
			<!-- Active Users -->
			<h3><?php echo lang('registration_by_level'); ?></h3>
			<?php #if (isset($top_users) && is_array($top_users) && count($top_users)) : ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo 'Acadmic Level'; ?></th>
							<th><?php echo 'This Week Reading'; ?></th>
							<th><?php echo 'Last Week Reading'; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php #foreach ($registrations as $registration) : ?>
						<tr>
							<td>
								<strong><?php echo 'row A1';#echo ucwords($registration->faculty); ?></strong>
							</td>
							<td><?php echo 'row A2';#echo $registration->student_count; ?></td>
							<td><?php echo 'row A2';#echo $registration->student_count; ?></td>
						</tr>
				<?php #endforeach; ?>
					</tbody>
				</table>

			<?php #else : ?>
				<?php #echo lang('activity_no_top_users'); ?>
			<?php #endif; ?>
		</div>
	</div>
</div>