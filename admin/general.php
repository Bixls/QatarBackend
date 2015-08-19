<?php
class general{

  public function getEventTypesList(){


        $Page_Title="انواع الدعوات";
        global $db;
        require_once("views/tablelist.php");
        $myTable =new TableView;
        $myTable->addE("id","catID","`catID`");
        $myTable->addE("اسم نعوع الدعوة","catName","`catName`");
        $msg="هل انت متاكد من حذف نوع الدعوة";
        $keyid="catID";
        global  $per_page;
        $myFunctions =new TableView;
        $myFunctions->addF("عرض","ViewEventTypes","v");
        $myFunctions->addF("تعديل","EditEventTypes","e");
        $myFunctions->addF("حذف","deleteEventTypes","d");

        $what=$myTable->returnArray();
        $table="EventCatigories";
        $innerJoin="";
        $getArray=$_GET;
        require ("functions/generalFunctions.php");
        $start=getStartPage($getArray,$per_page);
        $db->select($table,"",$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
        $input=$db->result_array();
        $db->select($table,"",$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
        $numberOFPosts=$db->count();
        $viewVar="ViewEventTypes";
        $table="general";//class name
        include("views/list.php");
  }
  public function CreateEventTypesNew($input){

    $header="اضافه نوع دعوه جديد";
    include("views/form.php");
    $form=new form("index.php","title");
    $form->addElement('catName',"","text","اسم نوع الدعوه");
    $form->addElement('i',"0","hidden","");
    $form->addElement('fn',"insertEventTypes","hidden","");
    $form->addElement('c',"general","hidden","");
    $body=$form->RenderForm();
  //  $body="fields that will create the new group is here";
    include("views/single.php");
  }
  public function insertEventTypes($id)
  {

  global $db;
  $db->insert("EventCatigories", $what = array('catName' =>$_POST['catName']));
  include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","تمت العمليه , "
    ,"بنجاح");
    }else{
    messege("alert-danger","Falied ",$db->errorMessege());
    }
  }
  public function deleteEventTypes($id)
  {
    global $db;
    $db->delete("EventCatigories",$where=array('catID' => $id));
    include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","تمت العمليه بنجاح","تم مسح بنجاح");
    echo("<script>$('#$id').hide();</script>");
    }else{
    messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
    }

  }
  public function viewEventTypes($id)
  {
    global $db;
    $What="*";
    $innerJoin = "";
    $db->select('EventCatigories',array('catID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    if(!$db->error){
    $result=$db->row_array();

    $db->select('Events',array('eventType'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);

    $eventsNumber=$db->count();

    $header="".$result['catName'];

    include("views/normalView.php");
    $NormalView=new NormalView;
    $NormalView->addElement($eventsNumber,"text","عدد المناسبات لهذا النوع");

    $body=$NormalView->RenderForm();
    $DeleteMessege="هل انت متاكد من حذف ";

    $menus='<button class="btn btn-md btn-danger" onclick="goTo(\'delete\',\'d\','.$result['catID'].',\'general\',\''.$DeleteMessege.'\')" >حذف</button>';
    $menus.='<button class="btn btn-md btn-success" onclick="goTo(\'EditEventTypes\',\'e\','.$result['catID'].',\'general\',\''.$DeleteMessege.'\')" >تعديل</button>';
    $menus.='<a class="btn btn-md btn-default" href="?fn=ViewEventList&c=events&i=0&catID='.$result['catID'].'">عرض المناسبات</a>';



    include("views/single.php");
    }else{
    $header="Error";
    $body=$db->errorMessege();
    include("views/single.php");
    }
  }
  public function EditEventTypes($id){

    global $db;
    $db->select('EventCatigories',array('catID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
    if(!$db->error){
    $result=$db->row_array();

    $header="تعديل نوع دعوة".$result['catName'];
    include("views/form.php");
    $form=new form("index.php","title");


    $form->addElement('catName',$result['catName'],"text","اسم نوع الدعوة");

    $form->addElement('i',$id,"hidden","");
    $form->addElement('fn',"updateEventTypes","hidden","");
    $form->addElement('c',"general","hidden","");
    $body=$form->RenderForm();
  //  $body="fields that will create the new group is here";
    include("views/single.php");
  }
  }


  public function updateEventTypes($id)
  {

    global $db;
    $db->update("EventCatigories", $what =  array('catName' =>  $_POST['catName'])
    , $where=array("catID"=>$id));
    include("functions/generalFunctions.php");
      if(!$db->error){
      messege("alert-success","تمت العمليه , ","
      تم التحديث بنجاح");
      }else{
      messege("alert-danger","Falied ",$db->errorMessege());
      }


  }



}

?>
