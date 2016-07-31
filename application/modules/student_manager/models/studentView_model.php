<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class studentView_model extends BF_Model {

	protected $table_name	= 'studentview';
    protected $key			= 'student_id';
    protected $date_format	= 'datetime';

    // For performance reasons, you may require your model to NOT return the id
    // of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
    protected $return_insert_id = false;

    // The default type for returned row data.
    protected $return_type = 'object';

	/**
	 * Items that are always removed from data prior to inserts or updates.
	 * @var array
	 */
	protected $protected_attributes = array();

	/**
	 * Returns all student records, and their associated status information.
	 * @param  [type]  $current -A boolean with the value to match the students' status to display.
	 * @param  integer $limit   -An string with the value to search for
	 * @param  integer $offset  [description]
	 * @return [type]           -Return list of students
	 */
	public function get_students( $current = true, $limit = -1, $offset = 0) {
        $students = null;

        if ($limit != -1 && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != -1 && $offset > 0) {
            $this->db->limit($offset,$limit);
        }

        if ($current === true) {
            $this->db->where('status',1);
        }

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $students = $query->result();
        }

        return $students;
    }

    //--------------------------------------------------------------------
	/*
        Method: get_stuent()

        Finds an individual student record. Also returns role information for
        the student.

        Parameters: $student_id - An INT with the student's ID.

        Returns: An object with the student's information.
    */
    public function get_student($student_id = false, $current = true) {

        $student = false;
        if ($student_id === false) {
            $this->errors = "No student ID was received.";
            return false;
        }

        $this->db->where('studentID', $student_id);
        if ( $current === true ) {
            $this->db->where('status',1);
        }

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $student = $query->row();
        }

        $query->free_result();

        return $student;
    }

    /*
        Method: count_by_faculties()
        Returns the number of students that belong to each role.
        Returns: An array of objects representing the number in each role.
    */
    public function count_by_faculties() {
        $prefix = $this->db->dbprefix;

        $sql = "SELECT faculty, COUNT(*) as count FROM {$prefix}studentView GROUP BY {$prefix}studentView.fac_id";

        $query = $this->db->query($sql);

        if ($query->num_rows()) {
            return $query->result();
        }

        return false;
    }

    /*
        Method: count_by_departments()
        Returns the number of students that belong to each role.
        Returns: An array of objects representing the number in each role.
    */
    public function count_by_departments() {
        $prefix = $this->db->dbprefix;

        $sql = "SELECT department, COUNT(*) as count FROM {$prefix}studentView GROUP BY {$prefix}studentView.dept_id";

        $query = $this->db->query($sql);

        if ($query->num_rows()) {
            return $query->result();
        }

        return false;
    }

	/*
        Method: count_all_by_faculty()
        Counts all students in the system.
        Parameters:
			$field  - A string with the field to match.
            $get_deleted    - If false, will only return active students. If true,
                will return both deleted and active students.

        Returns: An INT with the number of students found.
    */
    public function allstudent_by($field = false, $studymode = false, $status = false, $get_deleted = false) {
		$query = $this->db->select('faculty, SUM(level=1) AS L1, SUM(level=2) As L2, SUM(level=3) AS L3,
				SUM(level=4) As L4, SUM(level=5) AS L5, COUNT(*) AS total')
			->group_by($field);
			//->find_all_by('studyMode',$studymode);

        if ($get_deleted) {
            // Get only the deleted users
            $this->db->where('studentView.deleted !=', 0);
        } else {
            $this->db->where('studentView.deleted', 0);
        }

        return parent::find_all_by(array('studyMode'=>$studymode, 'status'=>$status));
    }

    /*
        Method: count_all()
        Counts all students in the system.
        Parameters:
            $get_deleted    - If false, will only return active students. If true,
                will return both deleted and active students.

        Returns: An INT with the number of students found.
    */
    public function count_all($get_deleted = false) {
        if ($get_deleted) {
            // Get only the deleted users
            $this->db->where('studentView.deleted !=', 0);
        } else {
            $this->db->where('studentView.deleted', 0);
        }

        return $this->db->count_all_results('studentView');
    }

    //--------------------------------------------------------------------

    public function get_students_faculties() {
        $query = $this->db->select('id, fac_name')->get('faculty');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    //--------------------------------------------------------------------

    public function get_students_departments() {
        $query = $this->db->select('id, dept_name')->get('department');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    /*
        Method: count_all()
        Counts all students in the system.
        Parameters:
            $get_deleted    - If false, will only return active news_articles. If true,
                will return both deleted and active news_articles.
        Returns:
            An INT with the number of news_articles found.
    */
    public function count_all_by_field($field = false, $value = false, $get_deleted = false) {

        $this->db->where($field,$value);
        if ($get_deleted)   {
            // Get only the deleted users
            $this->db->where('studentView.deleted !=', 0);
        } else {
            $this->db->where('studentView.deleted', 0);
        }

        return $this->db->count_all_results('studentView');
    }

    /*
        Method: delete()
        Performs a standard delete, but also allows for purging of a record.
        Parameters:
            $id     - An INT with the record ID to delete.
            $purge  - If false, will perform a soft-delete. If true, will permenantly
                delete the record.
        Returns:
            true/false
    */
    /*public function delete($id=0, $purge=false) {
        if ($purge === true)   {
            // temporarily set the soft_deletes to true.
            $this->soft_deletes = false;
        }

        return parent::delete($id);
    }*/
}
