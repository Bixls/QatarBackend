<?php

class news{


  public function CreateNew($input){
    $header="اضافه خبر جديد";
    include("views/form.php");
    $form=new form("index.php","title");
    $form->addElement('Subject',"","text","عنوان الخير");
    $form->addImage('Image',"group","صوره الخبر");
    global $db;
    $What="*";
    $innerJoin = "";
    $db->select('groups',"",$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    $result=$db->result_array();
   $groups = array("-1"=>"الرئيسية");
    foreach ($result as $key) {
      //array_push($group,$key["Gname"]);
      $groups[$key["Gid"]]=$key["Gname"];
    }
    $form->addElement('GroupID',$groups,"select","القبيله");
    $allowComments = array('1' =>"نعم",'0' =>"لا"  );
    $form->addElement('AllowComments',$allowComments,"select","السماح بالتعليقات");
      $form->addElement('Description',"","textarea","تفاصيل الخبر");
    $form->addElement('i',"0","hidden","");
    $form->addElement('fn',"insert","hidden","");
    $form->addElement('c',"news","hidden","");
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
  $db->insert("News", $what = array('GroupID' =>  $_POST['GroupID'],
  'Subject' =>  $_POST['Subject'],
  'AllowComments' =>  $_POST['AllowComments'],
  'Description' =>  $_POST['Description'],
  'Image' => $respond['id']));
  include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","تمت العمليه , ","تم انشاء الخبر بنجاح");
    }else{
    messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
    }

  }
  }
  public function delete($id){
    global $db;
    $db->delete("News",$where=array('NewsID' => $id));
    include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","تمت العمليه بنجاح ,","لفد تم حذف الخبر بنجاح ");
    echo("<script>$('#R$id').hide();</script>");
    }else{
    messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
    }
  }

  public function ViewNewsList(){


    $Page_Title="عرض حميع الاخبار المنشوره";
    $where=array('1' => 1 );
    $myFunctions =new TableView;
    $myFunctions->addF("عرض","View","v");
    $myFunctions->addF("تعديل","Edit","e");
    $myFunctions->addF("حذف","delete","d");
    global $db;


    $myTable =new TableView;
    $myTable->addE("ID","NewsID","`NewsID`");
    $myTable->addE("عنوان الخبر","Subject","`Subject`");
    $myTable->addE("تفاصيل الخبر","Description","`Description`");
    $myTable->addElement("صوره الخبر","Image","`Image`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
    $keyid="NewsID";
    global  $per_page;


    $what=$myTable->returnArray();
    $table="News";
    $innerJoin="";
    $getArray=$_GET;
    require ("functions/generalFunctions.php");
    $start=getStartPage($getArray,$per_page);
    $db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$what,$innerJoin);
    $input=$db->result_array();
    include("views/list.php");
  }



}

?>
