<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class student_model extends MY_Model {

	protected $table_name	= 'students';
	protected $key			= 'studentID';
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
            $this->select($this->table_name .'.*, firstname, middlename, lastname, fac_name, dept_name');
        }

        $this->db->join('users', 'users.id = students.user_id', 'left');
        $this->db->join('faculty', 'faculty.fac_id = students.fac_id', 'left');
        $this->db->join('departments', 'departments.dept_id = students.dept_id', 'left');
        
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

    /*
        Method: find_by()

        Locates a single student based on a field/value match, with their category information.

        Parameters:
            $field  - A string with the field to match.
            $value  - A string with the value to search for.

        Returns: An object with the user's info, or false on failure.
    */

 //to save:
    public function save_student($type='insert', $id=null) {

        $this->form_validation->set_rules('user_id', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('matricNo', 'Matric No.', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('jamb_reg', 'Jamb Registration No.', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('prog_id', 'Programme Study', 'required|trim');
        $this->form_validation->set_rules('level', 'Course Level', 'required|trim');
        $this->form_validation->set_rules('studyMode', 'Study Mode', 'required|trim');
        $this->form_validation->set_rules('entryMode', 'Entry Mode', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');


        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
       $data = array(
            'user_id'   => $this->input->post('user_id'),
            'matricNo'  => $this->input->post('matricNo'),
            'jamb_reg'  => $this->input->post('jamb_reg'),
            'prog_id'   => $this->input->post('prog_id'),
            'level'     => $this->input->post('level'),
            'studyMode' => $this->input->post('studyMode'),
            'entryMode' => $this->input->post('entryMode'),
            'status'    => $this->input->post('status')
        );

        if ($type == 'insert') {
            $return = $this->insert($data);
        }
        else {  // Update
            $return = $this->update($id, $data);
        }

        return $return;
    }
}
   