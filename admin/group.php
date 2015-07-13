<?php



class groups{

public function addGroup($inputs){

}
public function viewGroupList(){
  global $db;
  $table="groups";
  global  $per_page;
  $list = array('id'=>'Gid' ,' Name'=>'Gname','Picture'=>'GProfilePic');
  $customeFileds= array('View'=>"v",
                        'Edit'=>"e"
                      );
  $innerJoin="";
  $getArray=$_GET;
  require ("functions/generalFunctions.php");
  $start=getStartPage($getArray,$per_page);
  $db->select($table,"",$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
  $input=$db->result_array();

  //print_r($input);
  $header=$list;
  $keyID="id";
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
global $db;
$db->insert("groups", $what = array('Gname' =>  $_POST['Gname'],'GProfilePic' =>  $_POST['GProfilePic'] ));
include("functions/generalFunctions.php");
  if(!$db->error){
  messege("alert-success","Sucess","Group has been created");
  }else{
  messege("alert-danger","Falied ",$db->errorMessege());
  }
}

}


?>
