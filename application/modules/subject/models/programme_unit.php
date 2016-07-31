<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class Programme_model extends MY_Model {

	protected $table_name	= 'programme';
	protected $key			= 'prog_id';
	protected $set_created	= true;
	protected $set_modified	= false;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

	//get the list of all department Name and ID
    /*public function programme_list() {
        $progs = $this->select('prog_id, course_id')->find_all_by('deleted', 0);
        $programmes = array();

        foreach($progs as $prog) {
            $programmes[$prog->prog_id] = $prog->course_id;
        }

        return $programmes;
    }*/

	//to save programme:
    public function save_programme($type='insert', $id=null) {
        $this->form_validation->set_rules('course_id', 'Course Name', 'required|trim');
        $this->form_validation->set_rules('deg_id', 'Degree Type', 'required|trim');
        $this->form_validation->set_rules('dept_id', 'Department', 'required|trim');
        $this->form_validation->set_rules('studyTypeID', 'Study Type', 'required|trim');
        $this->form_validation->set_rules('progCode', 'Programme Code', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('progDuration', 'Duration', 'required|trim');
        $this->form_validation->set_rules('progStart_level', 'Programme Start Level', 'required|trim');
        $this->form_validation->set_rules('progEnd_level', 'Programme End Level', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'course_id'	    => $this->input->post('course_id'),
            'deg_id'	    => $this->input->post('deg_id'),
            'dept_id'	    => $this->input->post('dept_id'),
            'studyTypeID'   => $this->input->post('studyTypeID'),
            'progCode'      => $this->input->post('progCode'),
            'description'	=> $this->input->post('description'),
            'progDuration'	=> $this->input->post('progDuration'),
            'progStart_level'	=> $this->input->post('progStart_level'),
            'progEnd_level' => $this->input->post('progEnd_level'),
            'status'        => $this->input->post('status')
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
