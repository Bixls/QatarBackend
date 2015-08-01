<?php

  require_once("views/tablelist.php");

class events{

  public function ViewUnApprovedEventList(){
  $where=array('approved' => 0 );
  $Page_Title="الموافقة على المناسبات";
    $myFunctions =new TableView;
  $myFunctions->addF("عرض","View","v");
  $myFunctions->addF("تعديل","Edit","e");
  $myFunctions->addF("موافقة","Approve","a");
  $myFunctions->addF("رفض","disapprove","c");
   events::ViewList($where,$Page_Title,$myFunctions);
  }
  public function ViewEventList(){
    $where=array('approved' => 1 );
    $Page_Title="جميع المناسبات";
    $myFunctions =new TableView;
    $myFunctions->addF("عرض","View","v");
    $myFunctions->addF("تعديل","Edit","e");
   events::ViewList($where,$Page_Title,$myFunctions);
  }
public function ViewList($where,$Page_Title,$myFunctions){

  global $db;
  $table="Events";

  $myTable =new TableView;

  $myTable->addE("ID","id","`Events`.`id`");
  $myTable->addE("vip","VIP","`Events`.`VIP`");
  $myTable->addE("الاسم","name","`members`.`name`");
  $myTable->addE("عنوان المناسبة","subject","`Events`.`subject`");
  $myTable->addElement("الصوره","picture","`Events`.`picture`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
  $myTable->addE("التفاصيل","description","`Events`.`description`");
  $myTable->addE("نوع المناسبة","catName","`EventCatigories`.`catName`");
  $myTable->addE("القبيله","Gname","`Gname`");
  $keyid="id";
  global  $per_page;

  $what=$myTable->returnArray();
  $innerJoin="INNER JOIN (SELECT `groups`.`Gname` Gname ,`members`.`name` ,`members`.`id`,`members`.`groupID`
  FROM groups INNER JOIN members ON members.groupID=groups.Gid)
   `members` ON `Events`.`CreatorID`=`members`.`id`
  INNER JOIN `EventCatigories` ON   `Events`.`eventType`=`EventCatigories`.`catID`";

  $getArray=$_GET;
  $where;
  require ("functions/generalFunctions.php");
  $start=getStartPage($getArray,$per_page);
  $db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$what,$innerJoin);
  $input=$db->result_array();

  //print_r($input);



  include("views/list.php");

}
public function getEventsbyMember($memberID){
  $where=array('CreatorID' => $memberID );
  $Page_Title="المناسبات الخاصه بالعضو";
  $myFunctions =new TableView;
  $myFunctions->addF("عرض","ViewEvent","v");
  $myFunctions->addF("تعديل","Edit","e");
 events::ViewList($where,$Page_Title,$myFunctions);
}
public function getEventsbyGroup($GroupID){
  $where=array('members`.`groupID' => $GroupID );
  $Page_Title="مناسبات القبيله";
  $myFunctions =new TableView;
  $myFunctions->addF("عرض","ViewEvent","v");
  $myFunctions->addF("تعديل","Edit","e");
 events::ViewList($where,$Page_Title,$myFunctions);
}
public function SearchEventsByName($searcher){

}
public function Approve($id){
  global $db;
  $db->update("Events",array('approved' =>1), $where=array("id"=>$id));
  include("functions/generalFunctions.php");
  messege("alert-success","نجحت العمليه ","تم الموافقة على المناسبة بنجاح");

}
public function Disapprove($id){

}
public function RemoveEvent($id){

}
public function View($id){
  global $db;
  $db->select('Events',array('id'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  if(!$db->error){
  $result=$db->row_array();

  $header="";
  $header.=$result['subject'];
  $db->select('EventsComments',array('POSTID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $commentsNumber=$db->count();

  $db->select('invitationsLog',array('EventID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $invited=$db->count();

  $db->select('invitationsLog',array('EventID'=>$id,'IsGoing'=>1),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $isGoing=$db->count();

$innerJoin = "INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid`";
  $db->select('members',array('id'=>$result['CreatorID']),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
  $creator=$db->row_array();

  include("views/normalView.php");
  $NormalView=new NormalView;
  $ViewImage=$result['picture'];
  $NormalView->addElement($creator['name'],"text","اسم صاحب المناسبة");
  $NormalView->addElement($commentsNumber,"text","عدد التعليقات ");
  $NormalView->addElement($invited,"text","عدد المدعوون");
    $NormalView->addElement($isGoing,"text","عدد الذاهبون");
  $NormalView->addElement($result['timeCreated'],"text","تاريخ الانشاء");
    $NormalView->addElement($result['TimeEnded'],"text","تاريخ الانتهاء");

$timeNow=Date("Y-m-d h:m:s");
$expired=($result['TimeEnded']<=$timeNow);

if($result['approved']==1){
if($result['VIP']&&!$expired)$isViewed="معروضه في الصحه الرئيسية و صفحه قبيله ".$creator['Gname'];
elseif(!$expired)$isViewed="معروضه في صفحه قبيله ".$creator['Gname'];
else $isViewed="انتهى وقت عرضها";
}else{
$isViewed="منتظره التفعيل";
}


  $NormalView->addElement(($isViewed),"text","حاله المناسبة");
  $NormalView->addElement(($result['VIP']==0?"لا":"نعم"),"text","VIP");
  $NormalView->addElement(($result['comments']==0?"لا":"نعم"),"text","السماح بالتعليقات");


  $NormalView->addElement($result['description'],"text","تفاصيل المناسبة ");
  $body=$NormalView->RenderForm();
  $DeleteMessege="هل انت متاكد من حذف ".$result['subject'];
  $menus="";

  $menus.='<button class="btn btn-md btn-danger" onclick="goTo(\'Delete\',\'d\','.$result['id'].',\'groups\',\''.$DeleteMessege.'\')" >حذف</button>';
  $menus.='<a class="btn btn-md btn-default" href="?fn=getEventsbyGroup&c=events&i='.$result['id'].'">عرض الذاهبون</a>';
  $menus.='<a class="btn btn-md btn-default" href="?fn=viewMemberByGroup&c=members&i='.$result['id'].'">عرض المدعوون</a>';
  $menus.='<a class="btn btn-md btn-default" href="?fn=viewMemberByGroup&c=members&i='.$result['id'].'">عرض التعليقات</a>';


  include("views/single.php");
  }else{
  $header="Error";
  $body=$db->errorMessege();
  include("views/single.php");
  }
}



public function DisapproveEventbyID($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $sql=mysql_query("SELECT `VIP` FROM `Events` WHERE `Events`.`id`=".$inputs->Eventid) or die (mysql_error());
  if($sql){
      $row=mysql_fetch_array($sql);
  if($row["VIP"]==1){
    //Give the user back his points
  }
  else{
    // Just Send the dissaproval messege ي
  }
  }
    $dbConnect->close();
}


}


 ?>
