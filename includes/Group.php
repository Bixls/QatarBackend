<?php
require_once('db.php');


class Groups{


  public $db;
  public function __construct() {
  global $db;
  $this->db = new DB;
  }

public  $Gid;
public  $Gname;
public  $ProfilePic;

public  function getGroupList($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `groups` ORDER BY `groups`.`priority`  LIMIT ".$inputs->limit."  ") or die (mysql_error());
  $stack = array();
      while($row = mysql_fetch_array($query)){
          $respond = array(
            'id' => $row['Gid'],
            'name' => $row['Gname'],
            'ProfilePic' => $row['GProfilePic'],
            'Royal' => $row['Royal']
            );
      array_push($stack, $respond);
      }
   echo json_encode($stack);
    $dbConnect->close();

  }
  public function getGroupbyID($inputs){
    $table="groups";
    $innerJoin="";
    $this->db->select($table,$where = array('Gid' =>$inputs->id  ),"",$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
    $output=$this->db->result_array();
    echo json_encode($output);
  }


}















 ?>
