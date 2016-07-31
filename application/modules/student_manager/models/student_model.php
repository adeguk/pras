<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Student_model extends BF_Model {
	protected $table_name	= 'students';
    protected $key			= 'id';
    protected $date_format	= 'datetime';

    protected $log_user 	= false;
    protected $set_created	= true;
    protected $set_modified = false;
    protected $soft_deletes	= true;

    protected $created_field     = 'created_on';
    protected $modified_field    = 'modified_on';
    protected $deleted_field     = 'deleted';

    // Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
    protected $before_insert 	= array();	# create matric no. before insert
    protected $after_insert 	= array();	# Update matric column in user table
    protected $before_update 	= array();
    protected $after_update 	= array();
    protected $before_find 	    = array();
    protected $after_find 		= array();
    protected $before_delete 	= array();
    protected $after_delete 	= array();

    // For performance reasons, you may require your model to NOT return the id
    // of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
    protected $return_insert_id = false;

    // The default type for returned row data.
    protected $return_type = 'object';

    // Items that are always removed from data prior to inserts or updates.
    protected $protected_attributes = array();

    // You may need to move certain rules (like required) into the
    // $insert_validation_rules array and out of the standard validation array.
    // That way it is only required during inserts, not updates which may only
    // be updating a portion of the data.
	protected $validation_rules 		= array(
       array(
          'field' => 'user_id',
          'label' => 'lang:pras_full_name',
          'rules' => 'required',
       ),
       array(
          'field' => 'matricNo',
          'label' => 'lang:pras_matric',
          'rules' => 'required|trim|strip_tags|max_length[13]',
       ),
       array(
          'field' => 'jamb_reg',
          'label' => 'lang:pras_jamb_reg',
          'rules' => 'required|trim|strip_tags|alpha_extra|max_length[13]',
       ),
       array(
          'field' => 'prog_id',
          'label' => 'lang:pras_program',
          'rules' => 'required|trim',
       ),
       array(
          'field' => 'progLevel',
          'label' => 'lang:pras_field_level',
          'rules' => 'required|trim',
       ),
       array(
          'field' => 'startMode',
          'label' => 'lang:pras_field_startMode',
          'rules' => 'required|trim',
       ),
       array(
          'field' => 'entryMode',
          'label' => 'lang:pras_field_entryMode',
          'rules' => 'required|trim',
       ),
       array(
          'field' => 'status',
          'label' => 'lang:pras_field_status',
          'rules' => '',
       ),
    );
    protected $insert_validation_rules  = array();
    protected $skip_validation 			= false;

 //to save:
    public function save_student($type = 'insert', $id = NULL) {
       // Validate the data
       $this->form_validation->set_rules($this->get_validation_rules());
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
            'progLevel' => $this->input->post('progLevel'),
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
