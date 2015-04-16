<div class="admin-box">
	<?php  echo '<h3>'.$currentSemester.' Course Registration, '.$currentSession.' </b> Session</h3>'; ?>
	
	<!--?php echo form_open(current_url()) ;?-->

	<table class="table table-striped">
		<thead>
			<tr>
				<!--th class="column-check"><input class="check-all" type="checkbox" /></th-->
				<th>Course Title</th>
				<th style='width:15%'>Unit</th>
				<th style='width:20%'><?php echo lang('us_status'); ?></th>
				<th style='width:5%'>&nbsp;</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td>
					<?php if ($submitted != NULL) {
						echo '<a class="btn" href="'.site_url(SITE_AREA.'/content/course/reverseRegistration/'.$submitted->regSub_id).'" > Reverse Registration</a>';
					} elseif (isset($course_reg) && is_array($course_reg) && ($submitted == NULL)) {
						echo '<a class="btn btn-success" href="'.site_url(SITE_AREA.'/content/course/registerCourse/'.$student->studentID).'" >Register</a> ';
						echo '<a class="btn btn-warning" href="'.site_url(SITE_AREA.'/content/course/resetRegistration/'.$student->studentID).'" > Reset</a>';
					} else {
					    echo "";
					} ?>				
				</td>
				<td colspan="3">
				<?php if (isset($course_reg) && is_array($course_reg)) : ?>
				<?php 
					$unit_id = $this->prog_semester_unit_model->where(array('prog_id'=>$student->prog_id, 'progLevel'=>$student->level ))->find_by('progSemester',$semester);
					if (isset($unit_id) && $unit_id != NULL){
						$maxUnit = config_item('miscellaneous.totalUnit')[$unit_id->maximumUnit];
					} else {
						$maxUnit = '<b>[Not Set]</b>';
					}

					if (isset($course_reg) && is_array($course_reg)){
						foreach ($course_reg as $ps){
		                	$unit_id = $ps->subjectUnit;
				            $units = config_item('miscellaneous.unit');
				            preg_match('/(\d+)/', $units[$unit_id], $matches );
				            $Selected[] = $matches[0];
		                	
			                $totalSelectedUnit = array_sum($Selected);
						}
					} else {
						$totalSelectedUnit = '<b><i>[No course added]</i></b>';
					}
				?>
					<b>Total Unit Selected: <?php echo $totalSelectedUnit; ?></b> <i>of Maximum Unit: <?php echo $maxUnit; ?></i>	
                </td>			
            <?php endif; ?>
            </tr>
		</tfoot>
		<tbody>
		<?php if (isset($course_reg) && is_array($course_reg)) : ?>
			<?php foreach ($course_reg as $ps) : ?>
			<tr>
				<td><?php e($ps->subjectCode .' - '. $ps->subjectTitle); ?></td>
                <td><?php e(config_item('miscellaneous.unit')[$ps->subjectUnit]); ?></td>
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
					} ?>
					<span class="label<?php echo($class); ?>">
					<?php e(config_item('miscellaneous.choice')[$ps->compulsory]); ?>
					</span>
				</td>
				<td><?php if ($submitted == NULL) : ?>
					<a class="delete" href="#" onClick="if(confirm('Are you sure you want to remove this course?'))
window.location = '<?php echo site_url(SITE_AREA."/content/course/delete/".$ps->courseReg_id) ?>'; "></a>
					<?php endif ?>
				</td>
			</tr>
			<?php endforeach;?>
		<?php else: ?>
			<tr>
				<td colspan="4">No Course Title found. Please contact your Course Adviser!</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<!--?php echo form_close(); ?-->
</div>