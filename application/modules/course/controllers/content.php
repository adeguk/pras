<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller {

	public function __construct() {
        parent::__construct();

		$this->auth->restrict('Course.Content.View');

		//list models relating to subjects and others
        $this->load->model(array('course_reg_model','prog_semester_unit_model', 'registration_submission_model',
								'academic/academic_session_model', 'academic/semester_session_model'));
		$this->load->model(array('subject/subjectbank_model', 'subject/programmesubject_model', 'student_manager/student_model', 'users/user_model'));

        Assets::add_css( css_path() . 'chosen.css');
        Assets::add_js( js_path() . 'chosen.jquery.min.js' );

        Template::set('toolbar_title', 'Course Registration Manager');
        Template::set_block('sub_nav', 'content/_sub_nav');
    }

	public function index() {
		$this->auth->restrict();  

        $sessions = $this->semester_session_model->get_CurrentSession();

        /**
         * Find the value of the academic session from the session table
         * Assign the value(s) to the template for later use*/
        if (isset($sessions) && is_array($sessions)){
            foreach ($sessions as $semester) {
                $session = $semester->session;
                $isCurrent = $semester->isCurrent;
                $semester = $semester->session_semester;
            }
           
            Template::set('semester', $semester);
            Template::set('currentSession', config_item('miscellaneous.session')[$session]);            
            Template::set('currentSemester', config_item('miscellaneous.semester')[$semester]);
        }

        //Find the student account of the current user from the student table
        $student = $this->student_model->find_by('user_id',$this->current_user->id);
        //Search the current student's course registration for the academic session and semester
        $course_reg = $this->course_reg_model->where(array('student_id'=>$student->studentID, 'semester_session_id'=>$semester))->find_all();
        
        /*if ($isCurrent == 0){            
            Template::set_view('content/welcome');
            Template::render();
        }*/
        
        /**
         * Find the course registration data status: determine whether or not course registation data
         * has been assign to the student else create one in the course registration bank
         * */
        if (isset($course_reg) && is_array($course_reg)) {
            Template::set('course_reg', $course_reg);
        } else {
            $this->course_reg_model->create_registrationData($student->studentID);
            $course_reg = $this->course_reg_model->where(array('student_id'=>$student->studentID, 'semester_session_id'=>$semester))->find_all();
            Template::set('course_reg', $course_reg);
        }
        
        //Check for submitted course reg
        $submitted = $this->registration_submission_model->find_by(array('student_id'=>$student->studentID, 'semester_session_id'=>$semester));
        
        Template::set('submitted', $submitted);
        
        Template::set('student', $student);
        Template::set('student_studyMode', $student->studyMode);
		Template::render();
	}

    /**
     * Delete course*/
    public function delete($id=null)  {

        $this->auth->restrict('Course.Content.Delete', SITE_AREA.'/content/course');

        if (isset($id)) {
            $this->course_reg_model->delete($id);

            // Log the activity
            log_activity($this->auth->user_id(), 'Course Title with ID: '. $id . ' delete from Course Registration : ' . $this->input->ip_address(), 'course');
            Template::set_message('Student\'s Course Registration was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Student\'s Course Registration was not successfully deleted.', 'error');
        }

        redirect(SITE_AREA .'/content/course');
    }

    //to reset registration
    public function resetRegistration()  {

        $this->auth->restrict('Course.Content.Delete', SITE_AREA.'/content/course');

        $id=$this->uri->segment(5);
        $courseRegs = $this->course_reg_model->find_all_by('student_id',$id);
        
        if (isset($courseRegs) && is_array($courseRegs)) {
            foreach ($courseRegs as $courseReg) {
                $this->course_reg_model->delete($courseReg->courseReg_id, true);
            }
        }

        // Log the activity
        log_activity($this->auth->user_id(), 'Course Registration was completely reset: ' . $this->input->ip_address(), 'course');
        Template::set_message('Student\'s Course Registration was successfully reset completely.', 'success');
        
        redirect(SITE_AREA .'/content/course');
    }

    //to add a course subject to registration
    public function addCourse()  {

        $this->auth->restrict('Course.Content.Add', SITE_AREA.'/content/course');

        $offset = $this->uri->segment(5);

        #Add Search functionality to programme subject lists
        $search_term = $this->input->post('search_term');
        $search_terms = array('subjectCode'=> $search_term, 'subjectTitle'=> $search_term);
        if ($search_term) {
            $this->programmesubject_model->or_like($search_terms);
            Template::set('search_term', $search_term);
        }

        $this->load->model('programme_model');
        $progSubjects = $this->programmesubject_model->limit($this->limit, $offset)->find_all_by('programmesubjects.deleted', 0);

        #Add pagination functionality to the page
        $total_courses = $this->programmesubject_model->count_all();
        $this->load->library('pagination');
        $this->pager['base_url'] = site_url(SITE_AREA .'/content/course/addCourse/index');
        $this->pager['total_rows'] = $total_courses;
        $this->pager['per_page'] = $this->limit;
        $this->pager['uri_segment'] = 5;

        $this->pagination->initialize($this->pager);

        Template::set('progSubjects', $progSubjects);

        Template::set('current_url', current_url());
        Template::set_view('content/add');
        Template::render();
    }

    //to course title to students's registration
    public function add($id=null)  {

        $this->auth->restrict('Course.Content.Add', SITE_AREA.'/content/course');

        $student = $this->student_model->find_by('user_id',$this->current_user->id);

        $sessions = $this->semester_session_model->get_CurrentSession();

        if (isset($sessions) && is_array($sessions)){
            foreach ($sessions as $semester) {
                $semester = $semester->session_semester;
            }
        }

        if (isset($id)) {

            $_POST['student_id'] = $student->studentID;
            $_POST['progSubject_id'] = $id;
            $_POST['semester_session_id'] = $semester;

            // Compile our post data to make sure nothing
            // else gets through.
            $data = array(
                'student_id'  => $this->input->post('student_id'),
                'progSubject_id'    => $this->input->post('progSubject_id'),
                'semester_session_id'    => $this->input->post('semester_session_id')
            );

            $inserted=$this->course_reg_model->insert($data);
            if (isset($inserted)) {
                // Log the activity
                log_activity($this->auth->user_id(), 'Course Title with ID: '. $id . ' added to student Course Registration : ' . $this->input->ip_address(), 'course');
                Template::set_message('Course Title was successfully added. studentID: '.$_POST['student_id'].' Add more or Click <b>Cancel</b> below to continue your Registration', 'success');
                redirect(SITE_AREA .'/content/course/addCourse');
            }
            else {
                Template::set_message('Course Title was not successfully added.', 'error');
                redirect(SITE_AREA .'/content/course/addCourse');
            }
        }
        else {
            Template::set_message('No student found!.', 'error');
            redirect(SITE_AREA .'/content/course');
        }
    }

    //to register the course
    public function registerCourse($id=null)  {

        $this->auth->restrict('Course.Content.Add', SITE_AREA.'/content/course');

        $this->load->model('registration_submission_model');

        $id=$this->uri->segment(5);
        $student = $this->student_model->find_by('studentID',$id);
        $sessions = $this->semester_session_model->get_CurrentSession();

        if (isset($sessions) && is_array($sessions)){
            foreach ($sessions as $semester) {
                $semester = $semester->session_semester;
            }
        }

        if (isset($id)) {

            $_POST['student_id'] = $id;
            $_POST['semester_session_id'] = $semester;
            $_POST['levelID'] = $student->level;
            $_POST['created_on'] = date('Y-m-n h:i:s', time());

            // Compile our post data to make sure nothing
            // else gets through.
            $data = array(
                'student_id'  => $this->input->post('student_id'),
                'semester_session_id'    => $this->input->post('semester_session_id'),
                'levelID'    => $this->input->post('levelID'),
                'created_on'    => $this->input->post('created_on')
            );

            $inserted=$this->registration_submission_model->insert($data);
            if (isset($inserted)) {
                // Log the activity
                log_activity($this->auth->user_id(), 'Student with ID: '. $id . ' successfully registered : ' . $this->input->ip_address(), 'course');
                Template::set_message('You have successfully registered for this session.', 'success');
                redirect(SITE_AREA .'/content/course');
            }
            else {
                Template::set_message('You have not successfully registered for this session. <strong>Please try again</strong>', 'error');
                redirect(SITE_AREA .'/content/course');
            }
        }
        else {
            Template::set_message('No student found!.', 'error');
            redirect(SITE_AREA .'/content/course');
        }
    }

    //to reverse a course registration
    public function reverseRegistration($id=null)  {

        $this->auth->restrict('Course.Content.Delete', SITE_AREA.'/content/course');

        $id=$this->uri->segment(5);
    
        $this->registration_submission_model->delete($id, true);

        // Log the activity
        log_activity($this->auth->user_id(), 'Course Registration was completely reset: ' . $this->input->ip_address(), 'course');
        Template::set_message('Student\'s Course Registration was successfully reset completely.', 'success');
        
        redirect(SITE_AREA .'/content/course');
    }

	/*--------------------------------------------------------------------
	/	PRIVATE FUNCTIONS
	/-------------------------------------------------------------------*/

}

/* End of file Content.php */
/* Location: ./module/course/controllers/content.php */