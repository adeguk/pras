<?php if (has_permission('Applications.Reports.Manage')):?>
<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/admission_applications') ?>"><?php echo "All Applicants"; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
		<a title='Add New Applicant Details' href="<?php echo site_url(SITE_AREA .'/reports/admission_applications/putme_stats') ?>" id="putme_stats"><?php echo 'Create'; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
		<a title='Bulk upload Applicants' href="<?php echo site_url(SITE_AREA .'/reports/admission_applications/pd_stats') ?>" id="pd_stats"><?php echo 'Upload Applicants'; ?></a>
	</li>
</ul>
