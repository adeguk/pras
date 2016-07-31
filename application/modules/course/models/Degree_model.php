<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class Degree_Model extends MY_Model {

	protected $table_name	= 'degree';
	protected $key			= 'deg_id';
	protected $set_created	= false;
	protected $set_modified	= false;
	protected $soft_deletes	= true;
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
          'field' => 'degreeName',
          'label' => 'lang:pras_field_degree',
          'rules' => 'required|trim|alpha_extra',
       ),
       array(
          'field' => 'degreeAbbreviation',
          'label' => 'lang:pras_field_abbreviation',
          'rules' => 'required|trim|alpha_extra',
       ),
       array(
          'field' => 'status',
          'label' => 'lang:pras_field_status',
          'rules' => '',
       ),
    );

	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    //get the list of all department Name and ID
    public function degree_list() {
        $degs = $this->select('deg_id, degreeName')->order_by('degreeName', 'desc')->find_all_by('deleted', 0);
        $degrees = array();

        foreach($degs as $deg) {
            $degrees[$deg->deg_id] = $deg->degreeName;
        }

        return $degrees;
    }
}
