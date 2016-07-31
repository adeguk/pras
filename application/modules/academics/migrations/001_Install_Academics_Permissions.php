<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_Academics_Permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Academics.Academic.View',
			'description' => 'View other Academically related content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Academic.Create',
			'description' => 'Create other Academically related content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Academic.Edit',
			'description' => 'Edit other Academically related content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Academic.Delete',
			'description' => 'Delete other Academically related content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Content.View',
			'description' => 'View Academics Content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Content.Create',
			'description' => 'Create Academics Content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Content.Edit',
			'description' => 'Edit Academics Content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Content.Delete',
			'description' => 'Delete Academics Content relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Reports.View',
			'description' => 'View Academics Reports relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Reports.Create',
			'description' => 'Create Academics Reports relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Reports.Edit',
			'description' => 'Edit Academics Reports relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Reports.Delete',
			'description' => 'Delete Academics Reports relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Settings.View',
			'description' => 'View Academics Settings relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Settings.Create',
			'description' => 'Create Academics Settings relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Settings.Edit',
			'description' => 'Edit Academics Settings relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Settings.Delete',
			'description' => 'Delete Academics Settings relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Developer.View',
			'description' => 'View Academics Developer relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Developer.Create',
			'description' => 'Create Academics Developer relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Developer.Edit',
			'description' => 'Edit Academics Developer relating to Faculty, Department and Sessions',
			'status' => 'active',
		),
		array(
			'name' => 'Academics.Developer.Delete',
			'description' => 'Delete Academics Developer relating to Faculty, Department and Sessions',
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
