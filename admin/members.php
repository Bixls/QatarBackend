<?php

class members{


  public function viewUnApprovedMemberList(){
    global $db;
    $table="members";
    $per_page = 10;
    $where=array("Verified"=>1);
    $list = array('id'=>'id' ,' Name'=>'name','Picture'=>'ProfilePic','Gname'=>'Gname');
    $customeFileds= array('Approve' =>"a" ,
                          'disapprove'=>"c",
                          'View'=>"v",
                          'Edit'=>"e"
                        );
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
