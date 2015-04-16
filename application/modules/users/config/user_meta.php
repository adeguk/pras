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
 * @filesource application/modules/users/config/user_meta.php
 *
 * @modified by Adewale Adegoroye
 */

//------------------------------------------------------------------------
// User Meta Fields Config - These are just examples of various options
// The following examples show how to use regular inputs, select boxes,
// state and country select boxes.
//------------------------------------------------------------------------

$config['user_meta_fields'] =  array(

	array(
		'name'   		=> 'dob',
		'label'   		=> 'Date of Birth',
		'rules'   		=> 'required|trim',
		'admin_only' 	=> FALSE,
		'form_detail' 	=> array(
			'type' 		=> 'input',
			'settings' 	=> array(
				'name'		=> 'dob',
				'class'		=> 'span10 datepicker',
				'placeholder'=> 'Please enter your date of birth',
				'required'	=> TRUE,
			),
		),
	),

	array(
		'name'   		=> 'mobile',
		'label'   		=> lang('user_meta_telephone'),
		'rules'   		=> 'required|trim|max_length[11]',
		'admin_only' 	=> FALSE,
		'form_detail' 	=> array(
			'type' 		=> 'input',
			'settings' 	=> array(
				'name'		=> 'mobile',
				'id'		=> 'mobile',
				'maxlength'	=> '11',
				'class'		=> 'span10',
				'placeholder'=> 'Please enter your contact number',
				'required'	=> TRUE,
			),
		),
	),
	
	array(
		'name'   		=> 'gender',
		'label'   		=> lang('user_meta_gender'),
		'rules'   		=> 'required',
		'admin_only'	=> FALSE,
		'form_detail' 	=> array(
			'type'		=> 'dropdown',
			'settings' 	=> array(
				'name'		=> 'gender',
				'id'		=> 'gender',
				'class'		=> 'span10 chzn-select',
				'required'	=> TRUE,
			),
			'options' 	=>  array(
                  '' 		=> 'Please select your gender',
                  'Female' 		=> 'Female',
                  'Male' 		=> 'Male',
                ),
		),
	),

	array(
		'name'   		=> 'nationality',
		'label'   		=> lang('uuser_meta_nationality'),
		'rules'   		=> 'trim|max_length[100]',
		'admin_only' 	=> FALSE,
		'form_detail'	=> array(
			'type' 		=> 'nationality_select',
			'settings' 	=> array(
				'name'		=> 'nationality',
				'id'		=> 'nationality',
				'maxlength'	=> '100',
				'class'		=> 'span10 chzn-select',
			),
		),
	),

	array(
		'name'   		=> 'street_name',
		'label'   		=> lang('user_meta_street_name'),
		'rules'   		=> 'trim|max_length[100]',
		'frontend' 		=> TRUE,
		'form_detail' 	=> array(
			'type' 		=> 'input',
			'settings' 	=> array(
				'name'		=> 'street_name',
				'id'		=> 'street_name',
				'maxlength'	=> '100',
				'class'		=> 'span10',
				'placeholder'=> 'What is your street name?',
				'required'	=> TRUE,
			),
		),
	),

	array(
		'name'   		=> 'state',
		'label'   		=> lang('user_meta_state'),
		'rules'   		=> 'required|trim|max_length[2]',
		'form_detail' 	=> array(
			'type' 		=> 'state_select',
			'settings' 	=> array(
				'name'		=> 'state',
				'id'		=> 'state',
				'maxlength'	=> '2',
				'class'		=> 'span10 chzn-select',
			),
		),
	),

	array(
		'name'   		=> 'country',
		'label'   		=> lang('user_meta_country'),
		'rules'   		=> 'required|trim|max_length[100]',
		'admin_only' 	=> FALSE,
		'form_detail' 	=> array(
			'type' 		=> 'country_select',
			'settings' 	=> array(
				'name'		=> 'country',
				'id'		=> 'country',
				'maxlength'	=> '100',
				'class'		=> 'span10 chzn-select',
			),
		),
	),

	/*array(
		'name'   		=> 'type',
		'label'   		=> lang('user_meta_type'),
		'rules'   		=> 'required',
		'frontend' 		=> FALSE,
		'admin_only' 	=> TRUE,
		'form_detail' 	=> array(
			'type' 		=> 'dropdown',
			'settings' 	=> array(
				'name'		=> 'type',
				'id'		=> 'type',
				'class'		=> 'span10',
			),
			'options' 	=>  array(
                'small'  	=> 'Small Shirt',
                'med'    	=> 'Medium Shirt',
                'large'   	=> 'Large Shirt',
                'xlarge' 	=> 'Extra Large Shirt',
            ),
		),
	),*/
);