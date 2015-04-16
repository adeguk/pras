<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Additonal_student_options extends Migration {

    // Student Categories
        $this->dbforge->add_field('`cat_id` int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field("`category` varchar(50) NOT NULL");
        $this->dbforge->add_field("`default` tinyint(1) NOT NULL DEFAULT '0'");
        $this->dbforge->add_key('cat_id', true);
        $this->dbforge->create_table('students_categories');
            
        $this->db->query("INSERT INTO {$prefix}students_categories VALUES(-1, 'Unknown', 0)");
        $this->db->query("INSERT INTO {$prefix}students_categories VALUES(1, 'Default', 1)");

        // Status
        $this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field("`status` varchar(50) NOT NULL");
        $this->dbforge->add_field("`default` tinyint(1) NOT NULL DEFAULT '0'");
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('students_status');
            
        $this->db->query("INSERT INTO {$prefix}students_status VALUES(-1, 'Unknown', 0)");
        $this->db->query("INSERT INTO {$prefix}students_status VALUES(1, 'Alumni', 1)");
        $this->db->query("INSERT INTO {$prefix}students_status VALUES(2, 'Spill Over', 0)");
        $this->db->query("INSERT INTO {$prefix}students_status VALUES(3, 'Rusticated', 0)");
        $this->db->query("INSERT INTO {$prefix}students_status VALUES(4, 'Suspended', 0)");
        $this->db->query("INSERT INTO {$prefix}students_status VALUES(5, 'Deferrer', 0)");
    }
	
	//--------------------------------------------------------------------
	
}