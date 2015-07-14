<?php

class members{


  public function viewUnApprovedMemberList(){
    $where=array('Verified' => 1 );
    $Page_Title="Un-Verified members";
   members::getMembersList($where,$Page_Title);
  }
  public function getMembersList($where,$Page_Title){
    global $db;

    require_once("views/tablelist.php");
    $myTable =new TableView;
    $myTable->addE("member ID","id","`id`");
    $myTable->addE("Member Name","name","`name`");
    $myTable->addE("Group Name","Gname","`Gname`");
    $myTable->addElement("Member Picture","ProfilePic","`ProfilePic`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
    $keyid="id";
    global  $per_page;
    $myTable->addF("Approve","Approve","a");
    $myTable->addF("Disapprive","disapprove","c");
    $myTable->addF("View","View","v");
    $myTable->addF("Edit","Edit","e");
    $what=$myTable->returnArray();
    $table="members";
    $innerJoin="INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid`";
    $getArray=$_GET;
    require ("functions/generalFunctions.php");
    $start=getStartPage($getArray,$per_page);
    $db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$what,$innerJoin);
    $input=$db->result_array();
    include("views/list.php");
  }

  public function viewMemberList(){
    $Page_Title="All members";
    $where=array('1' => 1 );
    members::getMembersList($where,$Page_Title);
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
  $body=implode(",",$result);
  include("views/single.php");
  }else{
  $header="Error";
  $body=$db->errorMessege();
  include("views/single.php");
  }
  }
  public function Approve($id){
//Set the randome number in the Database
//Send sms with this number
global $db;
  $ValidKey=rand( 1000 ,  9999 );
  //Code to send The SMS
  $db->update('members',$what=array('Verified'=>$ValidKey),$where = array('id' => $id ));
  include("functions/generalFunctions.php");
  messege("alert-success","Sucess      ","Approval sms is $ValidKey");
  }
  public function Delete($id){

  }
  public function Disapprove($id){
    global $db;
    //Set the randome number in the Database
    //Send sms with this number
      $ValidKey=-1;
      $db->update('members',$what=array('Verified'=>$ValidKey),$where = array('id' => $id ));
      //Send internal Messege
      include("functions/generalFunctions.php");
      messege("alert-danger","Sucess      ","the member was rejected");
  }

}

 ?>
