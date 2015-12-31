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
				'class'		=> 'input-xlarge datepicker',
				'placeholder'=> 'Please enter your date of birth',
				'required'	=> TRUE,
			),
		),
	),
/*
	array(
		'name'   		=> 'mobile',
		'label'   		=> lang('pras_telephone'),
		'rules'   		=> 'required|trim|max_length[11]',
		'admin_only' 	=> FALSE,
		'form_detail' 	=> array(
			'type' 		=> 'input',
			'settings' 	=> array(
				'name'		=> 'mobile',
				'maxlength'	=> '11',
				'class'		=> 'input-xlarge',
				'placeholder'=> 'Please enter your contact number',
				'required'	=> TRUE,
			),
		),
	),
*/
	array(
		'name'   		=> 'gender',
		'label'   		=> lang('pras_gender'),
		'rules'   		=> 'required',
		'admin_only'	=> FALSE,
		'form_detail' 	=> array(
			'type'		=> 'dropdown',
			'settings' 	=> array(
				'name'		=> 'gender',
				'id'		=> 'gender',
				'class'		=> 'input-xlarge chzn-select',
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
		'label'   		=> lang('pras_nationality'),
		'admin_only' 	=> FALSE,
		'form_detail'	=> array(
			'type' 		=> 'nationality_select',
			'settings' 	=> array(
				'name'		=> 'nationality',
				'class'		=> 'input-xlarge chzn-select',
			),
		),
	),

	array(
		'name'   		=> 'marital_status',
		'label'   		=> lang('pras_marital_status'),
		'rules'   		=> '',
		'form_detail' 	=> array(
			'type' 		=> 'dropdown',
			'settings' 	=> array(
				'name'		=> 'marital_status',
				'class'		=> 'input-xlarge chzn-select',
				'required'	=> FALSE,
			),
			'options' 	=>  array(
                  '' 		=> 'Please select your marital status',
                  'Single' 		=> 'Single',
                  'Divorced' 	=> 'Divorced',
				  'Married'		=> 'Married'
                ),
		),
	),

	array(
		'name'   		=> 'health_status',
		'label'   		=> lang('pras_health_status'),
		'rules'   		=> '',
		'form_detail' 	=> array(
			'type' 		=> 'dropdown',
			'settings' 	=> array(
				'name'		=> 'health_status',
				'class'		=> 'input-xlarge chzn-select',
				'required'	=> FALSE,
			),
			'options' 	=>  array(
                  '' 		=> 'Please select your health status',
                  'Healthy' 		=> 'Healthy',
                  'Averagely Healthy' 	=> 'Averagely Healthy',
				  'Sick'		=> 'Sick'
                ),
		),
	),

	array(
		'name'   		=> 'religion',
		'label'   		=> lang('pras_religion'),
		'rules'   		=> '',
		'form_detail' 	=> array(
			'type' 		=> 'dropdown',
			'settings' 	=> array(
				'name'		=> 'religion',
				'class'		=> 'input-xlarge chzn-select',
				'required'	=> FALSE,
			),
			'options' 	=>  array(
	            	'' 		=> 'Please select your religion',
	            	'Christian' 		=> 'Christian',
	            	'Islam' 	=> 'Islam',
	            	'Protestant' 	=> 'Protestant',
					'None'		=> 'None'
	            ),
		),
	),
);
