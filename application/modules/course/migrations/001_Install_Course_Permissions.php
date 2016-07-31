<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_Course_Permissions extends Migration {
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Course.Academic.View',
			'description' => 'View Course Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Academic.Create',
			'description' => 'Create Course Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Academic.Edit',
			'description' => 'Edit Course Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Academic.Delete',
			'description' => 'Delete Course Academic',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Content.View',
			'description' => 'View Course Content',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Content.Create',
			'description' => 'Create Course Content',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Content.Edit',
			'description' => 'Edit Course Content',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Content.Delete',
			'description' => 'Delete Course Content',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Reports.View',
			'description' => 'View Course Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Reports.Create',
			'description' => 'Create Course Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Reports.Edit',
			'description' => 'Edit Course Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Reports.Delete',
			'description' => 'Delete Course Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Settings.View',
			'description' => 'View Course Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Settings.Create',
			'description' => 'Create Course Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Settings.Edit',
			'description' => 'Edit Course Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Settings.Delete',
			'description' => 'Delete Course Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Developer.View',
			'description' => 'View Course Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Developer.Create',
			'description' => 'Create Course Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Developer.Edit',
			'description' => 'Edit Course Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Course.Developer.Delete',
			'description' => 'Delete Course Developer',
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
	public function up() {
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
	public function down() {
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
