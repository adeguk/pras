<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class programmeSubjectView_model extends MY_Model {

    protected $table_name   = 'programmesubjectview';
    protected $key          = 'progSubj_id';
    protected $set_created  = true;
    protected $set_modified = false;
    protected $soft_deletes = true;
    protected $date_format  = 'datetime';


    /*
        Method: count_by_faculties()
        Returns the number of students that belong to each role.
        Returns: An array of objects representing the number in each role.
    */
    public function count_by_faculties() {
        $prefix = $this->db->dbprefix;

        $sql = "SELECT fac_name, COUNT(*) as count FROM {$prefix}studentView GROUP BY {$prefix}studentView.fac_id";

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
		$query = $this->db->select('fac_name, SUM(level=1) AS L1, SUM(level=2) As L2, SUM(level=3) AS L3, 
				SUM(level=4) As L4, SUM(level=5) AS L5, COUNT(*) AS total')
			->group_by($field);
			//->find_all_by('studyMode',$studymode);
		
        if ($get_deleted) {
            // Get only the deleted users
            $this->db->where('studentView.deleted !=', 0);
        } else {
            $this->db->where('studentView.deleted', 0);
        }
		
		/*if ($status==false) {
            // Get only the deleted users
            return parent::find_all_by('studyMode',$studymode);
        } else {
            return parent::find_all_by(array('studyMode'=>$studymode, 'status'=>$status));
        }*/
		
        return parent::find_all_by(array('studyMode'=>$studymode, 'status'=>$status));
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
    public function delete($id=0, $purge=false) {
        if ($purge === true)   {
            // temporarily set the soft_deletes to true.
            $this->soft_deletes = false;
        }

        return parent::delete($id);
    }
}
   