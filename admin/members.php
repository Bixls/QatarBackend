<?php

class members{


  public function viewUnApprovedMemberList(){
    global $db;
    $table="members";
    $per_page = 2;
    $where=array("Verified!=0");
    $list = array('id'=>'id' ,' Name'=>'name','Picture'=>'ProfilePic','Gname'=>'Gname');
    $customeFileds= array('Approve' =>"a" ,

                          'View'=>"v",
                          'Edit'=>"e",
                          'disapprove'=>"c");
    $innerJoin="INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid`";
    $getArray=$_GET;
    require ("functions/generalFunctions.php");
    $start=getStartPage($getArray,$per_page);
    $db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
    $input=$db->result_array();
    //print_r($input);
    $header=$list;
    $keyID="id";
    include("views/list.php");

  }
  public function viewMemberList(){
    global $db;
    $table="members";
    $per_page = 2;
    $where="";
    $list = array('id'=>'id' ,' Name'=>'name','Picture'=>'ProfilePic','Gname'=>'Gname');
    $customeFileds= array('View'=>"v",'Edit'=>"e");
    $innerJoin="INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid`";
    $getArray=$_GET;
    require ("functions/generalFunctions.php");
    $start=getStartPage($getArray,$per_page);
    $db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
    $input=$db->result_array();
    //print_r($input);
    $header=$list;
    $keyID="id";
    include("views/list.php");
  }
  public function SearchMembersByNameList(){

  }
  public function Edit($id){
    global $db;
    $What="*";
    $innerJoin = "";
    $db->select('members',array('members`.`id'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    if(!$db->error){
    $result=$db->row_array();
    $header=$result['name'];
    $body=$result;
    include("views/singleEdit.php");
    }else{
    $header="Error";
    $body=$db->errorMessege();
    }
  }
  public function View($id){
  global $db;
  $What="*";
  $innerJoin = "INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid`";
  $db->select('members',array('members`.`id'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
  if(!$db->error){
  $result=$db->row_array();
  $header=$result['name'];
  $body=$result;
  include("views/single.php");
  }else{
  $header="Error";
  $body=$db->errorMessege();
  }
  }
  public function Approve($id){

  }
  public function Delete($id){

  }
  public function Disapprove($id){

  }

}

 ?>
