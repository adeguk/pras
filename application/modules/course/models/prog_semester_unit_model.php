<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class prog_semester_unit_model extends MY_Model {

	protected $table_name	= 'prog_semester_unit';
	protected $key			= 'progSU_id';
	protected $set_created	= false;
	protected $set_modified	= false;
	protected $soft_deletes	= false;
	protected $date_format	= 'datetime';

	//to save:
    public function save_progSU($type='insert', $id=null) {
        $this->form_validation->set_rules('prog_id', 'Course Name', 'required|trim');
        $this->form_validation->set_rules('minimumUnit', 'Minimum Unit', 'required|trim');
        $this->form_validation->set_rules('maximumUnit', 'Maximum Unit', 'required|trim');
        $this->form_validation->set_rules('progLevel', 'Level', 'required|trim');
        $this->form_validation->set_rules('progSemester', 'Semester', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'prog_id'       => $this->input->post('prog_id'),
            'minimumUnit'   => $this->input->post('minimumUnit'),
            'maximumUnit'   => $this->input->post('maximumUnit'),
            'progLevel'     => $this->input->post('progLevel'),
            'progSemester'  => $this->input->post('progSemester')
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
