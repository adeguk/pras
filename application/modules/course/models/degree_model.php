<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class Degree_model extends MY_Model {

	protected $table_name	= 'degree';
	protected $key			= 'deg_id';
	protected $set_created	= false;
	protected $set_modified	= false;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

    //get the list of all department Name and ID
    public function degree_list() {
        $degs = $this->select('deg_id, degreeName')->order_by('degreeName', 'desc')->find_all_by('deleted', 0);
        $degrees = array();

        foreach($degs as $deg) {
            $degrees[$deg->deg_id] = $deg->degreeName;
        }

        return $degrees;
    }

    //to save:
    public function save_degree($type='insert', $id=null) {
        $this->form_validation->set_rules('degreeName', 'Degree Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('degreeAbbreviation', 'Abbreviation', 'required|trim|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'degreeName'=> $this->input->post('degreeName'),
            'degreeAbbreviation'    => $this->input->post('degreeAbbreviation'),
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
