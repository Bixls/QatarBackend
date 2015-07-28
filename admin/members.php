<?php
  require_once("views/tablelist.php");
class members{


  public function viewUnApprovedMemberList(){
    $where=array('Verified' => 0 );
    $Page_Title="Un-Verified members";
    $myFunctions =new TableView;
    $myFunctions->addF("Approve","Approve","a");
    $myFunctions->addF("Disapprive","disapprove","c");
    $myFunctions->addF("View","View","v");
    $myFunctions->addF("Edit","Edit","e");
   members::getMembersList($where,$Page_Title,$myFunctions);
  }
  public function getMembersList($where,$Page_Title,$myFunctions){
    global $db;


    $myTable =new TableView;
    $myTable->addE("member ID","id","`id`");
    $myTable->addE("Member Name","name","`name`");
    $myTable->addE("Group Name","Gname","`Gname`");
    $myTable->addElement("Member Picture","ProfilePic","`ProfilePic`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
    $keyid="id";
    global  $per_page;


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
    $myFunctions =new TableView;
    $myFunctions->addF("View","View","v");
    $myFunctions->addF("Edit","Edit","e");
    $myFunctions->addF("Delete","Delete","d");
   members::getMembersList($where,$Page_Title,$myFunctions);
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
  echo("<script>$('#R$id').hide();</script>");
  }
  public function Delete($id){
    global $db;
    $db->delete("members",$where=array('id' => $id));
    include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","Sucess","member has been delete successfully");
    echo("<script>$('#R$id').hide();</script>");
    }else{
    messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
    }

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
      echo("<script>$('#R$id').hide();</script>");
  }

}

 ?>
