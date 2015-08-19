<?php

class Feedbacks{

  public function viewFeedbackList(){

    $Page_Title="الشكاوى و المقترحات";
    global $db;
    require_once("views/tablelist.php");
    $myTable =new TableView;
    $myTable->addE("id","FeedbackID","`FeedbackID`");
    $myTable->addE("الراسل","name","`name`");
    $myTable->addElement("الصوره الشخصيه","ProfilePic","`ProfilePic`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
    $myTable->addE("نوع الرساله","FeedbackType","`FeedbackType`");
    $myTable->addE("العنوان","Subject","`Subject`");
    $myTable->addE("الرسالة","Message","`Message`");
    $keyid="FeedbackID";
    global  $per_page;
    $myFunctions =new TableView;
    $myFunctions->addF("عرض","View","v");
    $myFunctions->addF("تعديل","Edit","e");

    $what=$myTable->returnArray();
    $table="Feedbacks";
    $innerJoin="inner join members on members.id=Feedbacks.SenderID";
    $getArray=$_GET;
    require ("functions/generalFunctions.php");

    $start=getStartPage($getArray,$per_page);
    $db->select($table,"",$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
    $input=$db->result_array();
    $db->select($table,"",$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
    $numberOFPosts=$db->count();

    include("views/list.php");
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
  $menus.='<a class="btn btn-md btn-default" href="?fn=getEventsbyGroup&c=events&i='.$result['Gid'].'">عرض مناسبات القبيله</a>';
  $menus.='<a class="btn btn-md btn-default" href="?fn=viewMemberByGroup&c=members&i='.$result['Gid'].'">عرض اعضاء القبيله</a>';



  include("views/single.php");
  }else{
  $header="Error";
  $body=$db->errorMessege();
  include("views/single.php");
  }
  }

}

?>
