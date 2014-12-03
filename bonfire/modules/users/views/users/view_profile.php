<section id="profile">

	<div class="page-header">
		<h1><?php e(lang('bf_user_settings')); ?> - <?php e($user->display_name); ?></h1>
	</div>

	<?php if (isset($user) && $user->role_name == 'Banned') : ?>
		<div data-dismiss="alert" class="alert alert-error">
			<?php echo lang('us_banned_admin_note'); ?>
		</div>
	<?php endif; ?>

	<div class="row-fluid">
		<div class="span3">
			<div class="profile-img">
				<?php echo gravatar_link($user->email, 96, null, $user->display_name) ?>
			</div>
		</div>
		<div class="span9">
			<div class="item firstchild">
				<h3>Matric Number</h3>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
			</div>
			<div class="item firstchild">
				<h3>Current Level</h3>
				<p>Ipsum dolor sit amet, consectetuer adipisci elit, sed diam</p>
			</div>
			<div class="item">
				<h3>Full Name</h3>
				<p><?php echo set_value('username', isset($user) ? $user->username : '') ?></p>
			</div>
			<div class="item">
				<h3>Date of Birth</h3>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
			</div>
			<div class="item">
				<h3>Course of Study</h3>
				<p>Ipsum dolor sit amet, consectetuer adipisci elit, sed diam</p>
			</div>
			<div class="item">
				<h3>Mobile/Email</h3>
				<p><?php echo set_value('email', isset($user) ? $user->email : '').'/'.set_value('email', isset($user) ? $user->email : '') ?></p>
			</div>
			<div class="comment-box">
				<h4>Comment/Remark</h4>
				<p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcor- per. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, 
					vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio</p>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h4>Educational Details</h3>
			<div class="item">
				<h4>Department</h4>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
			</div>
			<div class="item">
				<h4>Faculty</h4>
				<p>Ipsum dolor sit amet, consectetuer adipisci elit, sed diam</p>
			</div>
		</div>
		<div class="span4">
			<h4>Temporary (School-Area) Address</h4>
			<?php
				// Allow modules to render custom fields
				Events::trigger('render_user_form', $user );
			?>
			<!-- Start User Meta -->
			<?php $this->load->view('users/user_meta', array('frontend_only' => TRUE));?>
			<!-- End of User Meta -->
		</div>
		<div class="span4">
			<h4>Emergency Contact</h4>
			<?php
				// Allow modules to render custom fields
				Events::trigger('render_user_form', $user );
			?>
			<!-- Start User Meta -->
			<?php $this->load->view('users/user_meta', array('frontend_only' => TRUE));?>
			<!-- End of User Meta -->
		</div>
	</div>
</section>
