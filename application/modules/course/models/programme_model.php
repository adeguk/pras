<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class Programme_model extends MY_Model {

	protected $table_name	= 'programme';
	protected $key			= 'prog_id';
	protected $set_created	= true;
	protected $set_modified	= false;
	protected $soft_deletes	= true;
	protected $date_format	= 'datetime';

    /*
        Method: find_all()

        Returns all student records, and their associated status information.

        Parameters:
            $show_deleted   - If false, will only return non-deleted students. If true, will
                return both deleted and non-deleted students.

        Returns: An array of objects with each student's information.
    */
    public function find_all($show_deleted=false) {
        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, courseName, degreeAbbreviation, dept_id');
        }

        if ($show_deleted === false) {
            $this->db->where('programme.deleted', 0);
        }

        $this->db->join('coursebank', 'coursebank.course_id = programme.course_id', 'left');
        $this->db->join('degree', 'degree.deg_id = programme.deg_id', 'left');
        //$this->db->join('departments', 'departments.dept_id = programme.dept_id', 'left');

        #$this->db->where('users.active', 1);

        return parent::find_all();
    }

    /*
        Method: find_by()

        Locates a single student based on a field/value match, with their category information.

        Parameters:
            $field  - A string with the field to match.
            $value  - A string with the value to search for.

        Returns: An object with the user's info, or false on failure.
    */
    public function find_by($field=null, $value=null) {

        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, courseName, degreeAbbreviation, dept_id');
        }

        $this->db->join('coursebank', 'coursebank.course_id = programme.course_id', 'left');
        $this->db->join('degree', 'degree.deg_id = programme.deg_id', 'left');
       // $this->db->join('departments', 'departments.dept_id = programme.dept_id', 'left');

        return parent::find_by($field, $value);
    }
    
    /*
        Method: count_all()
        Counts all students in the system.
        Parameters:
            $get_deleted    - If false, will only return active news_articles. If true,
                will return both deleted and active news_articles.

        Returns: An INT with the number of news_articles found.
    */
    public function count_all($get_deleted = false) {
        if ($get_deleted) {
            // Get only the deleted users
            $this->db->where('programme.deleted !=', 0);
        } else {
            $this->db->where('programme.deleted', 0);
        }

        return $this->db->count_all_results('programme');
    }

	//to save programme:
    public function save_programme($type='insert', $id=null) {
        $this->form_validation->set_rules('course_id', 'Course Name', 'required|trim');
        $this->form_validation->set_rules('deg_id', 'Degree Type', 'required|trim');
        $this->form_validation->set_rules('studyMode', 'Study Mode', 'required|trim');
        $this->form_validation->set_rules('progCode', 'Programme Code', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('progDuration', 'Duration', 'required|trim');
        $this->form_validation->set_rules('progStart_level', 'Programme Start Level', 'required|trim');
        $this->form_validation->set_rules('progEnd_level', 'Programme End Level', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'course_id'	    => $this->input->post('course_id'),
            'deg_id'	    => $this->input->post('deg_id'),
            'studyMode'   => $this->input->post('studyMode'),
            'progCode'      => $this->input->post('progCode'),
            'description'	=> $this->input->post('description'),
            'progDuration'	=> $this->input->post('progDuration'),
            'progStart_level'	=> $this->input->post('progStart_level'),
            'progEnd_level' => $this->input->post('progEnd_level'),
            'status'        => $this->input->post('status')
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
