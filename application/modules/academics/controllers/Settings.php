<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller {

    protected $permissionCreate = 'Academics.Settings.Create';
    protected $permissionDelete = 'Academics.Settings.Delete';
    protected $permissionEdit   = 'Academics.Settings.Edit';
    protected $permissionView   = 'Academics.Settings.View';

    protected $model = '';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        // Set default restriction to view only for all users with view privilege
        $this->auth->restrict($this->permissionView);

        // Load pagination library
        $this->load->library('pagination');

        // Add assets resources for jQuery date picker
        Assets::add_css( array(
            css_path() . 'chosen.css',
            css_path() . 'bootstrap-datepicker.css',
            css_path() . 'colorbox.css'
        ));

        Assets::add_js( array(
            js_path() . 'chosen.jquery.min.js',
            js_path() . 'bootstrap-datepicker.js',
            js_path() . 'jquery.colorbox.js',
            js_path().'cb_indoc.js'
        ));

        Template::set('toolbar_title', lang('pras_title_academics_manage'));
        Template::set_block('sub_nav', 'settings/_sub_nav');

        //Assets::add_module_js('academics', 'academics.js');
    }

    /**
     * Display a list of Academic Session data.
     *
	 * @param  integer $offset [description]
	 * @return [type]          [description]
     */
    public function index($offset = 0) {
        // Load all required model all at once
        $this->load->model('AcademicSession_Model');
        $offset = $this->uri->segment(5);

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
                    $deleted = $this->AcademicSession_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_session').' : ' .$this->input->ip_address(), 'Academics');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->AcademicSession_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->AcademicSession_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/academics/') . '/';

        $total = $this->AcademicSession_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        // End of Pagination

        Template::set('records', $records);
        Template::set('sessions', config_item('miscellaneous.academic_session'));
        Template::set('studyModes', config_item('miscellaneous.studyMode'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::render();
    }

    /**
     * to create: form display for new academic Session
     * @return [type] [description]
     */
    public function createAcademicSession() {
        // Load all required model all at once
        $this->load->model('AcademicSession_Model');
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->saveData('AcademicSession_Model')) {
                log_activity($this->auth->user_id(), lang('pras_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_create_success'), 'success');

                redirect(SITE_AREA . '/settings/academics');
            }

            // Not validation error
            if ( ! empty($this->AcademicSession_Model->error)) {
                Template::set_message(lang('pras_create_failure') . $this->AcademicSession_Model->error, 'error');
            }
        }

        Template::set('sessions', config_item('miscellaneous.academic_session'));
        Template::set('studyModes', config_item('miscellaneous.studyMode'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_session').': '.lang('pras_create_record'));
        Template::set_view('settings/saveAcademicSession');
        Template::render();
    }

    /**
     * To Edit: form display for new academic Session
     * @return [type] [description]
     */
    public function editAcademicSession()  {
        // Load all required model all at once
        $this->load->model('AcademicSession_Model');

        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('pras_invalid_id'), 'error');
            redirect(SITE_AREA . '/settings/academics');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->saveData('AcademicSession_Model','update', $id)) {
                log_activity($this->auth->user_id(), lang('pras_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_edit_success'), 'success');
                redirect(SITE_AREA . '/settings/academics');
            }

            // Not validation error
            if ( ! empty($this->AcademicSession_Model->error)) {
                Template::set_message(lang('pras_edit_failure') . $this->AcademicSession_Model->error, 'error');
            }
        }

        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->AcademicSession_Model->delete($id)) {
                log_activity($this->auth->user_id(), lang('pras_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_delete_success'), 'success');

                redirect(SITE_AREA . '/settings/academics');
            }

            Template::set_message(lang('pras_delete_failure') . $this->AcademicSession_Model->error, 'error');
        }

        Template::set('post', $this->AcademicSession_Model->find($id));

        Template::set('sessions', config_item('miscellaneous.academic_session'));
        Template::set('studyModes', config_item('miscellaneous.studyMode'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_session').': '.lang('pras_update_record'));
        Template::set_view('settings/saveAcademicSession');
        Template::render();
    }

/****************************Semester Session*****************************************/
    /**
     * Display a list of Semester Session data.
     *
     * @param  integer $offset [description]
     * @return [type]          [description]
     */
    public function semesterSession()  {
        // Load all required model all at once
        $this->load->model(array('AcademicSession_Model','SemesterSession_Model'));
        $offset = $this->uri->segment(5);

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
                    $deleted = $this->SemesterSession_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_semester').' : ' .$this->input->ip_address(), 'Academics');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->SemesterSession_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->SemesterSession_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/academics/semesterSession/') . '/';

        $total = $this->SemesterSession_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        // End of Pagination

        Template::set('records', $records);
        Template::set('semesters', config_item('miscellaneous.semester'));
        Template::set('sessions', config_item('miscellaneous.academic_session'));
        Template::set('studyModes', config_item('miscellaneous.studyMode'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::render();
    }

    /**
     * to create: form display for new academic Session
     * @return [type] [description]
     */
    public function createSemesterSession() {
        // Load all required model all at once
        $this->load->model(array('AcademicSession_Model','SemesterSession_Model'));
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->saveData('SemesterSession_Model')) {
                log_activity($this->auth->user_id(), lang('pras_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_create_success'), 'success');

                redirect(SITE_AREA . '/settings/academics/SemesterSession');
            }

            // Not validation error
            if ( ! empty($this->SemesterSession_Model->error)) {
                Template::set_message(lang('pras_create_failure') . $this->SemesterSession_Model->error, 'error');
            }
        }

        Template::set('semesters', config_item('miscellaneous.semester'));
        Template::set('sessions', config_item('miscellaneous.academic_session'));
        Template::set('studyModes', config_item('miscellaneous.studyMode'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_semester').': '.lang('pras_create_record'));
        Template::set_view('settings/saveSemesterSession');
        Template::render();
    }

    /**
     * To Edit: form display for new academic Session
     * @return [type] [description]
     */
    public function editSemesterSession()  {
        // Load all required model all at once
        $this->load->model(array('AcademicSession_Model','SemesterSession_Model'));

        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('pras_invalid_id'), 'error');
            redirect(SITE_AREA . '/settings/academics/semesterSession');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->saveData('SemesterSession_Model','update', $id)) {
                log_activity($this->auth->user_id(), lang('pras_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_edit_success'), 'success');
                redirect(SITE_AREA . '/settings/academics/semesterSession');
            }

            // Not validation error
            if ( ! empty($this->SemesterSession_Model->error)) {
                Template::set_message(lang('pras_edit_failure') . $this->SemesterSession_Model->error, 'error');
            }
        }

        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->SemesterSession_Model->delete($id)) {
                log_activity($this->auth->user_id(), lang('pras_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_delete_success'), 'success');

                redirect(SITE_AREA . '/settings/academics/semesterSession');
            }

            Template::set_message(lang('pras_delete_failure') . $this->SemesterSession_Model->error, 'error');
        }

        Template::set('post', $this->SemesterSession_Model->find($id));

        Template::set('semesters', config_item('miscellaneous.semester'));
        Template::set('sessions', config_item('miscellaneous.academic_session'));
        Template::set('studyModes', config_item('miscellaneous.studyMode'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_semester').': '.lang('pras_update_record'));
        Template::set_view('settings/saveSemesterSession');
        Template::render();
    }

    /**
     * Display a list of Faculty data.
     *
	 * @param  integer $offset [description]
	 * @return [type]          [description]
     */
    public function faculty($offset = 0) {
        // Load all required model all at once
        $this->load->model('Faculty_Model');
        $offset = $this->uri->segment(5);

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
                    $deleted = $this->Faculty_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_faculty').' : ' .$this->input->ip_address(), 'Academics');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->Faculty_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->Faculty_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/academics/faculty') . '/';

        $total = $this->Faculty_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        // End of Pagination

        Template::set('records', $records);
        Template::set('status', config_item('miscellaneous.status'));
        Template::render();
    }

    /**
     * to create: form display for new academic Session
     * @return [type] [description]
     */
    public function createFaculty() {
        // Load all required model all at once
        $this->load->model('Faculty_Model');
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->saveData('Faculty_Model')) {
                log_activity($this->auth->user_id(), lang('pras_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_create_success'), 'success');

                redirect(SITE_AREA . '/settings/academics/faculty');
            }

            // Not validation error
            if ( ! empty($this->Faculty_Model->error)) {
                Template::set_message(lang('pras_create_failure') . $this->Faculty_Model->error, 'error');
            }
        }

        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_faculty').': '.lang('pras_create_record'));
        Template::set_view('settings/saveFaculty');
        Template::render();
    }

    /**
     * To Edit: form display for new academic Session
     * @return [type] [description]
     */
    public function editFaculty()  {
        // Load all required model all at once
        $this->load->model('Faculty_Model');

        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('pras_invalid_id'), 'error');
            redirect(SITE_AREA . '/settings/academics/faculty');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->saveData('Faculty_Model', 'update', $id)) {
                log_activity($this->auth->user_id(), lang('pras_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_edit_success'), 'success');
                redirect(SITE_AREA . '/settings/academics/faculty');
            }

            // Not validation error
            if ( ! empty($this->Faculty_Model->error)) {
                Template::set_message(lang('pras_edit_failure') . $this->Faculty_Model->error, 'error');
            }
        }

        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->Faculty_Model->delete($id)) {
                log_activity($this->auth->user_id(), lang('pras_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_delete_success'), 'success');

                redirect(SITE_AREA . '/settings/academics/faculty');
            }

            Template::set_message(lang('pras_delete_failure') . $this->Faculty_Model->error, 'error');
        }

        Template::set('post', $this->Faculty_Model->find($id));

        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_faculty').': '.lang('pras_update_record'));
        Template::set_view('settings/saveFaculty');
        Template::render();
    }

    /**
     * Display a list of Department data.
     *
     * @param  integer $offset [description]
     * @return [type]          [description]
     */
    public function department()  {
        // Load all required model all at once
        $this->load->model(array('Faculty_Model','Department_Model'));
        $offset = $this->uri->segment(5);

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
                    $deleted = $this->Department_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_department').' : ' .$this->input->ip_address(), 'Academics');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->Department_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->Department_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/academics/department/') . '/';

        $total = $this->Department_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        // End of Pagination

        Template::set('records', $records);
        Template::set('total_rows', $total);
        Template::set('status', config_item('miscellaneous.status'));
        Template::render();
    }

    /**
     * to create: form display for new academic Session
     * @return [type] [description]
     */
    public function createDepartment() {
        // Load all required model all at once
        $this->load->model(array('Faculty_Model', 'Department_Model'));
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->saveData('Department_Model')) {
                log_activity($this->auth->user_id(), lang('pras_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_create_success'), 'success');

                redirect(SITE_AREA . '/settings/academics/department');
            }

            // Not validation error
            if ( ! empty($this->Department_Model->error)) {
                Template::set_message(lang('pras_create_failure') . $this->Department_Model->error, 'error');
            }
        }

        Template::set('listFaculty', $this->Faculty_Model->facultyList());
        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_department').': '.lang('pras_create_record'));
        Template::set_view('settings/saveDepartment');
        Template::render();
    }

    /**
     * To Edit: form display for new academic Session
     * @return [type] [description]
     */
    public function editDepartment()  {
        // Load all required model all at once
        $this->load->model(array('Faculty_Model', 'Department_Model'));

        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('pras_invalid_id'), 'error');
            redirect(SITE_AREA . '/settings/academics/department');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->saveData('Department_Model', 'update', $id)) {
                log_activity($this->auth->user_id(), lang('pras_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_edit_success'), 'success');
                redirect(SITE_AREA . '/settings/academics/department');
            }

            // Not validation error
            if ( ! empty($this->Department_Model->error)) {
                Template::set_message(lang('pras_edit_failure') . $this->Department_Model->error, 'error');
            }
        }

        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->Department_Model->delete($id)) {
                log_activity($this->auth->user_id(), lang('pras_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'Academics');
                Template::set_message(lang('pras_delete_success'), 'success');

                redirect(SITE_AREA . '/settings/academics/department');
            }

            Template::set_message(lang('pras_delete_failure') . $this->Department_Model->error, 'error');
        }

        Template::set('post', $this->Department_Model->find($id));
        Template::set('listFaculty', $this->Faculty_Model->facultyList());
        Template::set('status', config_item('miscellaneous.status'));
        Template::set('subHeader', lang('pras_field_department').': '.lang('pras_update_record'));
        Template::set_view('settings/saveDepartment');
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function saveData($model, $type = 'insert', $id = 0) {
        if ($type == 'update')  $_POST['id'] = $id;

        // Validate the data
        $this->form_validation->set_rules($this->$model->get_validation_rules());
        if ($this->form_validation->run() === false) return false;

        // Make sure we only pass in the fields we want
        $data = $this->$model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method

        $return = false;
        if ($type == 'insert') {
            $id = $this->$model->insert($data);

            if (is_numeric($id)) $return = $id;
        } elseif ($type == 'update') {
            $return = $this->$model->update($id, $data);
        }

        return $return;
    }
}
