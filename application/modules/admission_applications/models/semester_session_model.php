<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class semester_session_model extends MY_Model {

	protected $table_name	= 'semester_session';
	protected $key			= 'sem_session_id';
	protected $set_created	= false;
	protected $set_modified	= false;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

    /*
        Method: find()

        Finds an individual student record. Also returns role information for
        the student.

        Parameters: $id - An INT with the student's ID.

        Returns: An object with the student's information.
    */
    /*public function find($id=null) {
        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, session);
        }

        $this->db->join('academic_session', 'academic_session.aca_session_id = semester_session.aca_session_id', 'left');

        return parent::find($id);
    }*/

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
            $this->select($this->table_name .'.*, session, studyMode');
        }

        if ($show_deleted === false) {
            $this->db->where('semester_session.deleted', 0);
        }

        $this->db->join('academic_session', 'academic_session.aca_session_id = semester_session.aca_session_id', 'left');

        $this->db->where('academic_session.status', 1);

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

        $this->db->join('academic_session', 'academic_session.aca_session_id = semester_session.aca_session_id', 'left');
        #$this->db->join('students', 'students.aca_session_id = semester_session.aca_session_id', 'left');

        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, session, academic_session.startDate, academic_session.endDate, studyMode');
        }

        return parent::find_by($field, $value);
    }

    //--------------------------------------------------------------------
    public function get_CurrentSession( $isCurrent = true) {
        $semester_sessions = null;

        $today = date("Y-m-d H:m:s");
        
        if ($isCurrent === true) {
            $this->db->join('academic_session', 'academic_session.aca_session_id = semester_session.aca_session_id', 'left');
            $where = array('isCurrent'=> 1,'semester_session.startDate <=' => $today, 'semester_session.endDate >' => $today);
            $this->db->where($where);
        }

        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, session, academic_session.studyMode');
            $this->db->where('academic_session.status',1);
        }

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {
            $semester_sessions = $query->result(); 
        }

        return $semester_sessions;
    }

 
    //to save department:
    public function save_semester_session($type='insert', $id=null) {
        $this->form_validation->set_rules('session_semester', 'Session Semester', 'required|trim');
        $this->form_validation->set_rules('aca_session_id', 'Academic Session', 'required|trim');
        $this->form_validation->set_rules('startDate', 'Start Date', 'required|trim');
        $this->form_validation->set_rules('endDate', 'End Date', 'required|trim');
        $this->form_validation->set_rules('isCurrent', 'Is Current?', 'required|trim');
        $this->form_validation->set_rules('isRegistration', 'Is Registration?', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'session_semester'  => $this->input->post('session_semester'),
            'aca_session_id'    => $this->input->post('aca_session_id'),
            'startDate'	        => $this->input->post('startDate'),
            'endDate'           => $this->input->post('endDate'),
            'isCurrent'         => $this->input->post('isCurrent'),
            'isRegistration'    => $this->input->post('isRegistration')
        );

        if ($type == 'insert') {
            $return = $this->insert($data);
        }
        else {  // Update
            $return = $this->update($id, $data);
        }

        return $return;
    }

    /*public function db_array(){
        // Grab the default array from the base model
        $db_array = parent::db_array();

        // Change the post date to a UNIX timestamp
        $db_array[] = strtotime($db_array['post_date']);

        // Return the array
        return $db_array;
    }*/

}
