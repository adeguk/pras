<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class ProgrammeUnit_Model extends MY_Model {

	protected $table_name	= 'ProgrammeUnit';
	protected $key			= 'id';
	protected $set_created	= false;
	protected $set_modified	= false;
	protected $soft_deletes	= false;
	protected $date_format	= 'datetime';

	// Customize the operations of the model without recreating the insert,
	// update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
	// primarily helpful when running big loops over data.
	protected $return_insert_id = true;

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
          'field' => 'prog_id',
          'label' => 'lang:pras_field_program',
          'rules' => 'required|trim|alpha',
       ),
       array(
          'field' => 'programmeLevel',
          'label' => 'lang:pras_field_level',
          'rules' => 'required|trim',
       ),
       array(
          'field' => 'sem_session_id',
          'label' => 'lang:pras_field_semester',
          'rules' => 'required',
       ),
       array(
          'field' => 'minimumUnit',
          'label' => 'lang:pras_field_minimum_unit',
          'rules' => 'required|trim',
       ),
       array(
          'field' => 'maximumUnit',
          'label' => 'lang:pras_field_maximum_unit',
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
            $this->select($this->table_name .'.*, program, progDuration');
        }

        $this->db->join('programme_view', 'programme_view.id = programmeUnit.prog_id', 'left');

        return parent::find_all();
    }
}
