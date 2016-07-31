<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class SemesterSession_Model extends MY_Model {

	protected $table_name	= 'SemesterSession';
	protected $key			= 'sem_session_id';
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
			'field' => 'session_semester',
	        'label' => 'lang:pras_field_semester',
	        'rules' => 'required',
	    ),
	    array(
	    	'field' => 'aca_session_id',
	        'label' => 'lang:pras_field_session',
	        'rules' => 'required',
	    ),
	    array(
	        'field' => 'startDate',
	        'label' => 'lang:pras_field_startDate',
	        'rules' => 'required',
	    ),
	    array(
	        'field' => 'endDate',
	        'label' => 'lang:pras_field_endDate',
	        'rules' => 'required',
	    ),
		array(
			'field' => 'isCurrent',
		  	'label' => 'lang:pras_field_isCurrent',
		  	'rules' => '',
		),
		array(
		  	'field' => 'isRegistration',
		  	'label' => 'lang:pras_field_isRegistration',
		  	'rules' => '',
		),
	);

	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    public function find_all() {
        if (empty($this->selects)) $this->select($this->table_name .'.*, session, studyMode');

        $this->db->join('AcademicSession', 'AcademicSession.aca_Session_id = SemesterSession.aca_session_id', 'left');

		return parent::find_all();
    }

    public function find_by($field = '', $value = '', $type = 'and') {
        $this->db->join('AcademicSession', 'AcademicSession.aca_Session_id = SemesterSession.aca_session_id', 'left');

        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, AcademicSession.aca_Session_id, session, AcademicSession.startDate, AcademicSession.endDate, studyMode');
        }

        return parent::find_by($field, $value);
    }

    //--------------------------------------------------------------------
    public function get_CurrentSession( $isCurrent = true) {
        $SemesterSessions = null;

        $today = date("Y-m-d H:m:s");

        if ($isCurrent === true) {
            $this->db->join('AcademicSession', 'AcademicSession.aca_session_id = SemesterSession.aca_session_id', 'left');
            $where = array('isCurrent'=> 1,'SemesterSession.startDate <=' => $today, 'SemesterSession.endDate >' => $today);
            $this->db->where($where);
        }

        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, session, AcademicSession.studyMode');
            $this->db->where('AcademicSession.status',1);
        }

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {
            $SemesterSessions = $query->result();
        }

        return $SemesterSessions;
    }
}
