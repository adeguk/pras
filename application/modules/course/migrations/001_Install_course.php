<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_course extends Migration {

	//create a private array of permission for this module
	private $permission_array = array(
    #permission for Academic systems
        'Course.Academic.Add' 		=> 'Allow user to Add new academic study degree as well as departmental programmes.',
        'Course.Academic.Delete' 	=> 'Allow user to Delete academic study degree as well as departmental programmes.',
        'Course.Academic.Manage' 	=> 'Allow user to Manage academic study degree as well as departmental programmes.',
        'Course.Academic.view' 		=> 'Allow user to View academic study degree as well as departmental programmes',
    #permission for setting systems
        'Course.Settings.Add' 		=> 'Allow user to Add new course Settings .',
        'Course.Settings.Delete' 	=> 'Allow user to Delete course Settings .',
        'Course.Settings.Manage' 	=> 'Allow user to Manage course Settings .',
        'Course.Settings.view' 		=> 'Allow user to View course academic ',
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

        // Degree
		$this->dbforge->add_field('deg_id int(10) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('degreeAbbreviation varchar(10) NOT NULL');
		$this->dbforge->add_field('degreeName varchar(50) NOT NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('deg_id', TRUE);
		$this->dbforge->create_table('degree');

		// Course_bank
		$this->dbforge->add_field('course_id int(10) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('dept_id int(10) NOT NULL');
		$this->dbforge->add_field('courseName varchar(100) NOT NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('course_id', TRUE);
		$this->dbforge->create_table('courseBank');

		// Programme
		$this->dbforge->add_field('prog_id int(10) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('course_id int(10) NOT NULL');
		$this->dbforge->add_field('deg_id int(10) NOT NULL');
		$this->dbforge->add_field('studyTypeID int(6) NOT NULL');
		$this->dbforge->add_field('progCode varchar(10) DEFAULT NULL');
		$this->dbforge->add_field('description TEXT NULL');
		$this->dbforge->add_field('progDuration int(6) NOT NULL');
		$this->dbforge->add_field('progStart_level int(6) NOT NULL');
		$this->dbforge->add_field('progEnd_level int(6) NOT NULL');
		$this->dbforge->add_field('created_on DATETIME NOT NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('prog_id', TRUE);
		$this->dbforge->create_table('programme');

		// programme_semester_unit
		$this->dbforge->add_field('progSU_id int(6) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('prog_id int(10) NOT NULL');
		$this->dbforge->add_field('minimumUnit int(3) NOT NULL');
		$this->dbforge->add_field('maximumUnit int(3) NOT NULL');
		$this->dbforge->add_field('progLevel int(6) NOT NULL');
		$this->dbforge->add_field('progSemester int(6) NOT NULL');
		$this->dbforge->add_field('status TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('progSU_id', TRUE);
		$this->dbforge->create_table('prog_semester_unit');

		// course_registration
		$this->dbforge->add_field('courseReg_id int(10) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('user_id int(10) NOT NULL');
		$this->dbforge->add_field('progSubject_id int(10) NOT NULL');
		$this->dbforge->add_field('semester_session_id int(10) NOT NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_key('courseReg_id', TRUE);
		$this->dbforge->create_table('course_registration');
	}

	public function down() {
		$this->load->dbforge();

		$this->dbforge->drop_table('degree');
		$this->dbforge->drop_table('courseBank');
		$this->dbforge->drop_table('programme');
		$this->dbforge->drop_table('prog_semester_Unit');
		$this->dbforge->drop_table('course_registration');

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
