<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_Academics extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name_1 = 'Faculty';
	private $table_name_2 = 'Department';
	private $table_name_3 = 'AcademicSession';
	private $table_name_4 = 'SemesterSession';

	/**
	 * @var array The table's fields
	 */
	// Setup Faculty fields
	private $fields_1 = array(
		'fac_id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'fac_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
		'fac_code' => array(
            'type'       => 'VARCHAR',
            'constraint' => 5,
            'null'       => false,
        ),
        'dean' => array(
            'type'       => 'INT',
            'constraint' => 10,
            'null'       => false,
        ),
		'created_on' => array(
            'type'       => 'DATETIME',
            'null'       => false,
        ),
        'modified_on' => array(
            'type'       => 'DATETIME',
            'null'       => true,
        ),
        'deleted' => array(
            'type'       => 'BIT',
            'constraint' => 1,
			'default'	 => 0,
            'null'       => false,
        ),
        'status' => array(
            'type'       => 'BIT',
            'constraint' => 1,
			'default'	 => 1,
            'null'       => false,
        ),
	);
	// Setup Department fields
	private $fields_2 = array(
	   'dept_id' => array(
		   'type'       => 'INT',
		   'constraint' => 11,
		   'auto_increment' => true,
	   ),
	   'fac_id' => array(
		   'type'       => 'INT',
		   'constraint' => 11,
		   'null' => false,
	   ),
	   'dept_name' => array(
		   'type'       => 'VARCHAR',
		   'constraint' => 255,
		   'null'       => false,
	   ),
	   'dept_code' => array(
	   		'type'       => 'VARCHAR',
	   		'constraint' => 5,
	   		'null'       => false,
	   	),
	    'hod' => array(
		   'type'       => 'INT',
		   'constraint' => 10,
		   'null'       => false,
	   ),
	   'created_on' => array(
		   'type'       => 'DATETIME',
		   'null'       => false,
	    ),
	   'modified_on' => array(
		   'type'       => 'DATETIME',
		   'null'       => true,
	   ),
	   'deleted' => array(
		   'type'       => 'TINYINT',
		   'constraint' => 1,
		   'default'	 => 0,
		   'null'       => false,
	   ),
	   'status' => array(
		   'type'       => 'TINYINT',
		   'constraint' => 1,
		   'default'	 => 1,
		   'null'       => false,
	   ),
   	);
	// Setup AcademicSession fields
	private $fields_3 = array(
   	   'aca_Session_id' => array(
   		   'type'       => 'INT',
   		   'constraint' => 11,
   		   'auto_increment' => true,
   	   ),
   	   'session' => array(
   		   'type'       => 'INT',
   		   'constraint' => 11,
   		   'null' => false,
   	   ),
   	   'startDate' => array(
   		   'type'       => 'DATE',
   		   'null'       => false,
   	   ),
   	   'endDate' => array(
   		   'type'       => 'DATE',
   		   'null'       => false,
   	   ),
   	   'studyMode' => array(
   		   'type'       => 'INT',
   		   'constraint' => 11,
   		   'null' => false,
   	   ),
   	   'deleted' => array(
   		   'type'       => 'TINYINT',
   		   'constraint' => 1,
   		   'default'	 => 0,
   		   'null'       => false,
   	   ),
   	   'status' => array(
   		   'type'       => 'TINYINT',
   		   'constraint' => 1,
   		   'default'	 => 1,
   		   'null'       => false,
   	   ),
   	);
	// Setup SemesterSession fields
	private $fields_4 = array(
   	   'sem_session_id' => array(
   		   'type'       => 'INT',
   		   'constraint' => 11,
   		   'auto_increment' => true,
   	   ),
   	   'session_semester' => array(
   		   'type'       => 'INT',
   		   'constraint' => 11,
   		   'null'       => false,
   	   ),
   	   'aca_session_id' => array(
   		   'type'       => 'INT',
   		   'constraint' => 11,
   		   'null' => false,
   	   ),
   	   'startDate' => array(
   		   'type'       => 'DATE',
   		   'null'       => false,
   	   ),
   	   'endDate' => array(
   		   'type'       => 'DATE',
   		   'null'       => false,
   	   ),
   	   'isCurrent' => array(
   		   'type'       => 'TINYINT',
   		   'constraint' => 1,
   		   'default'	 => 0,
   		   'null'       => false,
   	   ),
   	   'isRegistration' => array(
   		   'type'       => 'TINYINT',
   		   'constraint' => 1,
   		   'default'	 => 0,
   		   'null'       => false,
   	   ),
   	   'deleted' => array(
   		   'type'       => 'TINYINT',
   		   'constraint' => 1,
   		   'default'	 => 0,
   		   'null'       => false,
   	   ),
   	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		// Create Faculty table
		$this->dbforge->add_field($this->fields_1);
		$this->dbforge->add_key('fac_id', true);
		$this->dbforge->create_table($this->table_name_1);

		// Create Department table
		$this->dbforge->add_field($this->fields_2);
		$this->dbforge->add_key('dept_id', true);
		$this->dbforge->create_table($this->table_name_2);

		// Create AcademicSession table
		$this->dbforge->add_field($this->fields_3);
		$this->dbforge->add_key('aca_Session_id', true);
		$this->dbforge->create_table($this->table_name_3);

		// Create SemesterSession table
		$this->dbforge->add_field($this->fields_4);
		$this->dbforge->add_key('sem_session_id', true);
		$this->dbforge->create_table($this->table_name_4);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name_1);
		$this->dbforge->drop_table($this->table_name_2);
		$this->dbforge->drop_table($this->table_name_3);
		$this->dbforge->drop_table($this->table_name_4);
	}
}
