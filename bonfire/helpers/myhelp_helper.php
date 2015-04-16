<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Adewale Adegoroye
 * @copyright Copyright (c) 2013 Sitechum Dev Team
 * @license   http://guides.sitechum.com.ng/license.html
 * @link      http://loggcity.com
 * @since     Version 1.0
 * @filesource
 */

/**
 * My Helpers
 *
 * Provides various helper functions when working with address in forms.
 *
 * @package    Bonfire
 * @subpackage Helpers
 * @category   Helpers
 * @author     Sitechum Dev Team
 *
 */

if ( ! function_exists('get_fieldByID')) {
	/**
	 * Creates a get_fieldByID dropdown form input based on the entries in any table.
	 * The word "state" is used but the structure can be used for Canadian proviences, Irish and UK counties and
	 * any other area based data.
	 *
	 * @param $table string The value of the item that should be selected when the dropdown is drawn.
	 * @param $id string The value of the item that should be selected if no other matches are found.
	 * @param $field string The code of the country for which the states/priviences/counties are returned. Defaults to 'US'.
	 * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, December 2013
	 * @return string The full html for the select input.
	 */
	function get_fieldByID($table, $id, $field){

        $ci = get_instance();   //get a reference to the controller object

        $ci->load->model($table); //then, load the model

        if (isset($id)) {
            $output= $ci->$table->get_field($id, $field);
        }
        else {
            $output='Not Available!';
        }

        return e($output);

	}//end
}

if ( ! function_exists('listUsers_byRole')) {
	/**
	 * Creates a user list dropdown option form input based on the entries in the user table.
	 *
	 */
	function listUsers_byRole($role_id){

        $ci = get_instance();   //get a reference to the controller object

        $ci->load->model('user_model'); //then, load the model

        $users = $ci->user_model->select('id, firstname, middlename, lastname')->find_all_by(array('bf_users.deleted'=>0 , 'bf_users.role_id'=>$role_id ));
        if (isset($users)) {
	        foreach($users as $user){
	            echo "<option value=" .$user->id. ">";
	            e(strtoupper($user->lastname).', '.$user->firstname.' '.$user->middlename);
	            echo "</option>";
	        }
        }
        else {
            echo 'Not Available!';
        }
	}//end
}

if ( ! function_exists('listUser_byID')) {
	/**
	 * Creates a user list dropdown option form input based on the entries in the user table.
	 *
	 * @param $id string The value of the item that should be selected when the dropdown is drawn.
	 * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, January 2014
	 * @return string The full html for the select input.
	 */
	function listUser_byID($id){

        $ci = get_instance();   //get a reference to the controller object

        $ci->load->model('user_model'); //then, load the model

        $users = $ci->user_model->select('lastname, middlename, firstname')->find_all_by('id', $id);
		foreach($users as $user){
		    e(strtoupper($user->lastname).', '.$user->firstname.' '.$user->middlename);
	    }
	}//end
}

if ( ! function_exists('editUser_byRole')) {
	/**
	 * Creates a user list dropdown option form input based on the entries in the user table.
	 *
	 * @param $id string The value of the item that should be selected when the dropdown is drawn.
	 * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, January 2014
	 * @return string The full html for the select input.
	 */
	function editUser_byRole($id, $role_id){

        $ci = get_instance();   //get a reference to the controller object

        $ci->load->model('user_model'); //then, load the model

        $users = $ci->user_model->select('id, firstname, middlename, lastname')
            ->find_all_by(array('bf_users.deleted'=>0 , 'bf_users.role_id'=>$role_id ));
        foreach($users as $user){
            $key = $user->id;
            if ($key == $id){
                $selected = " selected=selected ";
            } else {
                $selected = "";
            }
            echo "<option $selected value=" .$key. ">";
            e(strtoupper($user->lastname).', '.$user->firstname.' '.$user->middlename);
            echo "</option>";
        } 
	}//end
}

if (! function_exists('toExcel')) {
	/**
	 * Export any given table and its column(s) to Excel in CSV format using codeigniter DB utility class 
	 * and force_download helper. For complex query, use views
	 * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, April 2014
	 * @param $tablename string - the name of the table,  
	 * @param $column string - is the specified column(s) and its (*) by default - to select all from the given table while 
	 * @param $filename string the download will be saved with this name on the user's desktop. it is exceldownload by default
	 *
	 */
	function toExcel($tablename, $columns='*', $filename='exceldownload'){

		$ci = get_instance();   //get a reference to the controller object

        // Load the DB utility class
        $ci->load->dbutil();
        $query = $ci->db->query('SELECT '. $columns .' FROM bf_'. $tablename);

        $delimiter = ",";
        $newline = "\r\n";

        $downloadfile = $ci->dbutil->csv_from_result($query, $delimiter, $newline); 
        // Load the download helper and send the file to your desktop
        $ci->load->helper('download');
        force_download($filename.'.csv', $downloadfile); 
    }
}

if (! function_exists('query2Excel')) {
    /**
     * Export any given table and its column(s) to Excel in CSV format using codeigniter DB utility class 
     * and force_download helper. For complex query, use views
     * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, April 2014
     * @param $tablename string - the name of the table,  
     * @param $column string - is the specified column(s) and its (*) by default - to select all from the given table while 
     * @param $filename string the download will be saved with this name on the user's desktop. it is exceldownload by default
     *
     */
    function query2Excel($query, $filename='exceldownload'){

        $ci = get_instance();   //get a reference to the controller object

        // Load the DB utility class
        $ci->load->dbutil();
        $query_result = $ci->db->query($query);
        
        $delimiter = ",";
        $newline = "\r\n";

        $downloadfile = $ci->dbutil->csv_from_result($query, $delimiter, $newline); 
        // Load the download helper and send the file to your desktop
        $ci->load->helper('download');
        force_download($filename.'.csv', $downloadfile); 
    }
}

if ( ! function_exists('limit_words')) {
    /**
     * Creates a limit_words that reduces long description to specify number of character(s).
     *
     * @param $string string The original words/characters to be reduced.
     * @param $word_limit interger The length of character to reduce the original words/sentences by.
     * @author: Adewale Adegoroye Sitechum, www.sitechum.com.ng, December 2013
     * @return string The full html for the select input.
     */
    function limit_words($string, $word_limit){

        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));

    }//end
}