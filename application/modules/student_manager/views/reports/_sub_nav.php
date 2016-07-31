<?php if (has_permission('Course.Settings.Manage')):?>
<!--ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a title="view all programmes semester total required units" href="<?php echo site_url(SITE_AREA .'/settings/course') ?>"><?php echo 'Programme Unit'; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
		<a title="Set individual programme semester total required units" href="<?php echo site_url(SITE_AREA .'/settings/course/create') ?>" id="create_new"><?php echo lang('bf_new') .' Programme Unit '; ?></a>
	</li>
</ul-->
<?php endif;?>