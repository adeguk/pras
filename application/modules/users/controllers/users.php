<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Users Controller
 *
 * Provides front-end functions for users, like login and logout.
 *
 * @package    Bonfire
 * @subpackage Modules_Users
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://cibonfire.com
 *
 */
class Users extends Front_Controller {

	//--------------------------------------------------------------------

	/**
	 * Setup the required libraries etc
	 *
	 * @retun void
	 */
	public function __construct() {
		parent::__construct();

		#Add assets resources for jQuery date picker
       #Assets::add_js('http://code.jquery.com/ui/1.10.3/jquery-ui.js');    
        #Assets::add_css('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
        #Assets::add_js($this->load->view('users/datepicker_inline.js', null, true) , 'inline');

        Assets::add_css( array(
			css_path() . 'chosen.css',
			css_path() . 'bootstrap-datepicker.css'
		));

		Assets::add_js( array(
			js_path() . 'chosen.jquery.min.js',
			js_path() . 'bootstrap-datepicker.js'
		));

        $this->load->model(array('users/user_model', 'education_model', 'otherdata_model', 'course/programme_model', 'course/degree_model'));

		$this->lang->load('users');

	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Presents the login function and allows the user to actually login.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function login() {
		// if the user is not logged in continue to show the login page
		if ($this->auth->is_logged_in() === FALSE) {
			if (isset($_POST['log-me-in'])) {
				$remember = $this->input->post('remember_me') == '1' ? TRUE : FALSE;

				// Try to login
				if ($this->auth->login($this->input->post('login'), $this->input->post('password'), $remember) === TRUE) {

					// Log the Activity
					log_activity($this->auth->user_id(), lang('us_log_logged') . ': ' . $this->input->ip_address(), 'users');

					// Now redirect.  (If this ever changes to render something,
					// note that auth->login() currently doesn't attempt to fix
					// `$this->current_user` for the current page load).

					/*
						In many cases, we will have set a destination for a
						particular user-role to redirect to. This is helpful for
						cases where we are presenting different information to different
						roles that might cause the base destination to be not available.
					*/
					if ($this->settings_lib->item('auth.do_login_redirect') && !empty ($this->auth->login_destination)) {
						Template::redirect($this->auth->login_destination);
					}
					else {
						if (!empty($this->requested_page)) {
							Template::redirect($this->requested_page);
						}
						else
						{
							Template::redirect('/');
						}
					}
				}//end if
			}//end if

			Template::set_view('users/users/login');
			Template::set('page_title', 'Login');
			Template::render('login');
		}
		else
		{

			Template::redirect('/');
		}//end if
	}//end login()

	//--------------------------------------------------------------------

	/**
	 * Calls the auth->logout method to destroy the session and cleanup,
	 * then redirects to the home page.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function logout()	{
		if (isset($this->current_user->id))	{
			// Login session is valid.  Log the Activity
			log_activity($this->current_user->id, lang('us_log_logged_out') . ': ' . $this->input->ip_address(), 'users');
		}

		// Always clear browser data (don't silently ignore user requests :).
		$this->auth->logout();

		redirect('/');
	}//end  logout()

	//--------------------------------------------------------------------

	/**
	 * Allows a user to start the process of resetting their password.
	 * An email is allowed with a special temporary link that is only valid
	 * for 24 hours. This link takes them to reset_password().
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function forgot_password()	{
		// if the user is not logged in continue to show the login page
		if ($this->auth->is_logged_in() === FALSE) {
			if (isset($_POST['send'])) {
				$this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|valid_email');

				if ($this->form_validation->run() !== FALSE) {
					// We validated. Does the user actually exist?
					$user = $this->user_model->find_by('email', $_POST['email']);

					if ($user !== FALSE) {
						// User exists, so create a temp password.
						$this->load->helpers(array('string', 'security'));

						$pass_code = random_string('alnum', 40);

						$hash = do_hash($pass_code . $_POST['email']);

						// Save the hash to the db so we can confirm it later.
						$this->user_model->update_where('email', $_POST['email'], array('reset_hash' => $hash, 'reset_by' => strtotime("+24 hours") ));

						// Create the link to reset the password
						$pass_link = site_url('reset_password/'. str_replace('@', ':', $_POST['email']) .'/'. $hash);

						// Now send the email
						$this->load->library('emailer/emailer');

						$data = array(
									'to'	=> $_POST['email'],
									'subject'	=> lang('us_reset_pass_subject'),
									'message'	=> $this->load->view('_emails/forgot_password', array('link' => $pass_link), TRUE)
							 );

						if ($this->emailer->send($data)) {
							Template::set_message(lang('us_reset_pass_message'), 'success');
						}
						else {
							Template::set_message(lang('us_reset_pass_error'). $this->emailer->error, 'error');
						}
					}
					else {
						Template::set_message(lang('us_invalid_email'), 'error');
					}//end if
				}//end if
			}//end if

			Template::set_view('users/users/forgot_password');
			Template::set('page_title', 'Password Reset');
			Template::render();
		}
		else {
			Template::redirect('/');
		}//end if
	}//end forgot_password()

	//--------------------------------------------------------------------

	/**
	 * Allows a user to edit their own profile information.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function view_profile() {

		// Make sure we're logged in.
		$this->auth->restrict();
		$this->set_current_user();

		$this->load->helper('date');

		$this->load->config('address');
		$this->load->helper('address');

		$this->load->config('user_meta');
		$meta_fields = config_item('user_meta_fields');

		Template::set('meta_fields', $meta_fields);

		// get the current user information
		$user = $this->user_model->find_user_and_meta($this->current_user->id);
		// get the current user other information
		$other = $this->otherdata_model->find_by('user_id',$this->current_user->id);
		// get the current user educational information
		$education = $this->education_model->find_all_by('user_id',$this->current_user->id);

		Template::set('user', $user);
		Template::set('other', $other);
		Template::set('education', $education);
		Template::set('languages', unserialize($this->settings_lib->item('site.languages')));

		Template::set_view('users/users/view_profile');
		Template::render();
	}

	//--------------------------------------------------------------------

	/**
	 * Allows a user to edit their own profile information.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function edit_profile()	{
		// Make sure we're logged in.
		$this->auth->restrict();
		$this->set_current_user();

		$this->load->helper('date');

		$this->load->config('address');
		$this->load->helper('address');

		$this->load->config('user_meta');
		$meta_fields = config_item('user_meta_fields');

		Template::set('meta_fields', $meta_fields);

		if (isset($_POST['save'])) 	{

			$user_id = $this->current_user->id;
			if ($this->save_user($user_id, $meta_fields)) {

				$meta_data = array();
				foreach ($meta_fields as $field) {
					if ((!isset($field['admin_only']) || $field['admin_only'] === FALSE
						|| (isset($field['admin_only']) && $field['admin_only'] === TRUE
							&& isset($this->current_user) && $this->current_user->role_id == 1))
						&& (!isset($field['frontend']) || $field['frontend'] === TRUE))
					{
						$meta_data[$field['name']] = $this->input->post($field['name']);
					}
				}

				// now add the meta is there is meta data
				$this->user_model->save_meta_for($user_id, $meta_data);

				// Log the Activity

				$user = $this->user_model->find($user_id);
				$log_name = (isset($user->display_name) && !empty($user->display_name)) ? $user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $user->username : $user->email);
				log_activity($this->current_user->id, lang('us_log_edit_profile') . ': ' . $log_name, 'users');

				Template::set_message(lang('us_profile_updated_success'), 'success');

				// redirect to make sure any language changes are picked up
				Template::redirect('/users/edit_profile');
			}
			else {
				Template::set_message(lang('us_profile_updated_error'), 'error');
			}//end if
		}//end if

		// get the current user information
		$user = $this->user_model->find_user_and_meta($this->current_user->id);

        $settings = $this->settings_lib->find_all();
        if ($settings['auth.password_show_labels'] == 1) {
            Assets::add_module_js('users','password_strength.js');
            Assets::add_module_js('users','jquery.strength.js');
            Assets::add_js($this->load->view('users_js', array('settings'=>$settings), true), 'inline');
        }
        // Generate password hint messages.
		$this->user_model->password_hints();

		Template::set('user', $user);
		Template::set('languages', unserialize($this->settings_lib->item('site.languages')));

		Template::set_view('users/users/edit_profile');
		Template::render();

	}//end edit_profile()

	/**
	 * Allows a user to edit their own profile educational history information.
	 *
	 * @access public
	 *
	 * @return void
	 */	
    public function profile_education() {
		// Make sure we're logged in.
		$this->auth->restrict();
		$this->set_current_user();

		$user_id = $this->current_user->id;

		$this->load->helper('date');

        if ($this->input->post('submit')) {
            if ($this->save_education()) {

                // Log the Activity
				$user = $this->user_model->find($user_id);
				$log_name = (isset($user->display_name) && !empty($user->display_name)) ? $user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $user->username : $user->email);
				log_activity($this->current_user->id, lang('us_log_edit_profile') . ': ' . $log_name, 'users');
                Template::set_message(lang('us_profile_updated_success'), 'success');

				// redirect to make sure any language changes are picked up
				Template::redirect('/users/profile_education');
			}
			else {
				Template::set_message(lang('us_profile_updated_error'), 'error');
			}//end if
        }

        // get and set the current user information
		Template::set('user', $user = $this->user_model->find_user_and_meta($this->current_user->id));

        $education = $this->education_model->find_all_by('user_id',$user_id);
        Template::set('education', $education);
        Template::set_view('users/users/profile_education');
        Template::render();
    }//end profile: Educational history()

