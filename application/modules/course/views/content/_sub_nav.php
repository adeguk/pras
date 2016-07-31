<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/course') ?>"><?php echo "My Registration"; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'addCourse' ? 'class="active"' : '' ?>>
		<a title='Add New Student Details' href="<?php echo site_url(SITE_AREA .'/content/course/addCourse') ?>" id="create_new"><?php echo 'Add Course'; ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'registrationHistory' ? 'class="active"' : '' ?>>
		<a title='Bulk upload Matric Number' href="<?php echo site_url(SITE_AREA .'/content/course/registrationHistory') ?>" id="create_new"><?php echo 'View History'; ?></a>
	</li>
</ul>
