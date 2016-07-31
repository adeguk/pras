<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
class programmeView_model extends MY_Model {

    protected $table_name   = 'programme_view';
    protected $key          = 'id';
    protected $set_created  = false;
    protected $set_modified = false;
    protected $soft_deletes = false;
    protected $date_format  = 'datetime';
}
