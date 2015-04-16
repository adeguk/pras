<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class course_reg_model extends MY_Model {

	protected $table_name	= 'course_registration';
	protected $key			= 'courseReg_id';
	protected $set_created	= FALSE;
	protected $set_modified	= FALSE;
	protected $soft_deletes	= FALSE;
	protected $date_format	= 'datetime';

    /*
        Method: find_all()

        Returns all student records, and their associated status information.

        Parameters:
            $show_deleted   - If false, will only return non-deleted students. If true, will
                return both deleted and non-deleted students.

        Returns: An array of objects with each student's information.
    */
    public function find_all($show_deleted=false) {
        
        if (empty($this->selects)) {
            $this->select($this->table_name .'.courseReg_id, course_registration.student_id, course_registration.progSubject_id, 
                students.user_id, programmesubjects.subject_id, bf_programmesubjects.compulsory, subjectbanks.subjectTitle, subjectbanks.subjectCode, subjectbanks.subjectUnit');
        }

        $this->db->join('students', 'students.studentID = course_registration.student_id', 'left');
        $this->db->join('programmesubjects', 'programmesubjects.progSubject_id = course_registration.progSubject_id', 'left');
        $this->db->join('subjectbanks', 'subjectbanks.subject_id = programmesubjects.subject_id', 'left');

        if ($show_deleted === false) {
            $this->db->where('course_registration.deleted', 0);
        }

        return parent::find_all();
    }

    /*
        Method: find_by()

        Locates a single student based on a field/value match, with their category information.

        Parameters:
            $field  - A string with the field to match.
            $value  - A string with the value to search for.

        Returns: An object with the user's info, or false on failure.
    */
    public function find_by($field=null, $value=null) {
        
        if (empty($this->selects)) {
            $this->select($this->table_name .'.courseReg_id, course_registration.student_id, course_registration.progSubject_id, 
                students.user_id, programmesubjects.subject_id, subjectbanks.subjectTitle, subjectbanks.subjectCode, subjectbanks.subjectUnit');
        }

        $this->db->join('students', 'students.studentID = course_registration.student_id', 'left');
        $this->db->join('programmesubjects', 'programmesubjects.progSubject_id = course_registration.progSubject_id', 'left');
        $this->db->join('subjectbanks', 'subjectbanks.subject_id = programmesubjects.subject_id', 'left');
        $this->db->where('course_registration.deleted',0);

        return parent::find_by($field, $value);
    }

   //to save:
    private function save_courseReg($type='insert', $id=null) {
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