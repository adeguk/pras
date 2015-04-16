<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/student_manager') ?>"><?php echo "All Students"; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
		<a title='Add New Student Details' href="<?php echo site_url(SITE_AREA .'/content/student_manager/create') ?>" id="create_new"><?php echo 'Create'; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
		<a title='Bulk upload Matric Number' href="<?php echo site_url(SITE_AREA .'/content/student_manager/upload_matric') ?>" id="create_new"><?php echo 'Upload Matric'; ?></a>
	</li>
</ul>
