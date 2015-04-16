<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class programmeView_model extends MY_Model {

    protected $table_name   = 'programmeview';
    protected $key          = 'prog_id';
    protected $set_created  = true;
    protected $set_modified = false;
    protected $soft_deletes = true;
    protected $date_format  = 'datetime';

}
   