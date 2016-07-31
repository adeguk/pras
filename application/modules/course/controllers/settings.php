<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller {

    protected $permissionCreate = 'Course.Settings.Create';
    protected $permissionDelete = 'Course.Settings.Delete';
    protected $permissionEdit   = 'Course.Settings.Edit';
    protected $permissionView   = 'Course.Settings.View';

    protected $model = '';
    //protected $modelArray = array();

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

        Template::set('toolbar_title', lang('pras_title_coursemanage'));
        Template::set_block('sub_nav', 'settings/_sub_nav');
    }
    /**
     * index display the list of available programs as the index of course Settings and Management
     * @return [type] [description]
     */
    public function index() {
        // Load all required model all at once
        $this->load->model(array('Degree_Model','CourseBank_Model','Programme_Model','ProgrammeView_Model'));
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
                    $deleted = $this->Programme_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }

                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_program').' : ' .$this->input->ip_address(), 'Course');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->Programme_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->ProgrammeView_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/course/') . '/';

        $total = $this->ProgrammeView_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        //use pagination

        Template::set('records', $records);
        Template::set('total_rows', $total);
        Template::set('levels', config_item('miscellaneous.level'));
        Template::set('studyModes', config_item('miscellaneous.studyMode'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::render();
    }

    public function degree() {
        // Load all required model all at once
        $this->load->model('Degree_Model');
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
                    $deleted = $this->Degree_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }

                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_degree').' : ' .$this->input->ip_address(), 'Course');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->Degree_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->Degree_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/course/') . '/';

        $total = $this->Degree_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        //use pagination

        Template::set('records', $records);
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

    public function courseBank() {
        // Load all required model all at once
        $this->load->model(array('CourseBank_Model', 'academics/Department_Model'));
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
                    $deleted = $this->CourseBank_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }

                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_courseBank').' : ' .$this->input->ip_address(), 'Course');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->CourseBank_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->CourseBank_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/course/') . '/';

        $total = $this->CourseBank_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        //use pagination

        Template::set('records', $records);
        Template::set('status', config_item('miscellaneous.status'));
        Template::render();
    }

    public function programmeUnit() {
        // Load all required model all at once
        $this->load->model(array('ProgrammeUnit_Model','ProgrammeView_Model'));
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
                    $deleted = $this->ProgrammeUnit_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }

                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_unit').' : ' .$this->input->ip_address(), 'Course');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->ProgrammeUnit_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->ProgrammeUnit_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/course/') . '/';

        $total = $this->ProgrammeUnit_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        //use pagination

        Template::set('records', $records);
        Template::set('total_rows', $total);
        Template::set('semesters', config_item('miscellaneous.semester'));
        Template::set('levels', config_item('miscellaneous.level'));
        Template::set('durations', config_item('miscellaneous.duration'));
        Template::set('units', config_item('miscellaneous.unit'));
        Template::set('status', config_item('miscellaneous.status'));
        Template::render();
    }

    public function courseRegistration() {
        // Load all required model all at once
        $this->load->model('CourseRegistration_Model');
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
                    $deleted = $this->CourseRegistration_Model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }

                if ($result) {
                    // Log the activity
                    log_activity($this->auth->user_id(), ' deletes : ' .lang('pras_field_courseRegistration').' : ' .$this->input->ip_address(), 'Course');
                    Template::set_message(count($checked) . ' ' . lang('pras_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pras_delete_failure') . $this->CourseRegistration_Model->error, 'error');
                }
            }
        }

        // Start pagination process
        $this->load->helper('ui/ui');
		$pagerUriSegment = 5;
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;
        $records = $this->CourseRegistration_Model->limit($limit, $offset)->find_all();
        $pagerBaseUrl = site_url(SITE_AREA . '/settings/course/') . '/';

        $total = $this->CourseRegistration_Model->count_all();

        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $total;
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        //use pagination

        Template::set('records', $records);
        Template::set('semester', config_item('miscellaneous.semester'));
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
