<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        #Set default restriction to view only for all users with view privilege
        $this->auth->restrict('Academic.Settings.View');
        #Load all required model all at once
        $this->load->model(array('academic_session_model', 'semester_session_model'));

        #Add assets resources for jQuery date picker
        Assets::add_css( array(
            css_path() . 'chosen.css',
            css_path() . 'bootstrap-datepicker.css'
        ));

        Assets::add_js( array(
            js_path() . 'chosen.jquery.min.js',
            js_path() . 'bootstrap-datepicker.js'
        ));

        
        Template::set('toolbar_title', 'Manage Academic Session');
        Template::set_block('sub_nav', 'settings/_sub_nav');

    }

    public function index() {

        $academic_sessions = $this->academic_session_model->find_all_by('academic_session.deleted', 0);

        Template::set('academic_sessions', $academic_sessions);
        Template::render();
    }


    //to create: form display for new academic Session
    public function create_academic_session() {

        $this->auth->restrict('Academic.Settings.Add', SITE_AREA.'/settings/academic');

        if ($this->input->post('submit')) {
            if ($this->academic_session_model->save_session()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'New Academic Session created : ' . $this->input->ip_address(), 'academic');
                Template::set_message('The Academic Session was successfully created.', 'success');
                redirect(SITE_AREA .'/settings/academic');
            }
        }
        
        Template::set_view('settings/create_academic_session');
        Template::render();
    }

    //to edit:
    public function edit_academic_session($id=null)  {

        $this->auth->restrict('Academic.Settings.Manage', SITE_AREA.'/settings/academic');

        if ($this->input->post('submit')) {
            if ($this->academic_session_model->save_session('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Academic Session with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'academic');
                Template::set_message('The academic session was successfully editted.', 'success');
                redirect(SITE_AREA .'/settings/academic');
            }
            else {
                Template::set_message('The academic session was not successfully updated.', 'error');
                redirect(SITE_AREA .'/settings/academic');
            }
        }

        Template::set('post', $this->academic_session_model->find($id));

        Template::set_view('settings/edit_academic_session');
        Template::render();
    }

    //Delete existing academic session item
    public function delete_session() {

        $this->auth->restrict('Academic.Settings.delete', SITE_AREA.'/settings/academic');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->academic_session_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Academic Session with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'academic');
            }
            Template::set_message('The academic session was successfully deleted.', 'success');
        }
        else {
            Template::set_message('The academic session was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/settings/academic');
    }

/****************************Semester Session*****************************************/
    //semester session
    public function semester_session()  {

        Template::set('semester_sessions', $this->semester_session_model->find_all());
		Template::render();
    }

    //to create semester_session: form display for new post
    public function create_semester_session() {

        $this->auth->restrict('Academic.Settings.Add', SITE_AREA.'/settings/academic/semester_session');

        if ($this->input->post('submit')) {
            if ($this->semester_session_model->save_semester_session()) {

                // Log the activity
                log_activity($this->auth->user_id(), 'New semester session created : ' . $this->input->ip_address(), 'academic');
                Template::set_message('The Academic Semester Session was successfully created.', 'success');
                redirect(SITE_AREA .'/settings/academic/semester_session');
            }
        }

        Template::set_view('settings/create_semester_session');
        Template::render();
    }

    //to edit
    public function edit_semester_session($id=null)  {

        $this->auth->restrict('Academic.Settings.Manage', SITE_AREA.'/settings/academic/semester_session');

        if ($this->input->post('submit')) {
            if ($this->semester_session_model->save_semester_session('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Semester Session with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'academic');
                Template::set_message('The Semester Session was successfully editted.', 'success');
                redirect(SITE_AREA .'/settings/academic/semester_session');
            }
            else {
                Template::set_message('The academic session was not successfully updated.', 'error');
                redirect(SITE_AREA .'/settings/academic/semester_session');
            }
        }
        Template::set('post', $this->semester_session_model->find($id));

        Template::set_view('settings/edit_semester_session');
        Template::render();
    }

    //Delete existing semester_session item
    public function delete_semester_session() {

        $this->auth->restrict('Academic.Settings.Delete', SITE_AREA.'/settings/academic/semester_session');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->semester_session_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Semester Session with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'academic');
            }
            Template::set_message('The Semester Session was successfully deleted.', 'success');
        }
        else {
            Template::set_message('The Semester Session was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/settings/academic/semester_session');
    }

}
