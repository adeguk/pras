<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Additonal_student_options extends Migration {

    /**
 	 * Install this version
 	 *
 	 * @return void
 	 */
    public function up() {
       $this->load->dbforge();

    	// Create Students table
 		$this->dbforge->add_field('id');
 		$this->dbforge->add_field('user_id         INT(11) NOT NULL');
 		$this->dbforge->add_field('matricNo        INT(11) NOT NULL');
 		$this->dbforge->add_field('jamb_reg        VARCHAR(11) DEFAULT NULL');
 		$this->dbforge->add_field('prog_id         INT(6) NOT NULL');
 		$this->dbforge->add_field('progLevel       INT(6) NOT NULL');
 		$this->dbforge->add_field('studyMode       INT(3) NOT NULL');
 		$this->dbforge->add_field('entryMode       INT(3) NOT NULL');
 		$this->dbforge->add_field('created_on      DATETIME NOT NULL');
 		$this->dbforge->add_field('deleted         TINYINT(1) NOT NULL DEFAULT 0');
 		$this->dbforge->add_field('status          TINYINT(1) NOT NULL DEFAULT 1');
 		$this->dbforge->create_table('students');
    }

    /**
      * Uninstall this version
      *
      * @return void
      */
     public function down() {
         $this->dbforge->drop_table('students');
     }

}
