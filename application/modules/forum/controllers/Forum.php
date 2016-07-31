<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Forum controller
 */
class Forum extends Front_Controller
{
    protected $permissionCreate = 'Forum.Forum.Create';
    protected $permissionDelete = 'Forum.Forum.Delete';
    protected $permissionEdit   = 'Forum.Forum.Edit';
    protected $permissionView   = 'Forum.Forum.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('forum/forum_model');
        $this->lang->load('forum');
        
        

        Assets::add_module_js('forum', 'forum.js');
    }

    /**
     * Display a list of Forum data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        $records = $this->forum_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}