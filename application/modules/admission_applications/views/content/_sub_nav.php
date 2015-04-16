<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/admission_applications') ?>"><?php echo "All Applicants"; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
		<a title='Add New Applicant Details' href="<?php echo site_url(SITE_AREA .'/content/admission_applications/create') ?>" id="create_new"><?php echo 'Create'; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
		<a title='Bulk upload Applicants' href="<?php echo site_url(SITE_AREA .'/content/admission_applications/upload_applicants') ?>" id="create_new"><?php echo 'Upload Applicants'; ?></a>
	</li>
</ul>
