<section id="profile">

	<div class="page-header">
		<h1><?php e(lang('bf_user_settings')); ?> - <?php e(strtoupper($user->lastname) .', '. $user->firstname . ' ' . $user->middlename); ?></h1>
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
				<p><?php echo (isset($user->matricNo) ? $user->matricNo : '<b>Update matric detail</b>'); ?></p>
			</div>
			<div class="item firstchild">
				<h3>Email Address</h3>
				<p><?php e(isset($user->email) ? $user->email : '<b>Update Email detail</b>') ?></p>
			</div>
			<?php if (isset($user) && $user->role_id == '7'): ?>
			<div class="item">
				<h3>Course of Study</h3>
				<p><?php 
						if (isset($user->prog_id)) {
							$progs = $this->programme_model->find_all_by('prog_id', $user->prog_id);
			                foreach($progs as $prog){
			                    echo $prog->degreeAbbreviation.' '.$prog->courseName.' - <strong>'.config_item('miscellaneous.duration')[$prog->progDuration].'</strong>';
			              	}
						}
					?>
				</p>
			</div>
			<div class="item">
				<h3>Current Level</h3>
				<p><?php $cLevel = config_item('miscellaneous.level');
					echo (isset($user->level) ? $cLevel[$user->level] : '<b>update level</b>');
                ?></p>
			</div>
			<?php endif; ?>
			<div class="item">
				<h3>Mobile</h3>
				<p><?php echo (isset($user->mobile) ? $user->mobile : '<b>Update Mobile detail</b> - '); ?></p>
			</div>
			<div class="item">
				<h3>Date of Birth</h3>
				<p><?php echo (isset($user->dob) ? date('d-m-Y', strtotime($user->dob)) : '<b>Update date of birth</b>'); ?></p>
			</div>
			<div class="item">
				<h3>Gender</h3>
				<p><?php echo (isset($user->gender) ? $user->gender : '<b>Update gender detail</b>');  ?></p>
			</div>
			<div class="item">
				<h3>Marital Status</h3>
				<p><?php $mS = config_item('miscellaneous.marital_status');
					echo (isset($other->marital_status) ? $mS[$other->marital_status] : '<b>update marital status</b>');
                ?></p>
			</div>
			<div class="item">
				<h3>Religion</h3>
				<p><?php $religions = config_item('miscellaneous.religion');
					echo (isset($other->religion) ? $religions[$other->religion] : '<b>update religion detail</b>');
                ?></p>
			</div>
			<div class="item">
				<h3>Health Status</h3>
				<p><?php $hS = config_item('miscellaneous.health_status');
					echo (isset($other->health_status) ? $hS[$other->health_status] : '<b>update health status</b>');
                ?></p>
			</div>		
		</div>
	</div>
	<div class="row-fluid" style="margin-top:10px">
		<div class="span4 block">
			<!--h4>Comment/Remark</h4>
			<p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcor- per. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, 
			vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio</p-->
			<h4>Educational History</h4>
			<!-- Start Emergency Contact -->
			<?php if (isset($education) && is_array($education)) : 
			foreach ($education as $edu) : ?>
			<div class="item vertical">
				<h3>Institution/Date</h3>
				<p><?php e($edu->edu_centre_name . ' ('. $edu->edu_start_date . ' to '. $edu->edu_end_date . ')'); ?></p>
				<p><b>Result/Grade: </b><?php e($edu->edu_certificate . ' ('. $edu->edu_result . ')'); ?></p>
			</div>
			<?php endforeach;
            else: ?>
				<div class="alert alert-warning">
						No Educational history found!
				</div>
			<?php endif; ?><!-- End of Emergency Contact -->
		</div>
		<div class="span4 block">
			<h4>Temporary (School-Area) Address</h4>
			<!-- Start User Meta -->
			<div class="item firstchild vertical">
				<h3>Street Name</h3>
				<p><?php echo (isset($user->street_name) ? $user->street_name : '<b>Update street name</b>'); ?></p>
			</div>
			<div class="item vertical">
				<h3>Local Government/State</h3>
				<p><?php echo (isset($user->state) ? $user->state : '<b>Update state of origin</b>'); ?></p>
			</div>
			<div class="item lastchild vertical">
				<h3>Country</h3>
				<p><?php echo (isset($user->country) ? $user->country : '<b>Update country</b>'); ?></p>
			</div>
			<!-- End of User Meta -->
		</div>
		<div class="span4 block">
			<h4>Emergency Contact</h4>
			<!-- Start Emergency Contact -->
			<div class="item firstchild vertical">
				<h3>Full Name</h3>
				<p><?php isset($other->nok_fullname) ? e($other->nok_fullname) : e('(Not available)'); ?></p>
			</div>
			<div class="item vertical">
				<h3>Full Address</h3>
				<p><?php isset($other->nok_full_address) ? e($other->nok_full_address) : e('(Not available)'); ?></p>
			</div>			
			<div class="item lastchild vertical">
				<h3>Mobile/Email</h3>
				<p><?php isset($other->nok_mobile) ? e($other->nok_mobile) : e('(Not available)'); ?></p>
			</div><!-- End of Emergency Contact -->
		</div>
	</div>
</section>
