<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class academic_session_model extends MY_Model {

	protected $table_name	= 'academic_session';
	protected $key			= 'aca_Session_id';
	protected $set_created	= false;
	protected $set_modified	= false;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

    //to save:
    public function save_session($type='insert', $id=null) {
        $this->form_validation->set_rules('session', 'Session Name', 'required|trim');
        $this->form_validation->set_rules('startDate', 'Start Date', 'required|trim');
        $this->form_validation->set_rules('endDate', 'End Date', 'required|trim');
        $this->form_validation->set_rules('studyMode', 'Study Mode', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');


        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'session'	=> $this->input->post('session'),
            'startDate'	=> $this->input->post('startDate'),
            'endDate'	=> $this->input->post('endDate'),
            'studyMode' => $this->input->post('studyMode'),
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
