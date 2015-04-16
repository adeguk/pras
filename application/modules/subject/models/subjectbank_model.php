<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class subjectbank_model extends MY_Model {

	protected $table_name	= 'subjectBanks';
	protected $key			= 'subject_id';
	protected $set_created	= true;
	protected $set_modified	= true;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

    /*
        Method: find_all()

        Returns all student records, and their associated status information.

        Parameters:
            $show_deleted   - If false, will only return non-deleted students. If true, will
                return both deleted and non-deleted students.

        Returns: An array of objects with each student's information.
    */
    public function find_all() {
        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, firstname, middlename, lastname');
        }

       // $this->db->join('faculty', 'faculty.fac_id = departments.fac_id', 'left');
        $this->db->join('users', 'users.id = subjectBanks.instructor', 'left');

        return parent::find_all();
    }

	//to save:
    public function save_subject($type='insert', $id=null) {
        $this->form_validation->set_rules('subjectCode', 'Course Code', 'required|trim|xss_clean');
        $this->form_validation->set_rules('subjectTitle', 'Course Title', 'required|trim|xss_clean');
        $this->form_validation->set_rules('subjectUnit', 'Allocated Unit', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('instructor', 'Course Instructor', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'subjectCode'=> $this->input->post('subjectCode'),
            'subjectTitle'=> $this->input->post('subjectTitle'),
            'description'   => $this->input->post('description'),
            'instructor'    => $this->input->post('instructor'),
            'subjectUnit'    => $this->input->post('subjectUnit'),
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
