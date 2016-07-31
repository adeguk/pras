<?php
	$areaUrl = SITE_AREA . '/settings/academics';
?>
<ul>
	<li><a href="<?php echo site_url($areaUrl) ?>">
		<?php echo lang('pras_field_session'); ?></a></li>
	<li><a href="<?php echo site_url($areaUrl .'/department') ?>">
		<?php echo lang('pras_field_department'); ?></a></li>
	<li><a href="<?php echo site_url($areaUrl .'/faculty') ?>">
		<?php echo lang('pras_field_faculty'); ?></a></li>
	<li><a href="<?php echo site_url($areaUrl .'/semesterSession') ?>">
		<?php echo lang('pras_field_semester'); ?></a></li>
</ul>
