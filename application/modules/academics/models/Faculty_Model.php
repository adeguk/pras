<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class Faculty_Model extends MY_Model {

	protected $table_name	= 'faculty';
	protected $key			= 'fac_id';
	protected $set_created	= true;
	protected $set_modified	= true;
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
	    	'field' => 'fac_name',
	    	'label' => 'lang:pras_field_faculty',
	    	'rules' => 'required|trim',
	    ),
		array(
	    	'field' => 'fac_code',
	    	'label' => 'lang:pras_field_facultyCode',
	    	'rules' => 'required|trim',
	    ),
	    array(
	    	'field' => 'dean',
	    	'label' => 'lang:pras_field_dean',
	    	'rules' => 'required',
	    ),
	    array(
	    	'field' => 'description',
	    	'label' => 'lang:pras_field_description',
	    	'rules' => 'trim|strip_tags',
	    ),
		array(
	    	'field' => 'status',
	    	'label' => 'lang:pras_field_status',
	    	'rules' => '',
	    ),
	);

	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    //get the list of all faculties Name and ID
    public function facultyList() {
        $records = $this->select('fac_id, fac_name')->order_by('fac_name', 'ASC')->find_all_by('faculty.deleted', 0);
        $faculties = array();

        foreach($records as $faculty) {
            $faculties[$faculty->fac_id] = $faculty->fac_name;
        }

        return $faculties;
    }

    /**
    * Method: find_all()
	*
	* Returns all student records, and their associated status information.
	*
	* Parameters:
	*     $show_deleted   - If false, will only return non-deleted students. If true, will
	*         return both deleted and non-deleted students.
	*
	* Returns: An array of objects with each student's information.
    */
    public function find_all() {
        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, firstname, middlename, lastname')->order_by('fac_name', 'ASC');
        }

        $this->db->join('users', 'users.id = faculty.dean', 'left');

        return parent::find_all();
    }
}
