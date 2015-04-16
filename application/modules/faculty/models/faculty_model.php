<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class faculty_model extends MY_Model {

	protected $table_name	= 'faculty';
	protected $key			= 'fac_id';
	protected $set_created	= true;
	protected $set_modified	= true;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

    //get the list of all faculties Name and ID
    public function faculty_list() {
       // $facs = $this->select('fac_id, fac_name')->find_all();
        $facs = $this->select('fac_id, fac_name')->order_by('fac_name', 'ASC')->find_all_by('faculty.deleted', 0);
        $faculties = array();

        foreach($facs as $fac) {
            $faculties[$fac->fac_id] = $fac->fac_name;
        }

        return $faculties;
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
            $this->select($this->table_name .'.*, firstname, middlename, lastname');
        }

        $this->db->join('users', 'users.id = faculty.fac_dean', 'left');

        return parent::find_all();
    }

    //to save:
    public function save_faculty($type='insert', $id=null) {
        $this->form_validation->set_rules('fac_name', 'Faculty Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('fac_dean', 'Dean of Faculty', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'fac_name'	=> $this->input->post('fac_name'),
            'fac_dean'	=> $this->input->post('fac_dean'),
            'description'	=> $this->input->post('description'),
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
