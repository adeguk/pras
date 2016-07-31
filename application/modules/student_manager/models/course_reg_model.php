<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class course_reg_model extends MY_Model {

	protected $table_name	= 'course_registration';
	protected $key			= 'courseReg_id';
	protected $set_created	= true;
	protected $set_modified	= true;
	protected $soft_deletes	= false;
	protected $date_format	= 'datetime';

    /*
    private function regFaculty() {
        $this->db->join('students', 'course_registration.user_id = students.user_id', 'left');
        $query = $this->db->select('fac_id AS faculty_list')
                ->group_by('fac_id')
                ->order_by('faculty_list','DESC')
                ->get($this->get_table());
    }

    private function reg_by_level($level='1') {
        $this->db->join('students', 'course_registration.user_id = students.user_id', 'left');
        $query = $this->db->select('fac_id COUNT(user_id) AS courseReg_count')
                ->where ('level', $level)
                ->group_by('fac_id')
                ->order_by('courseReg_count','DESC')
                ->get($this->get_table());
    }
    */

    /*
     * Returns all registration made in one or more faculty.
     *
     * @access public
     *
     * @param array $faculties Either a string or an array of faculty names.
     *
     * @return bool/array An array of registration objects.
     */
     /*
    public function find_by_faculty($faculties=array()) {
        if (empty($faculties)) {
            logit('No faculty name given to `find_by_faculty`.');
            return FALSE;
        }

        if (!is_array($faculties)) {
            $faculties = array($faculties);
        }

        $this->db->where_in('faculty', $faculties);
        $this->db->where('activities.deleted', 0);

        $this->db->select('activity_id, activities.user_id, activity, faculty, activities.created_on, display_name, username, email, last_login');
        $this->db->join('users', 'activities.user_id = users.id', 'left');

        return $this->find_all();

    }//end find_by_module()
    */

//to save:
    /*private function save_courseReg($type='insert', $id=null) {
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
    }*///end of save_courseReg()
}