<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_Subject extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name_1 = 'SubjectBank';
    private $table_name_2 = 'ProgrammeSubject';

	// Setup subject bank fields
	private $fields_1 = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'subjectTitle' => array(
            'type'       => 'VARCHAR',
			'constraint' => 100,
            'null'       => false,
        ),
        'subjectCode' => array(
            'type'       => 'VARCHAR',
            'constraint' => 10,
            'null'       => false,
        ),
        'subjectUnit' => array(
            'type'       => 'TINYINT',
            'constraint' => 1,
            'null'       => true,
        ),
        'description' => array(
            'type'       => 'TEXT',
            'null'       => true,
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

	// Setup programme subject fields
	private $fields_2 = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
		'subject_id' => array(
			'type'       => 'INT',
			'constraint' => 11,
            'null'       => false,
		),
		'prog_id' => array(
			'type'       => 'INT',
			'constraint' => 11,
            'null'       => false,
		),
		'level' => array(
			'type'       => 'TINYINT',
			'constraint' => 1,
            'null'       => false,
		),
		'semester' => array(
			'type'       => 'INT',
			'constraint' => 6,
            'null'       => false,
		),
		'compulsory' => array(
			'type'       => 'TINYINT',
			'constraint' => 1,
			'default'	 => 1,
            'null'       => false,
		),
        'user_id' => array(
            'type'       => 'INT',
            'constraint' => 11,
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
			'null'       => FALSE,
	   ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up() {
 		// Create Subject bank table
		$this->dbforge->add_field($this->fields_1);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name_1);

	 	// Create programmeSubject table
		$this->dbforge->add_field($this->fields_2);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name_2);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down() {
		$this->dbforge->drop_table($this->table_name_1);
		$this->dbforge->drop_table($this->table_name_2);
	}
}
