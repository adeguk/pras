<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_subject extends Migration {

	//create a private array of permission for this module
	private $permission_array = array(
        'Subject.Academic.Add' 		=> 'Allow user to Add new programme subject.',
        'Subject.Academic.Delete' 	=> 'Allow user to Delete programme subjects.',
        'Subject.Academic.Manage' 	=> 'Allow user to Manage programme subjects.',
        'Subject.Academic.view' 	=> 'Allow user to View programme subjects.',
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

		// subject_bank
		$this->dbforge->add_field('subject_id       int(10) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('subjectTitle     varchar(100) NOT NULL');
		$this->dbforge->add_field('subjectCode      varchar(10) NOT NULL');
		$this->dbforge->add_field('subjectUnit      int(5) NOT NULL');
		$this->dbforge->add_field('description      TEXT NULL');
		$this->dbforge->add_field('created_on       DATETIME NOT NULL');
		$this->dbforge->add_field('modified_on      DATETIME NULL');
		$this->dbforge->add_field('deleted          TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status           TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('subject_id', TRUE);

		$this->dbforge->create_table('subjectBanks');

		// Programme Subjects
		$this->dbforge->add_field('progSubject_id   int(10) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('subject_id       int(10) NOT NULL');
		$this->dbforge->add_field('course_id        int(10) NOT NULL');
		$this->dbforge->add_field('prog_level       int(6) NOT NULL');
		$this->dbforge->add_field('prog_semester    int(6) NOT NULL');
		$this->dbforge->add_field('compulsory       int(6) NOT NULL');
		$this->dbforge->add_field('progUserId       int(6) NOT NULL');
		$this->dbforge->add_field('created_on       DATETIME NOT NULL');
		$this->dbforge->add_field('deleted          TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status           TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('progSubject_id', TRUE);
		$this->dbforge->create_table('programmeSubjects');
	}

	public function down() {
		$this->load->dbforge();

		$this->dbforge->drop_table('subjectBanks');
		$this->dbforge->drop_table('programmeSubjects');
		
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
