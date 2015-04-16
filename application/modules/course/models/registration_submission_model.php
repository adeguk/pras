<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class registration_submission_model extends MY_Model {

	protected $table_name	= 'registration_submission';
	protected $key			= 'regSub_id';
	protected $set_created	= TRUE;
	protected $set_modified	= TRUE;
	protected $soft_deletes	= FALSE;
	protected $date_format	= 'datetime';

    /**
     *   Method: find_all_by()
     *
     *   Returns all student records, and their associated status information.
     * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, April 2014
     * @param
     *       $show_deleted   - If false, will only return non-deleted students. If true, will
     *           return both deleted and non-deleted students.
     *
     *    Returns: An array of objects with each student's information.
     */
    public function find_all_by($semester=null, $show_deleted=false) {
        
        if (empty($this->selects)) {
            $this->select($this->table_name .'*, fac_name, dept_name, session, bf_students.studyMode');
        }

        $this->db->join('students', 'students.studentID = registration_submission.student_id', 'left');
        $this->db->join('faculty', 'faculty.fac_id = students.fac_id', 'left');
        $this->db->join('departments', 'departments.dept_id = students.dept_id', 'left');
        $this->db->join('semester_session', 'semester_session.sem_session_id = registration_submission.semester_session_id', 'left');
        $this->db->join('academic_session', 'academic_session.aca_session_id = semester_session.aca_session_id', 'left');

        $this->db->where('registration_submission.semester_session_id = '. $semester);

        if ($show_deleted === false) {
            $this->db->where('registration_submission.deleted', 0);
        }

        return parent::find_all_by();
    }

    /*
        Method: find_by()

        Locates a single student based on a field/value match, with their category information.

        Parameters:
            $field  - A string with the field to match.
            $value  - A string with the value to search for.

        Returns: An object with the user's info, or false on failure.
    */
    /*public function find_by($field=null, $value=null) {
        
        if (empty($this->selects)) {
            $this->select($this->table_name .'.courseReg_id, course_registration.student_id, course_registration.progSubject_id, 
                students.user_id, programmesubjects.subject_id, subjectbanks.subjectTitle, subjectbanks.subjectCode, subjectbanks.subjectUnit');
        }

        $this->db->join('students', 'students.studentID = course_registration.student_id', 'left');
        $this->db->join('programmesubjects', 'programmesubjects.progSubject_id = course_registration.progSubject_id', 'left');
        $this->db->join('subjectbanks', 'subjectbanks.subject_id = programmesubjects.subject_id', 'left');
        $this->db->where('course_registration.deleted',0);

        return parent::find_by($field, $value);x
    }*/

    /**
     *    Method: listRegisteredCourse()
     *
     *    Returns all student records, and their associated status information.
     * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, February 2014
     *       $show_deleted   - If false, will only return non-deleted students. If true, will
     *           return both deleted and non-deleted students.
     *
     *   Returns: An array of objects with each student's information.
     */
    public function listRegisteredCourse($id=null, $Semester=null) {

        $id=$this->uri->segment(5);
        $student = $this->student_model->find_by('studentID',$id);
        $sessions = $this->semester_session_model->get_CurrentSession();

        if (isset($sessions) && is_array($sessions)){
            foreach ($sessions as $semester) {
                $semester = $semester->session_semester;
            }
        }
        
        if (empty($this->selects)) {
            $this->select($this->table_name .'regSub_id,  bf_registration_submission.student_id, bf_registration_submission.created_on, 
                bf_course_registration.student_id, bf_course_registration.semester_session_id, 
                bf_subjectbanks.subjectCode, bf_subjectbanks.subjectTitle, bf_subjectbanks.subjectUnit, bf_programmesubjects.compulsory, bf_academic_session.startDate');
        }

        $this->db->join('course_registration', 'course_registration.student_id = registration_submission.student_id', 'left');
        $this->db->join('programmesubjects', 'programmesubjects.progSubject_id = course_registration.progSubject_id', 'left');
        $this->db->join('subjectbanks', 'subjectbanks.subject_id = programmesubjects.subject_id', 'left');
        $this->db->join('semester_session', 'semester_session.sem_session_id = registration_submission.semester_session_id', 'left');
        $this->db->join('academic_session', 'academic_session.aca_session_id = semester_session.aca_session_id', 'left');
        $this->db->where(array('course_registration.semester_session_id' => 'registration_submission.semester_session_id',
            'registration_submission.student_id' => $id, 'registration_submission.semester_session_id' => $semester ));

        if ($show_deleted === false) {
            $this->db->where('registration_submission.deleted', 0);
        }

        return parent::find_all();
    }

   //to save:
    /**
     * @method: save_registration()
     *
     *    Returns all student records, and their associated status information.
     * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng,February 2014
     * @param:
     *       $show_deleted   - If false, will only return non-deleted students. If true, will
     *           return both deleted and non-deleted students.
     *
     *   Returns: An array of objects with each student's information.
     */
    private function save_registration($type='insert', $id=null) {
        $this->auth->restrict();
        $this->set_current_user();

        if ( $id == 0 ) {
            $user_id = $this->current_user->id; 
        }

        $_POST['id'] = $user_id;

        // Simple check to make the posted id is equal to the current user's id, minor security check
        if ( $_POST['id'] != $this->current_user->id )  {
            $this->form_validation->set_message('email', 'lang:us_invalid_userid');
            return FALSE;
        }

        $this->form_validation->set_rules('progSubject_id', 'Course Title', 'required|trim');
        $this->form_validation->set_rules('semester_session_id', 'Semester', 'required|trim');


        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'user_id'           => $this->input->post('user_id'),
            'progSubject_id'    => $this->input->post('progSubject_id'),
            'semester_session_id'=> $this->input->post('semester_session_id')
        );

        if ($type == 'insert') {
            $return = $this->insert($data);
        }
        else {  // Update
            $return = $this->update($id, $data);
        }

        return $return;
    }//end of save_courseReg()

    // create course reg
    /**
     *    Method: create_registrationData()
     *
     *    Returns all student records, and their associated status information.
     *
     * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, February 2014
     * @param:
     *       $show_deleted   - If false, will only return non-deleted students. If true, will
     *           return both deleted and non-deleted students.
     *
     *   Returns: An array of objects with each student's information.
     */
    public function create_registrationData($id = NULL) {
        $insertQuery = 'INSERT INTO bf_course_registration (student_id, progSubject_id, semester_session_id)
                        SELECT studentID , progSubject_id , sem_session_id
                        FROM bf_programmesubjects
                        JOIN bf_students ON bf_students.prog_id = bf_programmesubjects.course_id
                        JOIN bf_semester_session ON bf_semester_session.session_semester = bf_programmesubjects.prog_semester
                        JOIN bf_academic_session ON bf_academic_session.aca_session_id = bf_semester_session.aca_session_id
                        WHERE NOT EXISTS (
                            SELECT * FROM bf_course_registration
                            WHERE bf_programmesubjects.progSubject_id = bf_course_registration.progSubject_id
                            AND bf_programmesubjects.course_id = bf_students.prog_id
                            AND bf_students.studentID = bf_course_registration.student_id
                        )
                        AND bf_academic_session.studyMode = bf_students.studyMode
                        AND bf_programmesubjects.prog_level = bf_students.level
                        AND bf_students.studentID ='.$id;

        return $this->db->simple_query($insertQuery);
    }
}