<?php



class groups{

public function addGroup($inputs){

}
public function viewGroupList(){

  $Page_Title="Groups";
  global $db;
  require_once("views/tablelist.php");
  $myTable =new TableView;
  $myTable->addE("group ID","Gid","`Gid`");
  $myTable->addE("Group Name","Gname","`Gname`");
  $myTable->addElement("Group Picture","GProfilePic","`GProfilePic`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
  $keyid="Gid";
  global  $per_page;
  $myFunctions =new TableView;
  $myFunctions->addF("View","View","v");
  $myFunctions->addF("Edit","Edit","e");
  $what=$myTable->returnArray();
  $table="groups";
  $innerJoin="";
  $getArray=$_GET;
  require ("functions/generalFunctions.php");
  $start=getStartPage($getArray,$per_page);
  $db->select($table,"",$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
  $input=$db->result_array();
  include("views/list.php");
}
public function editGroup($id){

}
public function View($id){

}
public function Edit($id){

}
public function CreateNew($input){

  $header="Create Group";
  include("views/form.php");
  $form=new form("index.php","title");
  $form->addElement('Gname',"","text","Group Name");
  $form->addImage('GProfilePic',"group","Group Profile Pic");
  $form->addElement('i',"0","hidden","");
  $form->addElement('fn',"insert","hidden","");
  $form->addElement('c',"groups","hidden","");
  $body=$form->RenderForm();
//  $body="fields that will create the new group is here";
  include("views/single.php");
}

public function insert($id)
{
  ob_start();
  $NoResponse="NoResponse";
  include(ROOTPATH."/upload.php");
  ob_end_clean();
if($respond['success']=="true"){

global $db;
$db->insert("groups", $what = array('Gname' =>  $_POST['Gname'],'GProfilePic' => $respond['id']));
include("functions/generalFunctions.php");
  if(!$db->error){
  messege("alert-success","Sucess","Group has been created");
  }else{
  messege("alert-danger","Falied ",$db->errorMessege());
  }

}
}

}


?>
