<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth->restrict('Course.Settings.View');

        $this->load->model(array('prog_semester_unit_model', 'programme_model', 'degree_model', 'coursebank_model'));

        // Pagination
        $this->load->library('pagination');

        Assets::add_css( css_path() . 'chosen.css');
        Assets::add_js( js_path() . 'chosen.jquery.min.js' );

        Template::set('toolbar_title', 'Manage Programme Semester Unit');
        Template::set_block('sub_nav', 'settings/_sub_nav');
    }

    public function index() {

        $offset = $this->uri->segment(5);

        $psUnits = $this->prog_semester_unit_model->limit($this->limit, $offset)->find_all();

        // Pagination
        $total_psUnits = $this->prog_semester_unit_model->count_all();

        $this->pager['base_url'] = site_url(SITE_AREA .'/settings/course/index');
        $this->pager['total_rows'] = $total_psUnits;
        $this->pager['per_page'] = $this->limit;
        $this->pager['num_links'] = 1;
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);
        // End of Pagination

        Template::set('psUnits', $psUnits);
        Template::render();
    }

    //to create: form display for new programme semester unit
    public function create() {

        $this->auth->restrict('Course.Settings.Add', SITE_AREA.'/settings/course');

        if ($this->input->post('submit')) {
            if ($this->prog_semester_unit_model->save_progSU()) {
                // Log the activity
                #log_activity($this->auth->user_id(), 'New Course created in Course Bank : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your programme semester unit was successfully created.', 'success');
                redirect(SITE_AREA .'/settings/course');
            }
        }

        Template::set('toolbar_title', 'Manage Programme Semester Unit');
        Template::set_view('settings/create_psu');
        Template::render();
    }

    //to edit
    public function edit($id=null)  {

        $this->auth->restrict('Course.Settings.Manage', SITE_AREA.'/settings/course');

        if ($this->input->post('submit')) {
            if ($this->prog_semester_unit_model->save_progSU('update', $id)) {

                // Log the activity
                #log_activity($this->auth->user_id(), 'Course with ID: '. $id . ' modified in Course Bank : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your programme semester unit was successfully editted.', 'success');
                redirect(SITE_AREA .'/settings/course');
            }
        }

        Template::set('post', $this->prog_semester_unit_model->find($id));
        Template::set('toolbar_title', 'Manage Programme Semester Unit');
        Template::set_view('settings/edit_psu');
        Template::render();
    }

    //to delete
    public function delete()  {

        $this->auth->restrict('Course.Settings.Delete', SITE_AREA.'/settings/course');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->prog_semester_unit_model->delete($id);

                // Log the activity
                #log_activity($this->auth->user_id(), 'Course with ID: '. $id . ' deleted from Course Bank : ' . $this->input->ip_address(), 'course');
            }
            Template::set_message('Your programme semester unit was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your programme semester unit was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/settings/course');
    }
}
