<?php
	$checkSegment = $this->uri->segment(4);
	$areaUrl = SITE_AREA . '/settings/academics';
?>
<ul class="nav nav-pills">
	<?php if ($this->auth->has_permission('Academics.Settings.Create')) : ?>
	<li <?php echo $checkSegment == 'create' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url($areaUrl . '/createAcademicSession') ?>" id='createAcademicSession'>
			<?php echo lang('pras_action_new').' '.lang('pras_field_session'); ?>
		</a>
	</li>
	<li <?php echo $checkSegment == 'create' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url($areaUrl . '/createSemesterSession') ?>" id='createSemesterSession'>
			<?php echo lang('pras_action_new').' '.lang('pras_field_semester'); ?>
		</a>
	</li>
	<li <?php echo $checkSegment == 'create' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url($areaUrl . '/createFaculty') ?>" id='create_faculty'>
			<?php echo lang('pras_action_new').' '.lang('pras_field_faculty'); ?>
		</a>
	</li>
	<li <?php echo $checkSegment == 'create' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url($areaUrl . '/createDepartment') ?>" id='create_department'>
			<?php echo lang('pras_action_new').' '.lang('pras_field_department'); ?>
		</a>
	</li>
<?php endif ?>
</ul>
