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
  //  $myFunctions->addF("تعديل","Edit","e");

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
  $db->select('Feedbacks',array('FeedbackID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="inner join members on Feedbacks.SenderID=members.id");
  if(!$db->error){
  $result=$db->row_array();

  $header="<b>"."رسالة من ";
  $header.="</b> ".$result['name'];


  include("views/normalView.php");
  $NormalView=new NormalView;


  $NormalView->addElement($result['Subject'],"text","عنوان الرساله");
  $NormalView->addElement($result['Message'],"text","تفاصيل الرساله");
  $body=$NormalView->RenderForm();

  $menus="";

  $menus.='<button class="btn btn-md btn-default" onclick="goTo(\'View\',\'v\','.$result['id'].',\'members\',\''.$DeleteMessege.'\')" >عرض صاحب الرساله</button>';



  include("views/single.php");
  }else{
  $header="Error";
  $body=$db->errorMessege();
  include("views/single.php");
  }
  }

}

?>
