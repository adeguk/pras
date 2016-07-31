<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller {
    protected $permissionCreate = 'Student_manager.Content.Create';
    protected $permissionDelete = 'Student_manager.Content.Delete';
    protected $permissionEdit   = 'Student_Manager.Content.Edit';
    protected $permissionView   = 'Student_manager.Content.View';

	public function __construct() {
        parent::__construct();

		$this->auth->restrict($this->permissionView);
        $this->lang->load('student_manager');

        $this->load->model('student_model');

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

        Template::set('toolbar_title', lang('student_manager'));
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_css(array(
            'chosen.css',
            'bootstrap-datepicker.css',
            'colorbox.css'));
        Assets::add_js(array(
            'chosen.jquery.min.js',
            'jquery.colorbox.js',
            'bootstrap-datepicker.js',));
        Assets::add_module_js('users', 'user.js');
        Assets::add_module_js('student_manager', 'student_manager.js');
    }

	/**
	 * Display and manager lists of all students
	 * @param  integer $offset [description]
	 * @return [type]          [description]
	 */
	public function index ($offset = 0) {
		$this->load->model('studentView_model');

        // Deleting anything?
        if (isset($_POST['delete'])) {
           $this->auth->restrict($this->permissionDelete);
           $checked = $this->input->post('checked');

           if (is_array($checked) && count($checked)) {

              // If any of the deletions fail, set the result to false, so
              // failure message is set if any of the attempts fail, not just
              // the last attempt

              $result = true;

              foreach ($checked as $pid) {
                 $deleted = $this->student_model->delete($pid);
                    if ($deleted == false) {
                       $result = false;
                    }
              }

              if ($result) {
                 // Log the activity
                 log_activity($this->auth->user_id(), 'Student deleted : ' . $this->input->ip_address(), 'student_manager');
                 Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
              } else {
                 Template::set_message(lang('pras_delete_failure') . $this->student_model->error, 'error');
              }
           }
        }

		$faculties = $this->studentView_model->get_students_faculties();
		Template::set('faculties', $faculties);

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

        $search_term = $this->input->post('search_term');
        if ($search_term) {
            $search_terms = array('firstname'=>$search_term,'middlename'=>$search_term,'lastname'=>$search_term, 'matricNo'=>$search_term, 'jamb_reg'=>$search_term);
            $this->studentView_model->or_like($search_terms);
        }

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
					if ($faculty->id == $fac_id) {
						Template::set('filter_faculty', $faculty->fac_name);
						break;
					}
				}
				break;
			default:
				$this->studentView_model->where('studentView.deleted', 0);
				break;
		}

        $this->load->helper('ui/ui');

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->studentView_model->limit($limit, $offset)->where($where);
		$records = $this->studentView_model->find_all();

        $this->load->library('pagination');
		$pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/student_manager') . '/';

        $total_students = $this->studentView_model->where($where)->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total_students;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);

		Template::set('records', $records);
		Template::set('total', $total_students);
		Template::set('current_url', current_url());
		Template::set('filter', $filter);

		Template::render();
	}
    /*
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
    */
    //to delete
    /*    public function delete()  {

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
    */
	/*--------------------------------------------------------------------
	/	PRIVATE FUNCTIONS
	/-------------------------------------------------------------------*/
	private function change_status($checked = false, $status_id = 1) {
        $this->auth->restrict($this->permissionEdit);

		if ($checked === false) {
			return;
		}

        $result = true;

        foreach ($checked as $id) {
            #$changed = $this->student_model->update($id, array('status'=>$status_id));

            $changed = $this->db->query("UPDATE bf_students SET status = $status_id WHERE id = $id");

            if ($changed == false) {
                $result = false;
            }
		}

        if ($result) {
             // Log the activity
            log_activity($this->auth->user_id(), 'Student status changed : ' . $this->input->ip_address(), 'student_manager');
            Template::set_message(count($checked) . ' Student status change successfully', 'success');
        } else {
            Template::set_message('Cannot change Student status' . $this->student_model->error, 'error');
        }
	}
}

/* End of file Content.php */
/* Location: ./module/student_manager/controllers/Content.php */
