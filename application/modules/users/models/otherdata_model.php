<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Otherdata_model extends BF_Model {
	protected $table_name	= 'other_data';
	protected $key			= 'id';
	protected $date_format	= 'datetime';

	protected $log_user 	= false;
	protected $set_created	= false;
	protected $set_modified = false;
	protected $soft_deletes	= true;

	protected $created_field     = 'created_on';
	protected $modified_field    = 'modified_on';
	protected $deleted_field     = 'deleted';

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
	protected $return_insert_id = false;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.

	/*protected $validation_rules = array(
		array(
			'field' => 'password',
			'label' => 'lang:bf_password',
			'rules' => 'max_length[120]|valid_password|matches[pass_confirm]',
		),
		array(
			'field' => 'pass_confirm',
			'label' => 'lang:bf_password_confirm',
			'rules' => '',
		),
		array(
			'field' => 'first_name',
			'label' => 'lang:pras_first_name',
			'rules' => 'trim|max_length[255]',
		),
		array(
			'field' => 'middle_name',
			'label' => 'lang:pras_middle_name',
			'rules' => 'trim|max_length[255]',
		),
		array(
			'field' => 'last_name',
			'label' => 'lang:pras_last_name',
			'rules' => 'trim|max_length[255]',
		),
		array(
			'field' => 'language',
			'label' => 'lang:bf_language',
			'rules' => 'required|trim',
		),
		array(
			'field' => 'timezones',
			'label' => 'lang:bf_timezone',
			'rules' => 'required|trim|max_length[40]',
		),
		array(
			'field' => 'username',
			'label' => 'lang:bf_username',
			'rules' => 'trim|max_length[30]',
		),
		array(
			'field' => 'email',
			'label' => 'lang:bf_email',
			'rules' => 'required|trim|valid_email|max_length[254]',
		),
		array(
			'field' => 'role_id',
			'label' => 'lang:us_role',
			'rules' => 'trim|max_length[2]|is_numeric',
		),
	);*/


}
