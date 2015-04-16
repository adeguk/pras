<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class coursebank_model extends MY_Model {

	protected $table_name	= 'courseBank';
	protected $key			= 'course_id';
	protected $set_created	= false;
	protected $set_modified	= false;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

	//get the list of all course Name and ID
    public function coursebank_list() {
        $courses = $this->select('course_id, courseName')->order_by('courseName', 'desc')->find_all_by('coursebank.deleted', 0);
        $allCourses = array();

        foreach($courses as $course) {
            $allCourses[$course->course_id] = $course->courseName;
        }

        return $allCourses;
    }
    /*
        Method: find_all()

        Returns all student records, and their associated status information.

        Parameters:
            $show_deleted   - If false, will only return non-deleted students. If true, will
                return both deleted and non-deleted students.

        Returns: An array of objects with each student's information.
    */
    public function find_all() {
        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, dept_name');
        }

        $this->db->join('departments', 'departments.dept_id = courseBank.dept_id', 'left');

        return parent::find_all();
    }

	//to save:
    public function save_course($type='insert', $id=null) {
        $this->form_validation->set_rules('courseName', 'Course Name', 'required|trim|xss_clean');
        $this->form_validation->set_rules('dept_id', 'Department', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'courseName'=> $this->input->post('courseName'),
            'dept_id'   => $this->input->post('dept_id'),
            'status'    => $this->input->post('status')
        );

        if ($type == 'insert') {
            $return = $this->insert($data);
        }
        else {  // Update
            $return = $this->update($id, $data);
        }

        return $return;
    }
}
