<div class="admin-box">
	<?php  echo '<h3>All University Approved Courses</h3>'; ?>
	
	<table class="table table-striped">
		<thead>			
			<tr>
				<th colspan='4'></th>
				<th colspan='3'>
					<div class="control" style="float:right">
					<?php echo form_open(current_url()) ;?>
						<input type="search" name="search_term" style='margin-bottom: 0;' value="<?php echo set_value('search', isset($post) ? $post->search_term : ''); ?>" 
						placeholder="search course by code or ttile..."  />
						<input type="submit" name="submit" title='Search by course code or course ttile' class="btn" value="Search" />
					<?php echo form_close(); ?>
					</div>
				</th>
			</tr>
			<tr>
				<th>Programme</th>
				<th>Course Title</th>
				<th style="width: 10%">Level</th>
				<th style="width: 10%">Semester</th>
				<th>Course Adviser</th>
				<th style='width:10%'><?php echo lang('us_status'); ?></th>
				<th style='width:5%'></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4"><a class="btn btn-primary" href="<?php echo site_url(SITE_AREA .'/content/course') ?>">Cancel</a></td>				
				<td colspan='3'><?php echo $this->pagination->create_links(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (isset($progSubjects) && is_array($progSubjects)) :
			foreach ($progSubjects as $ps) : ?>
			<tr>
				<td>
				<?php 
					if (isset($ps->course_id)) {
						$progs = $this->programme_model->find_all_by('programme.prog_id', $ps->course_id);
			            foreach($progs as $prog){
			                echo $prog->degreeAbbreviation.' '.$prog->courseName.' - <strong>'.config_item('miscellaneous.duration')[$prog->progDuration].'</strong>';
			           	}
					}
				?>
				</td>				
				<td><?php
                    get_fieldByID('subjectbank_model', $ps->subject_id, 'subjectCode');
                    echo ' - ';
                    get_fieldByID('subjectbank_model', $ps->subject_id, 'subjectTitle');
                ?></td>
				<td><?php $levels=config_item('miscellaneous.level');
                    e($levels[$ps->prog_level]); ?>
                </td>
                <td><?php $semesters=config_item('miscellaneous.semester');
                    e($semesters[$ps->prog_semester]); ?>
                </td>
				<td><?php isset($ps->progUserId) ? listUser_byID($ps->progUserId): 'No User Found!'; ?></td>
				<td><?php 
					$class = '';
					switch ($ps->compulsory) {
						case 1:
							$class = " label-success";
							break;
						case 2:
							$class = " label-info";
							break;
						case 3:
						default:
							$class = " label-error";
							break;
					}
					?>
					<span class="label<?php echo($class); ?>">
					<?php e(config_item('miscellaneous.choice')[$ps->compulsory]); ?>
					</span>
				</td>
				<td><a class='add' href="#" onClick="if(confirm('Are you sure you want to add this course to your registration?'))
window.location = '<?php echo site_url(SITE_AREA."/content/course/add/".$ps->progSubject_id) ?>'; " title='Add to my registration'></a></td>
			</tr>
			<?php endforeach;?>
		<?php else: ?>
			<tr>
				<td colspan="7">No programme subject attached to your choice of programme.</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<!--?php echo form_close(); ?-->
</div>