<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_faculty extends Migration {

	//create a private array of permission for this module
	private $permission_array = array(
        'Faculty.Academic.Add' 		=> 'Allow user to Add new academic faculty and department.',
        'Faculty.Academic.Delete' 	=> 'Allow user to Delete academic faculty and department.',
        'Faculty.Academic.Manage' 	=> 'Allow user to Manage academic faculty(ies) and department(s).',
        'Faculty.Academic.view' 	=> 'Allow user to View academic faculties and departments.',
    );

	public function up() {
            $this->load->dbforge();
            $prefix = $this->db->dbprefix;

            // Use foreach statement to create permission table and assign current to admin if fresh installation
            foreach ($this->permission_array as $name => $description) {
                $this->db->query("INSERT INTO {$prefix}permissions(name, description, status) VALUES('".$name."', '".$description."', 'active')");
                // give current role (or administrators if fresh install) full right to manage permissions
                $this->db->query("INSERT INTO {$prefix}role_permissions VALUES(1,".$this->db->insert_id().")");
            }

	// Create Faculty table
		$this->dbforge->add_field('fac_id 		INT(10) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('fac_name 	VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('fac_dean 	INT(10) NOT NULL');
		$this->dbforge->add_field('description 	TEXT NULL');
		$this->dbforge->add_field('created_on 	DATETIME NOT NULL');
		$this->dbforge->add_field('modified_on 	DATETIME NULL');
		$this->dbforge->add_field('deleted 		TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status 		TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('fac_id', TRUE);

		$this->dbforge->create_table('faculty');

	// Create Department table
		$this->dbforge->add_field('dept_id 		INT(10) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('fac_id 		INT(10) UNSIGNED NOT NULL');
		$this->dbforge->add_field('dept_name 	VARCHAR(255) NOT NULL');
		$this->dbforge->add_field('dept_hod 	INT(10) NOT NULL');
		$this->dbforge->add_field('description 	TEXT NULL');
		$this->dbforge->add_field('created_on 	DATETIME NOT NULL');
		$this->dbforge->add_field('modified_on 	DATETIME NULL');
		$this->dbforge->add_field('deleted 		TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status 		TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('dept_id', TRUE);

		$this->dbforge->create_table('departments');
	}

	public function down() {
            $this->load->dbforge();
            
            $this->dbforge->drop_table('faculty');
            $this->dbforge->drop_table('departments');
		
		foreach ($this->permission_array as $name => $description) {
            $query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name = '".$name."'");
            foreach ($query->result_array() as $row)
            {
                $permission_id = $row['permission_id'];
                $this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
            }
            //delete the role
            $this->db->query("DELETE FROM {$prefix}permissions WHERE (name = '".$name."')");
        }
	}

}
