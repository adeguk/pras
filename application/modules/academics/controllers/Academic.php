<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Academic extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth->restrict('Faculty.Academic.View');

        $this->load->model(array('faculty_model','department_model', 'user_model'));

        $this->load->library('pagination');

        Assets::add_js( js_path() . 'chosen.jquery.min.js' );
        Assets::add_css( css_path() . 'chosen.css'); 
        Assets::add_css( css_path() . 'colorbox.css');
        Assets::add_js( js_path() . 'jquery.colorbox.js' );
        Assets::add_js(js_path().'cb_indoc.js');

        Template::set('toolbar_title', 'Manage Faculty');
        Template::set_block('sub_nav', 'academic/_sub_nav');
    }

    public function index() {

        $faculty = $this->faculty_model->where('faculty.deleted', 0)->find_all();

        Template::set('faculty', $faculty);
        Template::render();
    }


    //to create: form display for new post
    public function create_faculty() {

        $this->auth->restrict('Faculty.Academic.Add', SITE_AREA.'/academic/faculty');

        if ($this->input->post('submit')) {
            if ($this->faculty_model->save_faculty()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'New Faculty created : ' . $this->input->ip_address(), 'faculty');
                Template::set_message('Your Faculty was successfully created.', 'success');
                redirect(SITE_AREA .'/academic/faculty');
            } else {                
                Template::set_message('Your Faculty was not successfully created.', 'error');
                redirect(SITE_AREA .'/academic/faculty');
            }
        }
        
        Template::set('toolbar_title', 'Manage Faculty');
        Template::set_view('academic/create_faculty');
        Template::render();
    }

    //to edit
    public function edit_faculty($id=null)  {

        $this->auth->restrict('Faculty.Academic.Manage', SITE_AREA.'/academic/faculty');

        if ($this->input->post('submit')) {
            if ($this->faculty_model->save_faculty('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Faculty with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'faculty');
                Template::set_message('Your faculty was successfully editted.', 'success');
                redirect(SITE_AREA .'/academic/faculty');
            } else {                
                Template::set_message('Your Faculty was not successfully editted.', 'error');
                redirect(SITE_AREA .'/academic/faculty');
            }
        }

        Template::set('post', $this->faculty_model->find($id));

        Template::set('toolbar_title', 'Manage Faculty');
        Template::set_view('academic/edit_faculty');
        Template::render();
    }

    //Delete existing faculty item
    public function delete() {

        $this->auth->restrict('Faculty.Academic.delete', SITE_AREA.'/academic/faculty');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->faculty_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Faculty with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'faculty');
            }
            Template::set_message('Your faculty was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your faculty was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/academic/faculty');
    }
    //to view
    public function readmore($id=null)  {

        Template::set('readmore', $this->faculty_model->find($id));
        Template::set_view('readmore');
        Template::render('blank');
    }
/****************************DEPARTMENT*****************************************/
    //Department
    public function department()  {

        $offset = $this->uri->segment(5);

        // Search
        $search_term = $this->input->post('search_term');
        $search_terms = array('dept_name'=> $search_term, 'fac_name'=> $search_term);
        
        if ($search_term) {
            $this->department_model->or_like($search_terms);
            Template::set('search_term', $search_term);
        }

        $departments = $this->department_model->limit($this->limit, $offset)->order_by('dept_name', 'ASC')->find_all_by('departments.deleted', 0);

        // Pagination
        $total_departments = $this->department_model->count_all();

        $this->pager['base_url'] = site_url(SITE_AREA .'/academic/faculty/department');
        $this->pager['total_rows'] = $total_departments;
        $this->pager['per_page'] = $this->limit;
        $this->pager['num_links'] = 1;
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);
        // End of Pagination

        Template::set('departments', $departments);
        Template::set('total', $total_departments);
        Template::set('current_url', current_url());
        Template::set('toolbar_title', 'Manage Faculty Department');
		Template::render();
    }

    //to create department: form display for new post
    public function create_department() {

        $this->auth->restrict('Faculty.Academic.Add', SITE_AREA.'/academic/faculty/department');

        if ($this->input->post('submit')) {
            if ($this->department_model->save_department()) {

                // Log the activity
                log_activity($this->auth->user_id(), 'New Department created : ' . $this->input->ip_address(), 'faculty');
                Template::set_message('Your Faculty Department was successfully created.', 'success');
                redirect(SITE_AREA .'/academic/faculty/department');
            } else {                
                Template::set_message('Your Faculty Department was not successfully created.', 'error');
                redirect(SITE_AREA .'/academic/faculty/department');
            }
        }
        $listFaculty = $this->faculty_model->faculty_list();
        Template::set('listFaculty',$listFaculty);

        Template::set('toolbar_title', 'Manage Faculty Department');
        Template::set_view('academic/create_department');
        Template::render();
    }

    //to edit
    public function edit_department($id=null)  {

        $this->auth->restrict('Faculty.Academic.Manage', SITE_AREA.'/academic/faculty/department');

        if ($this->input->post('submit')) {
            if ($this->department_model->save_department('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Department with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'faculty');
                Template::set_message('Your department was successfully editted.', 'success');
                redirect(SITE_AREA .'/academic/faculty/department');
            } else {                
                Template::set_message('YourYour Faculty Department was successfully editted.', 'error');
                redirect(SITE_AREA .'/academic/faculty/department');
            }
        }
        $listFaculty = $this->faculty_model->faculty_list();
        Template::set('listFaculty',$listFaculty);

        Template::set('post', $this->department_model->find($id));
        Template::set('toolbar_title', 'Manage Faculty Department');
        Template::set_view('academic/edit_department');
        Template::render();
    }

    //to view
    public function dreadmore($id=null)  {

        Template::set('readmore', $this->department_model->find($id));
        Template::set_view('readmore');
        Template::render('blank');
    }

    //Delete existing department item
    public function delete_department() {

        $this->auth->restrict('Faculty.Academic.Delete', SITE_AREA.'/academic/faculty/department');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->department_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Department with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'faculty');
            }
            Template::set_message('Your department was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your department was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/academic/faculty/department');
    }
        
    //Export degree data to excel
    public function download_dept(){

        $query = $this->db->select('dept_id, dept_name, fac_name, CONCAT(UCASE(lastname),SPACE(1),(firstname)) AS dept_hod')
                    ->join('faculty', 'faculty.fac_id = departments.fac_id', 'left')
                    ->join('users', 'users.id = departments.dept_hod', 'left');
        $query = $this->db->get('departments');
        
        $delimiter = ",";
        $newline = "\r\n";
        
        // Load the DB utility class
        $this->load->dbutil();
        $downloadfile = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('department.csv', $downloadfile); 
    }
}
