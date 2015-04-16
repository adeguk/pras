<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class programmesubject_model extends MY_Model {

	protected $table_name	= 'programmesubjects';
	protected $key			= 'progSubject_id';
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
    public function find_all() {
        if (empty($this->selects)) {
            $this->select($this->table_name .'.*, subjectTitle, subjectCode, subjectUnit');
        }

        $this->db->join('subjectbanks', 'subjectbanks.subject_id = programmesubjects.subject_id', 'left');
        $this->db->join('programme', 'programme.prog_id = programmesubjects.prog_id', 'left');

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
            $this->select($this->table_name .'.*, subjectTitle, subjectCode, subjectUnit');
        }

        $this->db->join('subjectbanks', 'subjectbanks.subject_id = programmesubjects.subject_id', 'left');
        $this->db->join('programme', 'programme.prog_id = programmesubjects.prog_id', 'left');

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
            $this->db->where('programmesubjects.deleted !=', 0);
        } else {
            $this->db->where('programmesubjects.deleted', 0);
        }

        return $this->db->count_all_results('programmesubjects');
    }

    //to save:
    public function save_progSubject($type='insert', $id=null) {
        $this->form_validation->set_rules('prog_id', 'Programme', 'required|trim');
        $this->form_validation->set_rules('subject_id', 'Course Title', 'required|trim');
        $this->form_validation->set_rules('prog_level', 'Course Level', 'required|trim');
        $this->form_validation->set_rules('prog_semester', 'Course Semester', 'required|trim');
        $this->form_validation->set_rules('compulsory', 'Course Choice', 'required|trim');
        $this->form_validation->set_rules('progUserId', 'Course Adviser', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'prog_id'     => $this->input->post('prog_id'),
            'subject_id'    => $this->input->post('subject_id'),
            'prog_level'    => $this->input->post('prog_level'),
            'prog_semester' => $this->input->post('prog_semester'),
            'compulsory'    => $this->input->post('compulsory'),
            'progUserId'    => $this->input->post('progUserId'),
            'status'        => $this->input->post('status')
        );
        
        $dataUpdate = array(
            'prog_id'     => $this->input->post('prog_id'),
            'subject_id'    => $this->input->post('subject_id'),
            'prog_level'    => $this->input->post('prog_level'),
            'prog_semester' => $this->input->post('prog_semester'),
            'compulsory'    => $this->input->post('compulsory'),
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
