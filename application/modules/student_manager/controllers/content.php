<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller {

	public function __construct() {
        parent::__construct();

		$this->auth->restrict('Student_Manager.Content.View');

		$this->load->model(array('student_model', 'studentView_model', 'course/programme_model', 
		'faculty/faculty_model', 'faculty/department_model', 'course/degree_model', 'course/coursebank_model'));

		$this->load->library('pagination');

        Assets::add_css( css_path() . 'chosen.css');
        Assets::add_js( js_path() . 'chosen.jquery.min.js' );

        Template::set('toolbar_title', 'Student Manager');
        Template::set_block('sub_nav', 'content/_sub_nav');
    }

	public function index() {
		
		$faculties = $this->studentView_model->get_students_faculties();
		Template::set('faculties', $faculties);
		
		$departments = $this->studentView_model->get_students_departments();
		Template::set('departments', $departments);

		$levels = config_item('miscellaneous.level');
		Template::set('levels', $levels);

		$studyModes=config_item('miscellaneous.studyMode');
		Template::set('studyModes', $studyModes);

		$offset = $this->uri->segment(5);

		// Do we have any actions?
		if ($action = $this->input->post('submit'))	{
			$isChecked = $this->input->post('checked');

			switch(strtolower($action)) {
				case 'current':
					$this->change_status($isChecked, 1);
					break;
				case 'alumni':
					$this->change_status($isChecked, 2);
					break;
				case 'spill':
					$this->change_status($isChecked, 3);
					break;
				case 'suspend':
					$this->change_status($isChecked, 4);
					break;
				case 'leave':
					$this->change_status($isChecked, 5);
					break;
				case 'rusticate':
					$this->change_status($isChecked, 6);
					break;
				case 'delete':
					$this->delete($isChecked);
					break;
			}
		}

		$where = array();

		// Filters
		$filter = $this->input->get('filter');
		switch($filter) {
			case 'alumni':
				$where['studentView.status'] = 2;
				break;
			case 'spilled':
				$where['studentView.status'] = 3;
				break;
			case 'deleted':
				$where['studentView.deleted'] = 1;
				break;
			case 'suspended':
				$where['studentView.status'] = 4;
				break;
			case 'leave':
				$where['studentView.status'] = 5;
				break;
			case 'rusticated':
				$where['studentView.status'] = 6;
				break;
			case 'studyMode':
				$studymode_id = (int)$this->input->get('key');
				$where['studentView.studyMode'] = $studymode_id;

				foreach ($studyModes as $key=>$name) {
					if ($key == $studymode_id) {
						Template::set('filter_studymode', $name);
						break;
					}
				}
				break;
			case 'faculty':
				$fac_id = (int)$this->input->get('fac_id');
				$where['studentView.fac_id'] = $fac_id;

				foreach ($faculties as $faculty) {
					if ($faculty->fac_id == $fac_id) {
						Template::set('filter_faculty', $faculty->fac_name);
						break;
					}
				}
				break;			
			/*case 'department':
				$dept_id = (int)$this->input->get('dept_id');
				$where['studentView.dept_id'] = $dept_id;

				foreach ($departments as $department) {
					if ($department->dept_id == $dept_id) {
						Template::set('filter_department', $department->dept_name);
						break;
					}
				}
				break;*/
			case 'level':
				$level_id = (int)$this->input->get('level');
				$where['studentView.level'] = $level_id;

				foreach ($levels as $key=>$name) {
					if ($key == $level_id) {
						Template::set('filter_level', $name);
						break;
					}
				}
				break;
			default:
				//$where['students.deleted'] = 0;
				$this->studentView_model->where('studentView.deleted', 0);
				//$this->student_model;
				break;
		}

		$search_term = $this->input->post('search_term');
		$search_terms = array('fullname'=>$search_term, 'matricNo'=>$search_term, 'jamb_reg'=>$search_term );
		if ($search_term) {
			$this->studentView_model->or_like($search_terms);
			Template::set('search_term', $search_term);
		}

		$this->load->helper('ui/ui');

		$this->studentView_model->limit($this->limit, $offset)->where($where);
		$this->studentView_model;

		Template::set('students', $this->studentView_model->find_all());

		// Pagination
		$this->load->library('pagination');

		$this->studentView_model->where($where);
		$total_students = $this->studentView_model->count_all();

		$this->pager['base_url'] = site_url(SITE_AREA .'/content/student_manager/index');
		$this->pager['total_rows'] = $total_students;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 5;

		$this->pagination->initialize($this->pager);

		Template::set('total', $total_students);
		Template::set('current_url', current_url());
		Template::set('filter', $filter);

		Template::render();
	}

	public function create() {
		$this->auth->restrict('Student_Manager.Content.Add', SITE_AREA.'/content/student_manager');

        if ($this->input->post('submit')) {
            if ($this->student_model->save_student()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'New student details created : ' . $this->input->ip_address(), 'student_manager');
                Template::set_message('Your student details was successfully created.', 'success');
                redirect(SITE_AREA .'/content/student_manager');
            } 
        }
        
        //set array of available faculties and departments
        Template::set('listFaculty', $this->faculty_model->faculty_list());
        Template::set('listDepartment', $this->department_model->department_list());
        
        Template::set_view('content/create');
        Template::render();
	}

	//to edit
    public function edit($id=null)  {

        $this->auth->restrict('Student_Manager.Content.Manage', SITE_AREA.'/content/student_manager');

        if ($this->input->post('submit')) {
            if ($this->student_model->save_student('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'student with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'student_manager');
                Template::set_message('Your student details was successfully editted.', 'success');
                redirect(SITE_AREA .'/content/student_manager');
            }
        }
        
        //set array of available faculties and departments
        Template::set('listFaculty', $this->faculty_model->faculty_list());
        Template::set('listDepartment', $this->department_model->department_list());

        Template::set('post', $this->student_model->find($id));

        Template::set_view('content/edit');
        Template::render();
    }

    //to delete
    public function delete()  {

        $this->auth->restrict('Student_Manager.Content.Delete', SITE_AREA.'/content/student_manager');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->student_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Student with ID: '. $id . ' deleted from Student Bank : ' . $this->input->ip_address(), 'student_manager');
            }
            Template::set_message('Student was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Student was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/content/student_manager');
    }

	/*--------------------------------------------------------------------
	/	PRIVATE FUNCTIONS
	/-------------------------------------------------------------------*/
	private function change_status($checked = false, $status_id = 1) {
		if ($checked === false) {
			return;
		}
        $this->auth->restrict('Student_Manager.Content.Manage');
        foreach ($checked as $student_id) {
			$this->student_model->update($student_id,array('status'=>$status_id));
		}
	}
}

/* End of file Content.php */
/* Location: ./module/student_manager/controllers/Content.php */
