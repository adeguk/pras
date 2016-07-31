<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_forum extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'forum';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'field1' => array(
            'type'       => 'TEXT',
            'null'       => false,
        ),
        'field2' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'field3' => array(
            'type'       => 'INT',
            'null'       => true,
        ),
        'field4' => array(
            'type'       => 'VARCHAR',
            'constraint' => 10,
            'null'       => true,
        ),
        'field5' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
        ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}