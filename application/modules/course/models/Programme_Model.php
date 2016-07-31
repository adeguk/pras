<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class Programme_Model extends MY_Model {

	protected $table_name	= 'programme';
	protected $key			= 'prog_id';
	protected $set_created	= true;
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
			'field' => 'course_id',
	        'label' => 'lang:pras_field_course',
	        'rules' => 'required|numeric',
	    ),
	    array(
	    	'field' => 'deg_id',
	        'label' => 'lang:pras_field_degName',
	        'rules' => 'required|numeric',
	    ),
	    array(
	        'field' => 'studyTypeID',
	        'label' => 'lang:pras_field_studyMode',
	        'rules' => 'required|numeric',
	    ),
	    array(
	        'field' => 'programmeCode',
	        'label' => 'lang:pras_field_program_code',
	        'rules' => 'required|numeric',
	    ),
		array(
			'field' => 'description',
		  	'label' => 'lang:pras_field_description',
		  	'rules' => 'trim|alpha_numeric',
		),
		array(
		  	'field' => 'progDuration',
		  	'label' => 'lang:pras_field_duration',
		  	'rules' => 'required|numeric',
		),
	    array(
	        'field' => 'startLevel',
	        'label' => 'lang:pras_field_startLevel',
	        'rules' => 'required|numeric',
	    ),
	    array(
	        'field' => 'endLevel',
	        'label' => 'lang:pras_field_endLevel',
	        'rules' => 'required|0-9',
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
        Method: count_all()
        Counts all students in the system.
        Parameters:
            $get_deleted    - If false, will only return active news_articles. If true,
                will return both deleted and active news_articles.

        Returns: An INT with the number of news_articles found.
    */
    public function count_all($get_deleted = false) {
        if ($get_deleted) {
            // Get only the deleted users
            $this->db->where('programme.deleted !=', 0);
        } else {
            $this->db->where('programme.deleted', 0);
        }

        return $this->db->count_all_results('programme');
    }
}
