<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_tables extends Migration {

	//create a private array of permission for this module
	private $permission_array = array(
	#permission for Academic systems
        'Student_Manager.Academic.Add' 		=> 'Allow user to Add new Student Manager programmes.',
        'Student_Manager.Academic.Delete' 	=> 'Allow user to Delete Student Manager programmes.',
        'Student_Manager.Academic.Manage' 	=> 'Allow user to Manage Student Manager programmes.',
        'Student_Manager.Academic.view' 	=> 'Allow user to View Student Manager programmes',
 	#permission for reporting systems
        'Student_Manager.Reports.Add' 		=> 'Allow user to Add new Student_Manager Report .',
        'Student_Manager.Reports.Delete' 	=> 'Allow user to Delete Student_Manager Report .',
        'Student_Manager.Reports.Manage' 	=> 'Allow user to Manage Student_Manager Report .',
        'Student_Manager.Reports.view' 		=> 'Allow user to View course academic ',
 	#permission for content systems
        'Student_Manager.Content.Add' 		=> 'Allow user to Add new Student_Manager Content .',
        'Student_Manager.Content.Delete' 	=> 'Allow user to Delete Student_Manager Content .',
        'Student_Manager.Content.Manage' 	=> 'Allow user to Manage Student_Manager Content .',
        'Student_Manager.Content.view' 		=> 'Allow user to View course academic ',
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

        // Students
		$this->dbforge->add_field('studentID int(10) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('user_id int(10) NOT NULL');
		$this->dbforge->add_field('matricNo int(9) NOT NULL');
		$this->dbforge->add_field('jambReg varchar(20) NOT NULL');
		$this->dbforge->add_field('prog_id int(10) NOT NULL');
		$this->dbforge->add_field('level int(10) NOT NULL');
		$this->dbforge->add_field('studyMode int(10) NOT NULL');
		$this->dbforge->add_field('entryMode int(10) NOT NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('studentID', TRUE);
		$this->dbforge->create_table('students'); 
		 
		// create two sample student details   
        $this->db->query("INSERT INTO {$prefix}students VALUES(1, 7, 10000001, '10000001JA', 1, 1, 1, 1, 0, 1)");
        $this->db->query("INSERT INTO {$prefix}students VALUES(2, 8, 10000002, '10000002AB', 1, 2, 1, 2, 0, 1)");
	}

	public function down() {
		$this->load->dbforge();

		$this->dbforge->drop_table('student');

        #$this->db->query("DELETE FROM {$prefix}settings WHERE (module = 'Student_Manager')");

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
