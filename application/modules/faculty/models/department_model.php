<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class department_model extends MY_Model {

	protected $table_name	= 'departments';
	protected $key			= 'dept_id';
	protected $set_created	= true;
	protected $set_modified	= true;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

    //get the list of all department Name and ID
    public function department_list() {
        $depts = $this->select('dept_id, dept_name')->order_by('dept_name', 'ASC')->find_all_by('departments.deleted', 0);
        $departments = array();

        foreach($depts as $dept) {
            $departments[$dept->dept_id] = $dept->dept_name;
        }

        return $departments;
    }
    
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
            $this->select($this->table_name .'.*, fac_name, firstname, middlename, lastname');
        }

        $this->db->join('faculty', 'faculty.fac_id = departments.fac_id', 'left');
        $this->db->join('users', 'users.id = faculty.fac_dean', 'left');

        return parent::find_all();
    }
    
    //to save department:
    public function save_department($type='insert', $id=null) {
        $this->form_validation->set_rules('dept_name', 'Department Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('dept_hod', 'Name of HOD', 'trim|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('fac_id', 'Faculty', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'dept_name'	=> $this->input->post('dept_name'),
            'dept_hod'	=> $this->input->post('dept_hod'),
            'description'	=> $this->input->post('description'),
            'fac_id'    => $this->input->post('fac_id'),
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
