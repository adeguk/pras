<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_Course extends Migration {
	/**
	 * @var string The name of the database table
	 */
	private $table_name_1 = 'Degree';
 	private $table_name_2 = 'CourseBank';
 	private $table_name_3 = 'Programme';
 	private $table_name_4 = 'ProgrammeUnit';
 	private $table_name_5 = 'CourseRegistration';

 	/**
 	 * @var array The table's fields
 	 */
 	// Setup Degree fields
 	private $fields_1 = array(
 		'deg_id' => array(
 			'type'       => 'INT',
 			'constraint' => 11,
 			'auto_increment' => TRUE,
 		),
         'degreeName' => array(
             'type'       => 'VARCHAR',
             'constraint' => 50,
             'null'       => FALSE,
         ),
 		'degreeAbbreviation' => array(
             'type'       => 'VARCHAR',
             'constraint' => 10,
             'null'       => FALSE,
         ),
        'deleted' => array(
             'type'       => 'TINYINT',
             'constraint' => 1,
 			 'default'	 => 0,
             'null'       => FALSE,
        ),
        'status' => array(
             'type'       => 'TINYINT',
             'constraint' => 1,
 			 'default'	 => 1,
             'null'       => FALSE,
        ),
 	);
 	// Setup course bank fields
 	private $fields_2 = array(
 	   'course_id' => array(
 		   'type'       => 'INT',
 		   'constraint' => 11,
 		   'auto_increment' => TRUE,
 	   ),
 	   'courseName' => array(
 		   'type'       => 'VARCHAR',
 		   'constraint' => 255,
 		   'null'       => FALSE,
 	   ),
 	   'dept_id' => array(
 		   'type'       => 'INT',
 		   'constraint' => 11,
 		   'null' => FALSE,
 	   ),
 	   'deleted' => array(
 		   'type'       => 'TINYINT',
 		   'constraint' => 1,
 		   'default'	 => 0,
 		   'null'       => FALSE,
 	   ),
 	   'status' => array(
 		   'type'       => 'TINYINT',
 		   'constraint' => 1,
 		   'default'	 => 1,
 		   'null'       => FALSE,
 	   ),
    	);
 	// Setup programme fields
 	private $fields_3 = array(
    	'prog_id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'auto_increment' => TRUE,
    	),
    	'course_id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'null' => FALSE,
    	),
    	'deg_id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'null' => FALSE,
    	),
    	'studyTypeID' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'null' => FALSE,
    	),
    	'programmeCode' => array(
    		'type'       => 'VARCHAR',
    		'constraint' => 5,
    		'null'       => TRUE,
    	),
    	'description' => array(
    		'type'       => 'TEXT',
    		'null' => FALSE,
    	),
    	'progDuration' => array(
    		'type'       => 'TINYINT',
    		'constraint' => 1,
			'default'	 => 3,
    		'null'       => TRUE,
    	),
    	'startLevel' => array(
    		'type'       => 'TINYINT',
    		'constraint' => 2,
			'default'	 => 1,
    		'null'       => TRUE,
    	),
    	'endLevel' => array(
    		'type'       => 'TINYINT',
    		'constraint' => 2,
			'default'	 => 4,
    		'null'       => TRUE,
    	),
    	'created_on' => array(
    		'type'       => 'DATETIME',
    		'null'       => false,
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
 	// Setup Programe Unit fields
	private $fields_4 = array(
    	'id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'auto_increment' => true,
    	),
    	'prog_id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'null'       => false,
    	),
    	'programmeLevel' => array(
    		'type'       => 'TINYINT',
    		'constraint' => 2,
    		'null'       => false,
    	),
    	'sem_session_id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'null' => false,
    	),
    	'minimumUnit' => array(
    		'type'       => 'TINYINT',
    		'constraint' => 1,
			'default'	 => 2,
    		'null'       => false,
    	),
    	'maximumUnit' => array(
    		'type'       => 'TINYINT',
    		'constraint' => 1,
			'default'	 => 4,
    		'null'       => false,
    	),
  	    'deleted' => array(
  		   'type'       => 'TINYINT',
  		   'constraint' => 1,
  		   'default'	 => 0,
  		   'null'       => FALSE,
  	    ),
    	'status' => array(
    		'type'       => 'TINYINT',
    		'constraint' => 1,
    		'default'	 => 1,
    		'null'       => false,
    	),
    );
	// Setup Course Registration fields
 	private $fields_5 = array(
    	'id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'auto_increment' => true,
    	),
    	'studentID' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'null'       => false,
    	),
    	'progSubject_id' => array(
    		'type'       => 'INT',
    		'constraint' => 11,
    		'null' => false,
    	),
    	'sem_session_id' => array(
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
    );

 	/**
 	 * Install this version
 	 *
 	 * @return void
 	 */
 	public function up() {
 		// Create Degree table
 		$this->dbforge->add_field($this->fields_1);
 		$this->dbforge->add_key('deg_id', true);
 		$this->dbforge->create_table($this->table_name_1);

 		// Create CourseBank table
 		$this->dbforge->add_field($this->fields_2);
 		$this->dbforge->add_key('course_id', true);
 		$this->dbforge->create_table($this->table_name_2);

 		// Create Programme table
 		$this->dbforge->add_field($this->fields_3);
 		$this->dbforge->add_key('prog_id', true);
 		$this->dbforge->create_table($this->table_name_3);

 		// Create programme Unit table
 		$this->dbforge->add_field($this->fields_4);
 		$this->dbforge->add_key('id', true);
 		$this->dbforge->create_table($this->table_name_4);

 		// Create Course Registration table
 		$this->dbforge->add_field($this->fields_5);
 		$this->dbforge->add_key('id', true);
 		$this->dbforge->create_table($this->table_name_5);
 	}

 	/**
 	 * Uninstall this version
 	 *
 	 * @return void
 	 */
 	public function down() {
 		$this->dbforge->drop_table($this->table_name_1);
 		$this->dbforge->drop_table($this->table_name_2);
 		$this->dbforge->drop_table($this->table_name_3);
 		$this->dbforge->drop_table($this->table_name_4);
 	}
}
