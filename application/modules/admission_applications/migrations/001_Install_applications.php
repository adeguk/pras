<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_applications extends Migration {

	//create a private array of permission for this module
	private $permission_array = array(
	#permission for Content systems
		'Applications.Content.Add' 		=> 'Allow user to Add new content to Applications module',
        'Applications.Content.Delete' 	=> 'Allow user to Delete content from Applications module',
        'Applications.Content.Manage' 	=> 'Allow user to Manage content for Applications module',
        'Applications.Content.view' 	=> 'Allow user to View content of Applications module',
 	#permission for reporting systems
        'Applications.Reports.Add' 		=> 'Allow user to Add new Applications Report .',
        'Applications.Reports.Delete' 	=> 'Allow user to Delete Applications Report .',
        'Applications.Reports.Manage' 	=> 'Allow user to Manage Applications Report .',
        'Applications.Reports.view' 	=> 'Allow user to View Applications Report ',
    #permission for setting systems
        'Applications.Settings.Add' 	=> 'Allow user to Add new Settings for Application.',
        'Applications.Settings.Delete'	=> 'Allow user to Delete Settings for Application.',
        'Applications.Settings.Manage' 	=> 'Allow user to Manage Settings for Application.',
        'Applications.Settings.view' 	=> 'Allow user to View Settings for Applications.',
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

	// Create FORM Builder APP Table
		$this->dbforge->add_field('aca_Session_id 	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('session 			INT(10) NOT NULL');
		$this->dbforge->add_field('startDate 		DATETIME NOT NULL');
		$this->dbforge->add_field('endDate 			DATETIME NOT NULL');
		$this->dbforge->add_field('studyMode 		INT(10) NOT NULL');
		$this->dbforge->add_field('deleted 			TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('status 			TINYINT(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_key('aca_Session_id', TRUE);

		$this->dbforge->create_table('formbuilder');

	// Create Acceptance Table
		$this->dbforge->add_field('sem_session_id 	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('session_semester INT(10) NOT NULL');
		$this->dbforge->add_field('aca_session_id 	INT(10) NOT NULL');
		$this->dbforge->add_field('startDate 		DATETIME NOT NULL');
		$this->dbforge->add_field('endDate 			DATETIME NOT NULL');
		$this->dbforge->add_field('isCurrent 		TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('isRegistration 	TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_field('deleted 			TINYINT(1) NOT NULL DEFAULT 0');
		$this->dbforge->add_key('sem_session_id', TRUE);

		$this->dbforge->create_table('acceptance');
	}

	public function down() {
		$this->load->dbforge();

		$this->dbforge->drop_table('formbuilder');
		$this->dbforge->drop_table('acceptance');

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
