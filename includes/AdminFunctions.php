<?php
require_once('db.php');

class AdminFunctions{

public $db;
public function __construct() {
global $db;
$this->db = new DB;
}
public function getString($inputs){
    $this->db->select("Strings",$where = array('name' =>$inputs->name),"",$order=false,$where_mode="AND",$print_query=false,$What="*","");
    echo json_encode($this->db->error?$this->db->errorMessege():$this->db->row_array());
}
public function getAvatarList(){
  $this->db->select("Avatars",$where="","",$order=false,$where_mode="AND",$print_query=false,$What="*","");
  echo json_encode($this->db->error?$this->db->errorMessege():$this->db->result_array());

}


}
?>
