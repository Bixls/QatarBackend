<?php



class groups{

public function addGroup($inputs){

}
public function search($name){
  $searc="`Gname` LIKE '%".$name."%'";
  $where=array($searc);
  $Page_Title="البحث عن ".$name;
  $myFunctions =new TableView;
  $myFunctions->addF("عرض","View","v");
//  $myFunctions->addF("تعديل","Edit","e");
 groups::viewGList($where,$Page_Title,$myFunctions);
}
public function viewGroupList(){
  $Page_Title="القبائل";
  $where='';
  $myFunctions='';
 groups::viewGList($where,$Page_Title,$myFunctions);
}

public function viewGList($where,$Page_Title,$myFunctions){

  global $db;
  require_once("views/tablelist.php");
  $myTable =new TableView;
  $myTable->addE("id","Gid","`Gid`");
  $myTable->addE("ترتيب القبيله","priority","`priority`");
  $myTable->addE("اسم القبيله","Gname","`Gname`");
  $myTable->addElement("صوره القبيله","GProfilePic","`GProfilePic`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
  $keyid="Gid";
  global  $per_page;
  $myFunctions =new TableView;
  $myFunctions->addF("عرض","View","v");
  $myFunctions->addF("تعديل","Edit","e");

  $what=$myTable->returnArray();
  $table="groups";
  $innerJoin="";
  $getArray=$_GET;
  require ("functions/generalFunctions.php");
  $start=getStartPage($getArray,$per_page);
  $db->select($table,$where,$limit=false,$order="priority",$where_mode="AND",$print_query=false,$What="*",$innerJoin);
  $numberOFPosts=$db->count();
  $db->select($table,$where,$limit=$start.",".$per_page,$order="priority",$where_mode="AND",$print_query=false,$What="*",$innerJoin);
  $input=$db->result_array();
  include("views/list.php");
}
public function editGroup($id){

}
public function View($id){
global $db;
$db->select('groups',array('Gid'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
if(!$db->error){
$result=$db->row_array();

$header="<b>"."قبيله ";
$header.="</b> ".$result['Gname'];
$db->select('members',array('groupID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
$membersNumber=$db->count();

$innerJoin = "INNER JOIN `members` ON `members`.`id`=`Events`.`CreatorID`";
$db->select('Events',array('members`.`groupID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
$eventsNumber=$db->count();

include("views/normalView.php");
$NormalView=new NormalView;
$ViewImage=$result['GProfilePic'];

$NormalView->addElement($membersNumber,"text","عدد الاعضاء");

$NormalView->addElement(($result['Royal']==0?"لا":"نعم"),"text","قبيله ملكيه");
$NormalView->addElement($eventsNumber,"text","عدد المناسبات");
$NormalView->addElement($result['Description'],"text","تفاصيل القبيله");
$body=$NormalView->RenderForm();
$DeleteMessege="هل انت متاكد من حذف ".$result['Gname'];
$menus="";

$menus.='<button class="btn btn-md btn-danger" onclick="goTo(\'Delete\',\'d\','.$result['Gid'].',\'groups\',\''.$DeleteMessege.'\')" >حذف</button>';

$menus.='<button class="btn btn-md btn-success" onclick="goTo(\'Edit\',\'e\','.$result['Gid'].',\'groups\',\''.$DeleteMessege.'\')" >تعديل</button>';

$menus.='<a class="btn btn-md btn-default" href="?fn=getEventsbyGroup&c=events&i='.$result['Gid'].'">عرض مناسبات القبيله</a>';
$menus.='<a class="btn btn-md btn-default" href="?fn=viewMemberByGroup&c=members&i='.$result['Gid'].'">عرض اعضاء القبيله</a>';



include("views/single.php");
}else{
$header="Error";
$body=$db->errorMessege();
include("views/single.php");
}
}
public function Edit($id){

  global $db;
  $db->select('groups',array('Gid'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  if(!$db->error){
  $result=$db->row_array();

  $header="تعديل قبيله".$result['Gname'];
  include("views/form.php");
  $form=new form("index.php","title");
  $form->addElement('Gname',$result['Gname'],"text","اسم القليله");
  $form->addImage('GProfilePic',"group","صوره القبيله");
  $allowComments = array('1' =>"نعم"
  ,'0' =>"لا"  );
  $oldValue=$allowComments[$result['Royal']];
  unset($allowComments[$result['Royal']]);
  $allowComments[$result['Royal']]=$oldValue;
  $allowComments = array_reverse($allowComments,true);
  $form->addElement('Royal',$allowComments,"select","قبيله ملكيه ؟");


  global $db;
  $db->select('groups',"",$limit=false,$order="priority",$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $resCash=$db->result_array();
   $groups = array("-1"=>"الاول");
    foreach ($resCash as $key) {
      //array_push($group,$key["Gname"]);
      $groups[$key["priority"]]=$key["Gname"];
    }


  $form->addSelect('priority',$groups,$result['priority'],"الترتيب قبل");
  $form->addElement('Description',$result['Description'],"textarea","تفاصيل القبيله");
  $form->addElement('i',$id,"hidden","");
  $form->addElement('fn',"update","hidden","");
  $form->addElement('c',"groups","hidden","");
  $body=$form->RenderForm();
//  $body="fields that will create the new group is here";
  include("views/single.php");
}
}
public function sort(){

  global $db;
  $db->select($table='groups',"",$limit=false,$order="priority",$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $input=$db->result_array();
  $i=0;
  foreach ($input as $key) {
    $db->update("groups", $what =  array('priority' =>  $i)
    , $where=array("Gid"=>$key['Gid']));
    $i++;
  }
}
public function CreateNew($input){

  $header="اضافه قبيله جديده";
  include("views/form.php");
  $form=new form("index.php","title");
  $form->addElement('Gname',"","text","اسم القليله");
  $form->addImage('GProfilePic',"group","صوره القبيله");
  $allowComments = array('1' =>"نعم",'0' =>"لا"  );
  $form->addElement('Royal',$allowComments,"select","قبيله ملكيه ؟");
  $form->addElement('Description',"","textarea","تفاصيل القبيله");
global $db;
  $db->select('groups',"",$limit=false,$order="priority",$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $result=$db->result_array();
$groups[-1]="الاول";
  foreach ($result as $key) {
    //array_push($group,$key["Gname"]);
    $groups[$key["priority"]]=$key["Gname"];
  }

  $form->addElement('priority',$groups,"select","القبيله");


  $form->addElement('i',"0","hidden","");
  $form->addElement('fn',"insert","hidden","");
  $form->addElement('c',"groups","hidden","");
  $body=$form->RenderForm();
//  $body="fields that will create the new group is here";
  include("views/single.php");
}
public function Delete($id){
  global $db;
  $db->delete("groups",$where=array('Gid' => $id));
  include("functions/generalFunctions.php");
  if(!$db->error){
  messege("alert-success","تمت العمليه بنجاح","لقد تم حذف القبيله بنجاح");
  echo("<script>$('#R$id').hide();</script>");
  }else{
  messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
  }

}
public function insert($id)
{
  ob_start();
  $NoResponse="NoResponse";
  include(ROOTPATH."/upload.php");
  ob_end_clean();
if($respond['success']=="true"){

global $db;
$db->insert("groups", $what = array('Gname' =>  $_POST['Gname'],'GProfilePic' => $respond['id']
,'Description' =>  $_POST['Description'],'priority' =>  $_POST['priority'],'Royal' => $_POST['Royal']));
include("functions/generalFunctions.php");
  if(!$db->error){
  messege("alert-success","تمت العمليه , ","  لقد تم اضافه القبيله بنجاح");
  groups::sort();
  }else{
  messege("alert-danger","Falied ",$db->errorMessege());
  }

}
}

public function update($id)
{
if($_FILES["fileToUpload"]["name"]!=NULL)
{
  ob_start();
  $NoResponse="NoResponse";
  include(ROOTPATH."/upload.php");
  ob_end_clean();
if($respond['success']=="true"){

global $db;
$db->update("groups", $what =  array('Gname' =>  $_POST['Gname'],'GProfilePic' => $respond['id']
,'Description' =>  $_POST['Description'],'priority' =>  $_POST['priority'],'Royal' => $_POST['Royal'])
, $where=array("Gid"=>$id));
include("functions/generalFunctions.php");
  if(!$db->error){
  messege("alert-success","تمت العمليه , ",
  "لقد تم تعديل القبيله بنجاح");
//sucess i can here reload
  }else{
  messege("alert-danger","Falied ",$db->errorMessege());
  }

}
}
else{
  global $db;
  $db->update("groups", $what =  array('Gname' =>  $_POST['Gname']
  ,'Description' =>  $_POST['Description'],'priority' =>  $_POST['priority'],'Royal' => $_POST['Royal'])
  , $where=array("Gid"=>$id));
  include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","تمت العمليه , ","  لقد تم اضافه القبيله بنجاح");
    }else{
    messege("alert-danger","Falied ",$db->errorMessege());
    }
}
groups::sort();
}

}


?>
