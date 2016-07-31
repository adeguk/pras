<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Academic extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        // Pagination
        $this->load->library('pagination');

        Assets::add_css( css_path() . 'chosen.css');
        Assets::add_js( js_path() . 'chosen.jquery.min.js' );

        Template::set('toolbar_title', 'Manage Subject Bank');
        Template::set_block('sub_nav', 'academic/_sub_nav');

    }

    //--------------------------------------------------------------------

    public function index() {
        $this->load->model('subjectbank_model');

        $offset = $this->uri->segment(5);
        // Search
        $search_term = $this->input->post('search_term');
        $search_terms = array('subjectCode'=> $search_term, 'subjectTitle'=> $search_term);
        
        if ($search_term) {
            $this->subjectbank_model->or_like($search_terms);
            Template::set('search_term', $search_term);
        }

        $subjects = $this->subjectbank_model->limit($this->limit, $offset)->where('subjectBanks.deleted', 0)->find_all();

        // Pagination
        $total_subjects = $this->subjectbank_model->count_all();

        $this->pager['base_url'] = site_url(SITE_AREA .'/academic/subject/index');
        $this->pager['total_rows'] = $total_subjects;
        $this->pager['per_page'] = $this->limit;
        $this->pager['num_links'] = 1;
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);
        // End of Pagination

        Template::set('subjects', $subjects);
        Template::set('total', $total_subjects);
        Template::set('current_url', current_url());
        Template::render();
    }

    //to create: form display for new post
    public function create_subject() {
        $this->load->model('subjectbank_model');

        $this->auth->restrict('Subject.Academic.Add', SITE_AREA.'/academic/subject');

        if ($this->input->post('submit')) {
            if ($this->subjectbank_model->save_subject()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'New Subject created in Subject Bank : ' . $this->input->ip_address(), 'subject');
                Template::set_message('Your Course Title was successfully created.', 'success');
                redirect(SITE_AREA .'/academic/subject');
            }
        }

        Template::set('toolbar_title', 'Manage Subject Bank');
        Template::set_view('academic/create_subject');
        Template::render();
    }

    //to edit
    public function edit_subject($id=null)  {
        $this->load->model('subjectbank_model');

        $this->auth->restrict('Subject.Academic.Manage', SITE_AREA.'/academic/subject');

        if ($this->input->post('submit')) {
            if ($this->subjectbank_model->save_subject('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Subject with ID: '. $id . ' modified in Subject Bank : ' . $this->input->ip_address(), 'subject');
                Template::set_message('Your course Title was successfully editted.', 'success');
                redirect(SITE_AREA .'/academic/subject');
            }
        }

        Template::set('post', $this->subjectbank_model->find($id));
        Template::set('toolbar_title', 'Manage Subject Bank');
        Template::set_view('academic/edit_subject');
        Template::render();
    }

    //to delete
    public function delete_subject()  {
        $this->load->model('subjectbank_model');

        $this->auth->restrict('Subject.Academic.Delete', SITE_AREA.'/academic/subject');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->subjectbank_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Subject with ID: '. $id . ' deleted from Subject Bank : ' . $this->input->ip_address(), 'subject');
            }
            Template::set_message('Your Course Title was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your course was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/academic/subject');
    }

    //Programme
    public function programme_subject()  {
        $this->load->model('programmeSubjectView_model');

        $offset = $this->uri->segment(5);
        
        $search_term = $this->input->post('search_term');
        $search_terms = array('courseTitle'=> $search_term, 'department'=>$search_term, 'faculty'=>$search_term);
        if ($search_term) {
            $this->programmeSubjectView_model->or_like($search_terms);
            Template::set('search_term', $search_term);
        }

        $this->load->helper('ui/ui');

        $this->programmeSubjectView_model->limit($this->limit, $offset);
        $this->programmeSubjectView_model->select();
        Template::set('progSubjects', $this->programmeSubjectView_model->find_all());

        // Pagination
        //$this->programmesubject_model;
        $total_progSubjects = $this->programmeSubjectView_model->count_all();

        $this->pager['base_url'] = site_url(SITE_AREA .'/academic/subject/programme_subject');
        $this->pager['total_rows'] = $total_progSubjects;
        $this->pager['per_page'] = $this->limit;
        $this->pager['num_links'] = 1;
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);

        Template::set('toolbar_title', 'Manage Programme Subject');
        Template::set('total', $total_progSubjects);
        Template::set('current_url', current_url());
        Template::render();
    }

    //to create: form display for new programme
    public function create_programme_subject() {
        $this->load->model(array('programmeSubjectView_model','programmesubject_model', 'course/programmeView_model'));

        $this->auth->restrict('Subject.Academic.Add', SITE_AREA.'/academic/subject/programme_subject');

        if ($this->input->post('submit')) {
            if ($this->programmesubject_model->save_progSubject()) {
                // Log the activity
                log_activity($this->auth->user_id(), 'New Programme Subject created : ' . $this->input->ip_address(), 'subject');
                Template::set_message('Your programme lecture course was successfully created.', 'success');
                redirect(SITE_AREA .'/academic/subject/programme_subject');
            }
            else {
                Template::set_message('Your programme lecture course was not successfully created.', 'error');
                redirect(SITE_AREA .'/academic/subject/programme_subject');
            }
        }
        $listUser= $this->user_list();
        Template::set('listUser',$listUser);

        Template::set('toolbar_title', 'Manage Programme Subject');
        Template::set_view('academic/create_programme_subject');
        Template::render();
    }

    //to edit
    public function edit_programme_subject($id=null)  {
        $this->load->model(array('programmeSubjectView_model','programmesubject_model', 'course/programmeView_model'));

        $this->auth->restrict('Subject.Academic.Manage', SITE_AREA.'/academic/subject/programme_subject');

        if ($this->input->post('submit')) {
            if ($this->programmesubject_model->save_progSubject('update', $id)) {

                // Log the activity
                log_activity($this->auth->user_id(), 'Programme Subject with ID: '. $id . ' modified : ' . $this->input->ip_address(), 'subject');
                Template::set_message('Your programme lecture course was successfully editted.', 'success');
                redirect(SITE_AREA .'/academic/subject/programme_subject');
            }
        }
        $listUser= $this->user_list();
        Template::set('listUser',$listUser);

        Template::set('post', $this->programmesubject_model->find($id));
        Template::set('toolbar_title', 'Manage Study Programme');
        Template::set_view('academic/edit_programme_subject');
        Template::render();
    }

    //to delete
    public function delete_progSubject()  {
        $this->load->model('programmesubject_model');

        $this->auth->restrict('Subject.Academic.Delete', SITE_AREA.'/academic/subject/programme_subject');

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->programmesubject_model->delete($id);

                // Log the activity
                log_activity($this->auth->user_id(), 'Programme Subject with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'subject');
            }
            Template::set_message('Your programme course was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your programme course was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/academic/subject/programme_subject');
    }

    //get the list of all user
    public function user_list() {
        $users = $this->load->model('user_model')->select('id, display_name')->find_all_by('users.role_id',4);
        $allUsers = array();

        foreach($users as $user) {
            $allUsers[$user->id] = $user->display_name;
        }

        return $allUsers;
    } 

    //Export degree data to excel
    public function download_subject(){
        $column = 'subjectCode AS course_code, subjectTitle AS course_title, subjectUnit AS unit, description';
        $table = 'subjectbanks';

        // download to excel
        toExcel($table, $column, $table);
    }
    
    //Export degree data to excel
    public function download_progsubject(){

        $query = $this->db->select('programme, courseTitle, unit, level, semester, department, courseAdviser')
                        ->get('programmesubjectview');
        
        $delimiter = ",";
        $newline = "\r\n";
        
        // Load the DB utility class
        $this->load->dbutil();
        $downloadfile = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('programmeSubject.csv', $downloadfile); 
    }
}