	/**
	 * Allows a user to delete a row or all profile educational history data from the database.
	 *
	 * @access public
	 *
	 * @param int   $id          The id of the user in the case of an insert operation
	 * @param type  $type 		 'insert' or 'update' in case of create or edit operation
	 *
	 * @return void
	 */	
    public function delete_edu_data() {

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->education_model->delete($id);

                // Log the activity
                #$this->activity_model->log_activity($this->auth->user_id(), 'Department with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'faculty');
            }
            Template::set_message('Your Educational data was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Your Educational data was not successfully deleted.', 'error');
        }

        redirect('/users/profile_education');
    }//end of delete_edu_data()

	/**
	 * Allows a user to edit their own profile information.
	 *
	 * @access public
	 *
	 * @return void
	 */
	#public function profile()
		//to create: form display for new post
    public function create_other_data($user_id='') {
    	// Make sure we're logged in.
		
		if ($user_id != $this->current_user->id) {
			$this->auth->restrict('Bonfire.Users.Manage');
		}
		
        if ($this->input->post('submit')) {
            if ($this->save_other_data('insert',$user_id)) {
                // Log the Activity
				$user = $this->user_model->find($user_id);
				$log_name = (isset($user->display_name) && !empty($user->display_name)) ? $user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $user->username : $user->email);
				log_activity($this->current_user->id, lang('us_log_edit_profile') . ': ' . $log_name, 'users');
                Template::set_message(lang('us_profile_updated_success'), 'success');
                redirect('/users/other_data');
            }
        }

        Template::set('toolbar_title', lang('us_edit_user'));
        Template::set_view('users/users/create_other_data');
        Template::render();
    }

	//--------------------------------------------------------------------

	/**
	 * Allows a user to edit their own profile information.
	 *
	 * @access public
	 *
	 * @return void
	 */
	#public function profile()
	public function other_data($id='')	{
		// if there is no id passed in edit the current user
		// this is so we don't have to pass the user id in the url for editing the current users profile
		if (empty($user_id)) {
			$user_id = $this->current_user->id;
		}

		if (empty($user_id)) {
			Template::set_message(lang('us_empty_id'), 'error');
			redirect('/users/other_data');
		}

		if ($user_id != $this->current_user->id) {
			$this->auth->restrict('Bonfire.Users.Manage');
		}

        if ($this->input->post('submit')) {
            if ($this->save_other_data('update', $id)) {
                // Log the Activity
				$user = $this->user_model->find($user_id);
				$log_name = (isset($user->display_name) && !empty($user->display_name)) ? $user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $user->username : $user->email);
				log_activity($this->current_user->id, lang('us_log_edit_profile') . ': ' . $log_name, 'users');
                Template::set_message(lang('us_profile_updated_success'), 'success');

				// redirect to make sure any language changes are picked up
				redirect($this->uri->uri_string());
			}
			else {
				Template::set_message(lang('us_profile_updated_error'), 'error');
			}//end if
        }
        
        // get and set the current user information
		Template::set('user', $user = $this->user_model->find_user_and_meta($this->current_user->id));
        Template::set('post', $this->otherdata_model->find($id));
        Template::set('toolbar_title', lang('us_edit_user'));

        Template::set_view('users/users/other_data');
        Template::render();
	}//end profile: others()

	/**
	 * Allows a user to delete a row or all profile educational history data from the database.
	 *
	 * @access public
	 *
	 * @param int   $id          The id of the user in the case of an insert operation
	 * @param type  $type 		 'insert' or 'update' in case of create or edit operation
	 *
	 * @return void
	 */	
    public function delete_other_data() {

        if ($checked = $this->input->post('checked')) {
            foreach ($checked as $id) {
                $this->education_model->delete($id);

                // Log the activity
                #$this->activity_model->log_activity($this->auth->user_id(), 'Department with ID: '. $id . ' deleted : ' . $this->input->ip_address(), 'faculty');
            }
            Template::set_message('Data was successfully deleted.', 'success');
        }
        else {
            Template::set_message('Data was not successfully deleted.', 'error');
        }

        redirect('/users/other_data');
    }//end of delete_other_data()

	//--------------------------------------------------------------------

	/**
	 * Allows the user to create a new password for their account. At the moment,
	 * the only way to get here is to go through the forgot_password() process,
	 * which creates a unique code that is only valid for 24 hours.
	 *
	 * Since 0.7 this method is also gotten to here by the force_password_reset
	 * security features.
	 *
	 * @access public
	 *
	 * @param string $email The email address to check against.
	 * @param string $code  A randomly generated alphanumeric code. (Generated by forgot_password() ).
	 *
	 * @return void
	 */
	public function reset_password($email='', $code='')	{
		// if the user is not logged in continue to show the login page
		if ($this->auth->is_logged_in() === FALSE)
		{
			// If we're set here via Bonfire and not an email link
			// then we might have the email and code in the session.
			if (empty($code) && $this->session->userdata('pass_check'))
			{
				$code = $this->session->userdata('pass_check');
			}

			if (empty($email) && $this->session->userdata('email'))
			{
				$email = $this->session->userdata('email');
			}

			// If there is no code, then it's not a valid request.
			if (empty($code) || empty($email))
			{
				Template::set_message(lang('us_reset_invalid_email'), 'error');
				Template::redirect('/login');
			}

			// Handle the form
			if (isset($_POST['set_password']))
			{
				$this->form_validation->set_rules('password', 'lang:bf_password', 'required|max_length[120]|valid_password');
				$this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', 'required|matches[password]');

				if ($this->form_validation->run() !== FALSE)
				{
					// The user model will create the password hash for us.
					$data = array('password' => $this->input->post('password'),
					              'reset_by'	=> 0,
					              'reset_hash'	=> '',
					              'force_password_reset' => 0);

					if ($this->user_model->update($this->input->post('user_id'), $data))
					{
						// Log the Activity
						log_activity($this->input->post('user_id'), lang('us_log_reset') , 'users');

						Template::set_message(lang('us_reset_password_success'), 'success');
						Template::redirect('/login');
					}
					else
					{
						Template::set_message(sprintf(lang('us_reset_password_error'), $this->user_model->error), 'error');

					}
				}
			}//end if

			// Check the code against the database
			$email = str_replace(':', '@', $email);
			$user = $this->user_model->find_by(array(
                                        'email' => $email,
										'reset_hash' => $code,
										'reset_by >=' => time()
                                   ));

			// It will be an Object if a single result was returned.
			if (!is_object($user))
			{
				Template::set_message( lang('us_reset_invalid_email'), 'error');
				Template::redirect('/login');
			}

            $settings = $this->settings_lib->find_all();
            if ($settings['auth.password_show_labels'] == 1) {
                Assets::add_module_js('users','password_strength.js');
                Assets::add_module_js('users','jquery.strength.js');
                Assets::add_js($this->load->view('users_js', array('settings'=>$settings), true), 'inline');
            }
            // If we're here, then it is a valid request....
			Template::set('user', $user);

			Template::set_view('users/users/reset_password');
			Template::render();
		}
		else
		{

			Template::redirect('/');
		}//end if
	}//end reset_password()

	//--------------------------------------------------------------------

	/**
	 * Display the registration form for the user and manage the registration process
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function register()	{
		// Are users even allowed to register?
		if (!$this->settings_lib->item('auth.allow_register'))
		{
			Template::set_message(lang('us_register_disabled'), 'error');
			Template::redirect('/');
		}

		$this->load->model('roles/role_model');
		$this->load->helper('date');

		$this->load->config('address');
		$this->load->helper('address');

		$this->load->config('user_meta');
		$meta_fields = config_item('user_meta_fields');
		Template::set('meta_fields', $meta_fields);

		if (isset($_POST['register'])) {
			// Validate input
			$this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|valid_email|max_length[120]|unique[users.email]');

			$username_required = '';
			if ($this->settings_lib->item('auth.login_type') == 'username' ||
			    $this->settings_lib->item('auth.use_usernames'))
			{
				$username_required = 'required|';
			}
			$this->form_validation->set_rules('username', 'lang:bf_username', $username_required . 'trim|max_length[30]|unique[users.username]');

			$this->form_validation->set_rules('password', 'lang:bf_password', 'required|max_length[120]|valid_password');
			$this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', 'required|matches[password]');

			$this->form_validation->set_rules('language', 'lang:bf_language', 'required|trim');
			$this->form_validation->set_rules('timezones', 'lang:bf_timezone', 'required|trim|max_length[4]');
			$this->form_validation->set_rules('display_name', 'lang:bf_display_name', 'trim|max_length[255]');


			$meta_data = array();
			foreach ($meta_fields as $field)
			{
				if ((!isset($field['admin_only']) || $field['admin_only'] === FALSE
					|| (isset($field['admin_only']) && $field['admin_only'] === TRUE
						&& isset($this->current_user) && $this->current_user->role_id == 1))
					&& (!isset($field['frontend']) || $field['frontend'] === TRUE))
				{
					$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);

					$meta_data[$field['name']] = $this->input->post($field['name']);
				}
			}

			if ($this->form_validation->run($this) !== FALSE)
			{
				// Time to save the user...
				$data = array(
						'email'			=> $this->input->post('email'),
						'password'		=> $this->input->post('password'),
						'language'		=> $this->input->post('language'),
						'timezone'		=> $this->input->post('timezones'),
						'display_name'	=> $this->input->post('display_name'),
					);

				if (isset($_POST['username']))
				{
					$data['username'] = $this->input->post('username');
				}

				// User activation method
				$activation_method = $this->settings_lib->item('auth.user_activation_method');

				// No activation method
				if ($activation_method == 0)
				{
					// Activate the user automatically
					$data['active'] = 1;
				}

				if ($user_id = $this->user_model->insert($data))
				{
					// now add the meta is there is meta data
					$this->user_model->save_meta_for($user_id, $meta_data);

					/*
					 * USER ACTIVATIONS ENHANCEMENT
					 */

					// Prepare user messaging vars
					$subject = '';
					$email_mess = '';
					$message = lang('us_email_thank_you');
					$type = 'success';
					$site_title = $this->settings_lib->item('site.title');
					$error = false;

					switch ($activation_method)	{
						case 0:
							// No activation required. Activate the user and send confirmation email
							$subject 		=  str_replace('[SITE_TITLE]',$this->settings_lib->item('site.title'),lang('us_account_reg_complete'));
							$email_mess 	= $this->load->view('_emails/activated', array('title'=>$site_title,'link' => site_url()), true);
							$message 		.= lang('us_account_active_login');
							break;
						case 1:
							// Email Activiation.
							// Create the link to activate membership
							// Run the account deactivate to assure everything is set correctly
							$activation_code = $this->user_model->deactivate($user_id);
							$activate_link   = site_url('activate/'. $user_id);
							$subject         =  lang('us_email_subj_activate');

							$email_message_data = array(
								'title' => $site_title,
								'code'  => $activation_code,
								'link'  => $activate_link
							);
							$email_mess = $this->load->view('_emails/activate', $email_message_data, true);
							$message   .= lang('us_check_activate_email');
							break;
						case 2:
							// Admin Activation
							// Clear hash but leave user inactive
							$subject    =  lang('us_email_subj_pending');
							$email_mess = $this->load->view('_emails/pending', array('title'=>$site_title), true);
							$message   .= lang('us_admin_approval_pending');
							break;
					}//end switch

					// Now send the email
					$this->load->library('emailer/emailer');
					$data = array(
						'to'		=> $_POST['email'],
						'subject'	=> $subject,
						'message'	=> $email_mess
					);

					if (!$this->emailer->send($data))
					{
						$message .= lang('us_err_no_email'). $this->emailer->error;
						$error    = true;
					}

					if ($error)
					{
						$type = 'error';
					}
					else
					{
						$type = 'success';
					}

					Template::set_message($message, $type);

					// Log the Activity

					log_activity($user_id, lang('us_log_register'), 'users');
					Template::redirect('login');
				}
				else {
					Template::set_message(lang('us_registration_fail'), 'error');
					redirect('/register');
				}//end if
			}//end if
		}//end if

        $settings = $this->settings_lib->find_all();
        if ($settings['auth.password_show_labels'] == 1) {
            Assets::add_module_js('users','password_strength.js');
            Assets::add_module_js('users','jquery.strength.js');
            Assets::add_js($this->load->view('users_js', array('settings'=>$settings), true), 'inline');
        }

        // Generate password hint messages.
		$this->user_model->password_hints();

		Template::set('languages', unserialize($this->settings_lib->item('site.languages')));

		Template::set_view('users/users/register');
		Template::set('page_title', 'Register');
		Template::render();
	}//end register()

	//--------------------------------------------------------------------

	/**
	 * Save the user
	 *
	 * @access private
	 *
	 * @param int   $id          The id of the user in the case of an edit operation
	 * @param array $meta_fields Array of meta fields fur the user
	 *
	 * @return bool
	 */
	private function save_user($id=0, $meta_fields=array())	{

		if ( $id == 0 ) {
			$id = $this->current_user->id; /* ( $this->input->post('id') > 0 ) ? $this->input->post('id') :  */
		}

		$_POST['id'] = $id;

		// Simple check to make the posted id is equal to the current user's id, minor security check
		if ( $_POST['id'] != $this->current_user->id ) 	{
			$this->form_validation->set_message('email', 'lang:us_invalid_userid');
			return FALSE;
		}

		// Setting the payload for Events system.
		$payload = array ( 'user_id' => $id, 'data' => $this->input->post() );

		$this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|valid_email|max_length[120]|unique[users.email,users.id]');
		$this->form_validation->set_rules('password', 'lang:bf_password', 'max_length[120]|valid_password');

		// check if a value has been entered for the password - if so then the pass_confirm is required
		// if you don't set it as "required" the pass_confirm field could be left blank and the form validation would still pass
		$extra_rules = !empty($_POST['password']) ? 'required|' : '';
		$this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', ''.$extra_rules.'matches[password]');

		$username_required = '';

		if ($this->settings_lib->item('auth.login_type') == 'username' ||
		    $this->settings_lib->item('auth.use_usernames')) {
			$username_required = 'required|';
		}

		$this->form_validation->set_rules('username', 'lang:bf_username', $username_required . 'trim|max_length[30]|unique[users.username,users.id]');

		$this->form_validation->set_rules('language', 'lang:bf_language', 'required|trim');
		$this->form_validation->set_rules('timezones', 'lang:bf_timezone', 'trim|max_length[4]');
		$this->form_validation->set_rules('display_name', 'lang:bf_display_name', 'trim|max_length[255]');

		// Added Event "before_user_validation" to run before the form validation
		Events::trigger('before_user_validation', $payload );

		foreach ($meta_fields as $field) {
			if ((!isset($field['admin_only']) || $field['admin_only'] === FALSE
				|| (isset($field['admin_only']) && $field['admin_only'] === TRUE
				&& isset($this->current_user) && $this->current_user->role_id == 1))
				&& (!isset($field['frontend']) || $field['frontend'] === TRUE))	{
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
			}
		}

		if ($this->form_validation->run($this) === FALSE) {
			return FALSE;
		}

		// Compile our core user elements to save.
		$data = array(
			'email'		=> $this->input->post('email'),
			'language'	=> $this->input->post('language'),
			'timezone'	=> $this->input->post('timezones'),
			'firstname'	=> $this->input->post('firstname'),
			'lastname'	=> $this->input->post('lastname'),
			'middlename'=> $this->input->post('middlename'),
		);

		// If empty, the password will be left unchanged.
		if ($this->input->post('password') !== '')	{
			$data['password'] = $this->input->post('password');
		}

		if ($this->input->post('display_name') !== '')	{
			$data['display_name'] = $this->input->post('display_name');
		}

		if (isset($_POST['username'])) 	{
			$data['username'] = $this->input->post('username');
		}
		//Other custom inputs, added to the form
		/*if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
			$data['firstname'] 	= $this->input->post('firstname');
			$data['lastname'] 	= $this->input->post('lastname');
		}*/

		// Any modules needing to save data?
		// Event to run after saving a user
		Events::trigger('save_user', $payload );

		return $this->user_model->update($id, $data);
	} //end save_user()

	//---------------------------------------------------------------------
	/**
	 * Allows the profile educational history information to be saved unto the database.
	 *
	 * @access private
	 *
	 * @param int   $id          The id of the user in the case of an insert operation
	 * @param type  $type 		 'insert' or 'update' in case of create or edit operation
	 *
	 * @return array
	 */	
    private function save_education($type='insert', $id=0) {

        $this->auth->restrict();
        $this->set_current_user();

      	if ( $id == 0 ) {
			$user_id = $this->current_user->id; /* ( $this->input->post('id') > 0 ) ? $this->input->post('id') :  */
		}

		$_POST['id'] = $user_id;

		// Simple check to make the posted id is equal to the current user's id, minor security check
		if ( $_POST['id'] != $this->current_user->id ) 	{
			$this->form_validation->set_message('email', 'lang:us_invalid_userid');
			return FALSE;
		}

        $this->form_validation->set_rules('edu_centre_name', 'Institution/Exam Centre', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('edu_start_date', 'Start Date', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('edu_end_date', 'End Date', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('edu_certificate', 'certificate', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('edu_result', 'Result/Grade', 'required|trim|strip_tags|xss_clean');

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Compile our post data to make sure nothing
        // else gets through.
        $data = array(
            'user_id'           => $this->input->post('id'),
            'edu_centre_name'	=> $this->input->post('edu_centre_name'),
            'edu_start_date'	=> $this->input->post('edu_start_date'),
            'edu_end_date'      => $this->input->post('edu_end_date'),
            'edu_certificate'   => $this->input->post('edu_certificate'),
            'edu_result'	    => $this->input->post('edu_result')
        );

        if ($type == 'insert') {
            $return = $this->education_model->insert($data);
        }
        else {  // Update
            $return = $this->update($id, $data);
        }

        return $return;
    }//end of save_education()

   //---------------------------------------------------------------------
	/**
	 * Allows the profile educational history information to be saved unto the database.
	 *
	 * @access private
	 *
	 * @param int   $id          The id of the user in the case of an insert operation
	 * @param type  $type 		 'insert' or 'update' in case of create or edit operation
	 *
	 * @return array
	 */	
    private function save_other_data($type='insert', $id=0) {

        $this->auth->restrict();
        $this->set_current_user();

      	if ( $id == 0 ) {
			$user_id = $this->set_current_user();
			$_POST['user_id'] = $user_id;
		}else{
			$_POST['id'] = $id;
		}

        $this->form_validation->set_rules('nok_fullname', 'Full Name', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('nok_full_address', 'Full Address', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('nok_mobile', 'Telephone/Mobile', 'required|trim|strip_tags|xss_clean');

        if ($this->form_validation->run() === false) {
            return false;
        }

        if ($type == 'insert') {
        	// Compile our post data to make sure nothing
	        // else gets through.
	        $data = array(
	            'user_id'           => $this->input->post('id'),
	            'religion'			=> $this->input->post('religion'),
	            'marital_status'	=> $this->input->post('marital_status'),
	            'health_status'		=> $this->input->post('health_status'),
	            'nok_fullname'		=> $this->input->post('nok_fullname'),
	            'nok_full_address'	=> $this->input->post('nok_full_address'),
	            'nok_mobile'  	    => $this->input->post('nok_mobile')
	        );
            $return = $this->otherdata_model->insert($data);
        }
        else {  // Update
        	// Compile our post data to make sure nothing else gets through and !!!!!DO NOT UPDATE USER!!!!!.
	        $data = array(
	            'religion'			=> $this->input->post('religion'),
	            'marital_status'	=> $this->input->post('marital_status'),
	            'health_status'		=> $this->input->post('health_status'),
	            'nok_fullname'		=> $this->input->post('nok_fullname'),
	            'nok_full_address'	=> $this->input->post('nok_full_address'),
	            'nok_mobile'  	    => $this->input->post('nok_mobile')
	        );
            $return = $this->otherdata_model->update($id, $data);
        }

        return $return;
    }//end of save_education()

	//--------------------------------------------------------------------

		//--------------------------------------------------------------------
		// ACTIVATION METHODS
		//--------------------------------------------------------------------
		/*
			Activate user.

			Checks a passed activation code and if verified, enables the user
			account. If the code fails, an error is generated and returned.

		*/
		public function activate($user_id = NULL)		{
			if (isset($_POST['activate']))
			{
				$this->form_validation->set_rules('code', 'Verification Code', 'required|trim');
				if ($this->form_validation->run() == TRUE)
				{
					$code = $this->input->post('code');

					$activated = $this->user_model->activate($user_id, $code);
					if ($activated)
					{
						$user_id = $activated;

						// Now send the email
						$this->load->library('emailer/emailer');

						$site_title = $this->settings_lib->item('site.title');

						$email_message_data = array(
							'title' => $site_title,
							'link'  => site_url('login')
						);
						$data = array
						(
							'to'		=> $this->user_model->find($user_id)->email,
							'subject'	=> lang('us_account_active'),
							'message'	=> $this->load->view('_emails/activated', $email_message_data, TRUE)
						);

						if ($this->emailer->send($data))
						{
							Template::set_message(lang('us_account_active'), 'success');
						}
						else
						{
							Template::set_message(lang('us_err_no_email'). $this->emailer->error, 'error');
						}
						Template::redirect('/');
					}
					else
					{
						Template::set_message($this->user_model->error.'. '. lang('us_err_activate_code'), 'error');
					}
				}
			}
			Template::set_view('users/users/activate');
			Template::set('page_title', 'Account Activation');
			Template::render();
		}

		//--------------------------------------------------------------------

		/*
			   Method: resend_activation

			   Allows a user to request that their activation code be resent to their
			   account's email address. If a matching email is found, the code is resent.
		   */
		public function resend_activation()		{
			if (isset($_POST['send']))
			{
				$this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|valid_email');

				if ($this->form_validation->run())
				{
					// We validated. Does the user actually exist?
					$user = $this->user_model->find_by('email', $_POST['email']);

					if ($user !== FALSE)
					{
						// User exists, so create a temp password.
						$this->load->helpers(array('string', 'security'));

						$pass_code = random_string('alnum', 40);

						$activation_code = do_hash($pass_code . $user->password_hash . $_POST['email']);

						$site_title = $this->settings_lib->item('site.title');

						// Save the hash to the db so we can confirm it later.
						$this->user_model->update_where('email', $_POST['email'], array('activate_hash' => $activation_code ));

						// Create the link to reset the password
						$activate_link = site_url('activate/'. str_replace('@', ':', $_POST['email']) .'/'. $activation_code);

						// Now send the email
						$this->load->library('emailer/emailer');

						$email_message_data = array(
							'title' => $site_title,
							'code'  => $activation_code,
							'link'  => $activate_link
						);

						$data = array
						(
							'to'		=> $_POST['email'],
							'subject'	=> 'Activation Code',
							'message'	=> $this->load->view('_emails/activate', $email_message_data, TRUE)
						);
						$this->emailer->enable_debug(true);
						if ($this->emailer->send($data))
						{
							Template::set_message(lang('us_check_activate_email'), 'success');
						}
						else
						{
							Template::set_message(lang('us_err_no_email').$this->emailer->error.", ".$this->emailer->debug_message, 'error');
						}
					}
					else
					{
						Template::set_message('Cannot find that email in our records.', 'error');
					}
				}
			}
			Template::set_view('users/users/resend_activation');
			Template::set('page_title', 'Activate Account');
			Template::render();
		}
	
}//end Users

/* Front-end Users Controller */
/* End of file users.php */