<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Academic extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth->restrict('Course.Academic.View');

        //Other required model
        $this->load->model('faculty/department_model');

        // Pagination
        $this->load->library('pagination');

        Assets::add_css( css_path() . 'chosen.css');
        Assets::add_js( js_path() . 'chosen.jquery.min.js' );

        Template::set('toolbar_title', 'Manage Course Bank');
        Template::set_block('sub_nav', 'academic/_sub_nav');
    }

    public function index() {
        $this->load->model('coursebank_model');

        $offset = $this->uri->segment(5);
        
        $search_term = $this->input->post('search_term');
        $search_terms = array('courseName'=> $search_term, 'dept_name'=>$search_term);
        if ($search_term) {
            $this->programme_model->or_like($search_terms);
            Template::set('search_term', $search_term);
        }

        $courses = $this->coursebank_model->limit($this->limit, $offset)->order_by('courseName','ASC')->find_all_by('coursebank.deleted', 0);

        // Pagination
        $total_courses = $this->coursebank_model->count_all();

        $this->pager['base_url'] = site_url(SITE_AREA .'/academic/course/index');
        $this->pager['total_rows'] = $total_courses;
        $this->pager['per_page'] = $this->limit;
        $this->pager['num_links'] = 1;
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);
        // End of Pagination

        Template::set('courses', $courses);
        Template::set('total', $total_courses);
        Template::set('current_url', current_url());
        Template::render();
    }

    //to create: form display for new post
    public function create_course() {
        $this->load->model('coursebank_model');

        $this->auth->restrict('Course.Academic.Add', SITE_AREA.'/academic/course');

        if ($this->input->post('submit')) {
            if ($this->coursebank_model->save_course()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'New Course created in Course Bank : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your Course was successfully created.', 'success');
                redirect(SITE_AREA .'/academic/course');
            }
        }
        $listDepartment = $this->department_model->department_list();
        Template::set('listDepartment',$listDepartment);

        Template::set('toolbar_title', 'Manage Course Bank');
        Template::set_view('academic/create_course');
        Template::render();
    }

    //to edit
    public function edit_course($id=null)  {
        $this->load->model('coursebank_model');

        $this->auth->restrict('Course.Academic.Manage', SITE_AREA.'/academic/course');

        if ($this->input->post('submit')) {
            if ($this->coursebank_model->save_course('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Course with ID: '. $id . ' modified in Course Bank : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your course was successfully editted.', 'success');
                redirect(SITE_AREA .'/academic/course');
            }
        }
        $listDepartment = $this->load->Model('faculty/department_model')->department_list();
        Template::set('listDepartment',$listDepartment);

        Template::set('post', $this->coursebank_model->find($id));
        Template::set('toolbar_title', 'Manage Course Bank');
        Template::set_view('academic/edit_course');
        Template::render();
    }

    //to delete
    public function delete_course()  {
        $this->load->model('coursebank_model');

        $this->auth->restrict('Course.Academic.Delete', SITE_AREA.'/academic/course');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->coursebank_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Course with ID: '. $id . ' deleted from Course Bank : ' . $this->input->ip_address(), 'course');
            }
            Template::set_message('Your course was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your course was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/academic/course');
    }

    //Degree
    public function degree()  {
        $this->load->model('degree_model');

        $degrees = $this->degree_model->where('deleted', 0)->find_all();

        Template::set('degrees', $degrees);
        Template::set('toolbar_title', 'Manage Study Programme');
        Template::render();
    }

    //to create: form display for new degree
    public function create_degree() {
        $this->load->model('degree_model');

        $this->auth->restrict('Course.Academic.Add', SITE_AREA.'/academic/course/degree');

        if ($this->input->post('submit')) {
            if ($this->degree_model->save_degree()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'Degree with ID: '. $id . ' created : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your Degree was successfully created.', 'success');
                redirect(SITE_AREA .'/academic/course/degree');
            }
        }

        Template::set('toolbar_title', 'Manage Study Programme');
        Template::set_view('academic/create_degree');
        Template::render();
    }

    //to edit
    public function edit_degree($id=null)  {
        $this->load->model('degree_model');

        $this->auth->restrict('Course.Academic.Manage', SITE_AREA.'/academic/course/degree');

        if ($this->input->post('submit')) {
            if ($this->degree_model->save_degree('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Degree with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your degree was successfully editted.', 'success');
                redirect(SITE_AREA .'/academic/course/degree');
            }
        }

        Template::set('post', $this->degree_model->find($id));
        Template::set('toolbar_title', 'Manage Study Programme');
        Template::set_view('academic/edit_degree');
        Template::render();
    }

    //to delete
    public function delete_degree()  {
        $this->load->model('degree_model');

        $this->auth->restrict('Course.Academic.Delete', SITE_AREA.'/academic/course/degree');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->degree_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Degree with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'course');
            }
            Template::set_message('Your degree was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your degree was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/academic/course/degree');
    }

    //Programme
    public function programme()  {
        $this->load->model('programmeView_model');

        $offset = $this->uri->segment(5);
        
        $search_term = $this->input->post('search_term');
        $search_terms = array('programme'=> $search_term, 'department'=>$search_term, 'faculty'=>$search_term);
        if ($search_term) {
            $this->programmeView_model->or_like($search_terms);
            Template::set('search_term', $search_term);
        }

        $programmes = $this->programmeView_model->limit($this->limit, $offset)->order_by('progCode','ASC')->find_all();

        // Pagination
        $total_programmes = $this->programmeView_model->count_all();

        $this->pager['base_url'] = site_url(SITE_AREA .'/academic/course/programme');
        $this->pager['total_rows'] = $total_programmes;
        $this->pager['per_page'] = $this->limit;
        $this->pager['num_links'] = 1;
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);
        // End of Pagination

        Template::set('programmes', $programmes);
        Template::set('total', $total_programmes);
        Template::set('toolbar_title', 'Manage Study Programme');
        Template::render();
    }

    //to create: form display for new programme
    public function create_programme() {
        $this->load->model(array('coursebank_model','degree_model', 'programme_model'));

        $this->auth->restrict('Course.Academic.Add', SITE_AREA.'/academic/course/programme');

        if ($this->input->post('submit')) {
            if ($this->programme_model->save_programme()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'New Programme created : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your programme was successfully created.', 'success');
                redirect(SITE_AREA .'/academic/course/programme');
            }
            else {
                Template::set_message('Your programme was not successfully created.', 'error');
                redirect(SITE_AREA .'/academic/course/programme');
            }
        }

        Template::set('listCourseBank',$this->coursebank_model->coursebank_list());
        Template::set('listDegree',$this->degree_model->degree_list());
        Template::set('listDepartment',$this->department_model->department_list());

        Template::set('toolbar_title', 'Manage Study Programme');
        Template::set_view('academic/create_programme');
        Template::render();
    }

    //to edit
    public function edit_programme($id=null)  {
        $this->load->model(array('coursebank_model','degree_model', 'programme_model'));

        $this->auth->restrict('Course.Academic.Manage', SITE_AREA.'/academic/course/programme');

        if ($this->input->post('submit')) {
            if ($this->programme_model->save_programme('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Programme with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'course');
                Template::set_message('Your programme was successfully editted.', 'success');
                redirect(SITE_AREA .'/academic/course/programme');
            }
        }

        Template::set('listCourseBank',$this->coursebank_model->coursebank_list());
        Template::set('listDegree',$this->degree_model->degree_list());
        Template::set('listDepartment',$this->department_model->department_list());

        Template::set('post', $this->programme_model->find_by('prog_id',$id));
        Template::set('toolbar_title', 'Manage Study Programme');
        Template::set_view('academic/edit_programme');
        Template::render();
    }

    //to delete
    public function delete_programme()  {
        $this->load->model(array('coursebank_model','degree_model'));

        $this->auth->restrict('Course.Academic.Delete', SITE_AREA.'/academic/course/programme');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->programme_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Programme with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'course');
            }
            Template::set_message('Your programme was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your programme was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/academic/course/programme');
    }

    //Export degree data to excel
    public function download_degree(){

        $column = 'degreeAbbreviation, degreeName';
        $table = 'degree';

        // download to excel
        toExcel($table, $column, $table);
    }
    
    //Export degree data to excel
    public function download_programme(){

        $query = $this->db->select('degreeName, courseName, departments.dept_id, dept_name, studyMode')
                    ->join('coursebank', 'coursebank.course_id = programme.course_id', 'left')
                    ->join('degree', 'degree.deg_id = programme.deg_id', 'left')
                    ->join('departments', 'departments.dept_id = programme.dept_id', 'left');
        $query = $this->db->get('programme');
        
        $delimiter = ",";
        $newline = "\r\n";
        
        // Load the DB utility class
        $this->load->dbutil();
        $downloadfile = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('programme.csv', $downloadfile); 
    }
    
    //Export degree data to excel
    public function download_cbank(){

        $query = $this->db->select('courseName, departments.dept_id, dept_name')
                    ->join('departments', 'departments.dept_id = coursebank.dept_id', 'left');
        $query = $this->db->get('coursebank');
        
        $delimiter = ",";
        $newline = "\r\n";
        
        // Load the DB utility class
        $this->load->dbutil();
        $downloadfile = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('course_bank.csv', $downloadfile); 
    }
}
