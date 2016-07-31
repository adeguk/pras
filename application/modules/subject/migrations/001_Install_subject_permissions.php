<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_subject_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Subject.Academic.View',
			'description' => 'View available academic subject(s) for all available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Academic.Create',
			'description' => 'Create academic subject for any available programme',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Academic.Edit',
			'description' => 'Edit academic subject for any available programme',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Academic.Delete',
			'description' => 'Delete academic subject for any available programme',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Content.View',
			'description' => 'View content(s) relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Content.Create',
			'description' => 'Create content relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Content.Edit',
			'description' => 'Edit content(s) relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Content.Delete',
			'description' => 'Delete content(s) relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Reports.View',
			'description' => 'View all report(s) relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Reports.Create',
			'description' => 'Create report relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Reports.Edit',
			'description' => 'Edit report(s) relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Reports.Delete',
			'description' => 'Delete report(s) relating to academic subject(s) for any available programme(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Settings.View',
			'description' => 'View setting(s) relating to academic subject(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Settings.Create',
			'description' => 'Create setting(s) relating to academic subject(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Settings.Edit',
			'description' => 'Edit setting(s) relating to academic subject(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Settings.Delete',
			'description' => 'Delete setting(s) relating to academic subject(s)',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Developer.View',
			'description' => 'View academic subject(s) page for advanced user',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Developer.Create',
			'description' => 'Create academic subject(s) page for advanced user',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Developer.Edit',
			'description' => 'Edit academic subject(s) page for advanced user',
			'status' => 'active',
		),
		array(
			'name' => 'Subject.Developer.Delete',
			'description' => 'Delete academic subject(s) related page by advanced user',
			'status' => 'active',
		),
    );

    /**
     * @var string The name of the permission key in the role_permissions table
     */
    private $permissionKey = 'permission_id';

    /**
     * @var string The name of the permission name field in the permissions table
     */
    private $permissionNameField = 'name';

	/**
	 * @var string The name of the role/permissions ref table
	 */
	private $rolePermissionsTable = 'role_permissions';

    /**
     * @var numeric The role id to which the permissions will be applied
     */
    private $roleId = '1';

    /**
     * @var string The name of the role key in the role_permissions table
     */
    private $roleKey = 'role_id';

	/**
	 * @var string The name of the permissions table
	 */
	private $tableName = 'permissions';

	//--------------------------------------------------------------------

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$rolePermissionsData = array();
		foreach ($this->permissionValues as $permissionValue) {
			$this->db->insert($this->tableName, $permissionValue);

			$rolePermissionsData[] = array(
                $this->roleKey       => $this->roleId,
                $this->permissionKey => $this->db->insert_id(),
			);
		}

		$this->db->insert_batch($this->rolePermissionsTable, $rolePermissionsData);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
        $permissionNames = array();
		foreach ($this->permissionValues as $permissionValue) {
            $permissionNames[] = $permissionValue[$this->permissionNameField];
        }

        $query = $this->db->select($this->permissionKey)
                          ->where_in($this->permissionNameField, $permissionNames)
                          ->get($this->tableName);

        if ( ! $query->num_rows()) {
            return;
        }

        $permissionIds = array();
        foreach ($query->result() as $row) {
            $permissionIds[] = $row->{$this->permissionKey};
        }

        $this->db->where_in($this->permissionKey, $permissionIds)
                 ->delete($this->rolePermissionsTable);

        $this->db->where_in($this->permissionNameField, $permissionNames)
                 ->delete($this->tableName);
	}
}
