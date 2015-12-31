<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller {
    protected $permissionCreate = 'Student_manager.Content.Create';
    protected $permissionDelete = 'Student_manager.Content.Delete';
    protected $permissionEdit   = 'Student_Manager.Content.Edit';
    protected $permissionView   = 'Student_manager.Content.View';

    public function __construct() {
        parent::__construct();

        $this->auth->restrict($this->permissionView);

        Template::set('toolbar_title', 'Student Management Reports');
        Template::set_block('sub_nav', 'reports/_sub_nav');
    }

    public function index() {
        $this->load->model('studentView_model');
        // get top 5 Faculty
        Template::set('top_faculties',
			$this->studentView_model->select('COUNT(*) AS total, faculty')
                ->group_by('studentView.fac_id')
                ->limit(5)
                ->order_by('total', 'DESC')
                ->find_all() );

        // get top 5 departments
        Template::set('top_departments',
			$this->studentView_model->select('COUNT(*) AS total, department')
                ->group_by('studentView.dept_id')
                ->limit(5)
                ->order_by('total', 'DESC')
                ->find_all() );

        // get top 5 lossing departments
        Template::set('down_departments',
			$this->studentView_model->select('COUNT(*) AS total, department')
                ->group_by('studentView.dept_id')
                ->limit(5)
                ->order_by('total', 'Asc')
                ->find_all() );

		// get breakdown by study mode
        Template::set('studymodes',
			$this->studentView_model->select('COUNT(*) AS total, studyMode')
                ->group_by('studentView.studyMode')
                ->find_all() );
		// get breakdown by student status
        Template::set('byStatus',
			$this->studentView_model->select('COUNT(*) AS total, status')
                ->group_by('studentView.status')
                ->find_all() );

        // get all fulltime students by faculty and level
        Template::set('allCounts', $this->studentView_model->allstudent_by('fac_id', 1, 1));
        Template::set('allNons', $this->studentView_model->allstudent_by('fac_id', 1, 2));
        Template::render();
    }

    //to create: form display for new programme semester unit
    public function registrations() {
        $this->auth->restrict('Student_Manager.Reports.View', SITE_AREA.'/reports/student_manager');

        Template::set('regFaculty', $this->registration_submission_model->regFaculty())
                ->group_by('students.fac_id')
                ->limit(5)
                ->order_by('student_count', 'DESC')
                ->find_all() ;

        Template::set_view('reports/registrations');
        Template::render();
    }
}
