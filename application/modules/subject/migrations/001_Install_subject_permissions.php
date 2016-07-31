<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_forum_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Forum.Academic.View',
			'description' => 'View Forum Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Academic.Create',
			'description' => 'Create Forum Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Academic.Edit',
			'description' => 'Edit Forum Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Academic.Delete',
			'description' => 'Delete Forum Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Content.View',
			'description' => 'View Forum Content',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Content.Create',
			'description' => 'Create Forum Content',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Content.Edit',
			'description' => 'Edit Forum Content',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Content.Delete',
			'description' => 'Delete Forum Content',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Reports.View',
			'description' => 'View Forum Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Reports.Create',
			'description' => 'Create Forum Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Reports.Edit',
			'description' => 'Edit Forum Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Reports.Delete',
			'description' => 'Delete Forum Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Settings.View',
			'description' => 'View Forum Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Settings.Create',
			'description' => 'Create Forum Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Settings.Edit',
			'description' => 'Edit Forum Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Settings.Delete',
			'description' => 'Delete Forum Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Developer.View',
			'description' => 'View Forum Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Developer.Create',
			'description' => 'Create Forum Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Developer.Edit',
			'description' => 'Edit Forum Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Forum.Developer.Delete',
			'description' => 'Delete Forum Developer',
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