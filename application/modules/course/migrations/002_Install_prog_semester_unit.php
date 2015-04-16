<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_prog_semester_unit extends Migration {

	public function up() {
		$this->load->dbforge();
		$prefix = $this->db->dbprefix;

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
		$this->dbforge->add_field('status TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_field('created_on DATETIME NOT NULL');
		$this->dbforge->add_field('deleted TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_key('courseReg_id', TRUE);
		$this->dbforge->create_table('course_registration');
	}

	public function down() {
		$this->load->dbforge();

		$this->dbforge->drop_table('prog_semester_Unit');
		$this->dbforge->drop_table('course_registration');
	}

}
