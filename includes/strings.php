<?php
require_once('db.php');

class strings{

public $db;
public function __construct() {
global $db;
$this->db = new DB;
}
public function getString($inputs){
    $this->db->select("Strings",$where = array('name' =>$inputs->name),"",$order=false,$where_mode="AND",$print_query=false,$What="*","");
    echo json_encode($this->db->error?$this->db->errorMessege():$this->db->row_array());
}


}
?>
