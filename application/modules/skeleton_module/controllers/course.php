<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class <Context or moduleName> extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('post_model');

        Template::set('toolbar_title', 'Manage my Blog');
        Template::set_block('sub_nav', 'course/_sub_nav');

    }

    public function index() {

        $posts = $this->post_model->where('deleted', 0)->find_all();

        Template::set('posts', $posts);
        Template::render();
    }


    //to create: form display for new post
    public function create() {

        if ($this->input->post('submit')) {
            if ($this->save_post()) {
                Template::set_message('You post was successfully saved.', 'success');
                redirect(SITE_AREA .'/course/welcome');
            }
        }

        Template::set('toolbar_title', 'Create New Post');
        Template::set_view('course/create_post');
        Template::render();
    }

    //to save:
    private function save_post($type='insert', $id=null) {
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('slug', 'Slug', 'trim');
        $this->form_validation->set_rules('body', 'Body', 'required|trim|strip_tags');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'title'	=> $this->input->post('title'),
            'slug'	=> $this->input->post('slug'),
            'body'	=> $this->input->post('body')
        );

        if ($type == 'insert') {
            $return = $this->post_model->insert($data);
        }
        else {  // Update
            $return = $this->post_model->update($id, $data);
        }

        return $return;
    }

    //to edit
    public function edit_post($id=null)  {
        if ($this->input->post('submit')) {
            if ($this->save_post('update', $id)) {
                Template::set_message('You post was successfully editted.', 'success');
                redirect(SITE_AREA .'/course/welcome');
            }
        }

        Template::set('post', $this->post_model->find($id));

        Template::set('toolbar_title', 'Edit Post');
        Template::set_view('course/create_post');
        Template::render();
    }
}
