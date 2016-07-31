<?php
	$areaUrl = SITE_AREA . '/settings/course';
?>
<ul>
	<li><a href="<?php echo site_url($areaUrl .'/degree') ?>">
		<?php echo lang('pras_field_degree'); ?></a></li>
	<li><a href="<?php echo site_url($areaUrl .'/courseBank') ?>">
		<?php echo lang('pras_field_courseBank'); ?></a></li>
	<li><a href="<?php echo site_url($areaUrl) ?>">
		<?php echo lang('pras_field_program'); ?></a></li>
	<li><a href="<?php echo site_url($areaUrl .'/programmeUnit') ?>">
		<?php echo lang('pras_field_unit'); ?></a></li>
</ul>
