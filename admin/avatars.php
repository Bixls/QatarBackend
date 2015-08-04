<?php


class Avatars{

  public function getAvatarsList(){


        $Page_Title="الصور الرمزيه";
        global $db;
        require_once("views/tablelist.php");
        $myTable =new TableView;
        $myTable->addE("id","id","`id`");
        $myTable->addElement("الصوره الشخصيه","imageID","`imageID`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
$msg="هل انت متاكد من حذف الصوره ؟";
        $keyid="id";
        global  $per_page;
        $myFunctions =new TableView;
        $myFunctions->addF("عرض","View","v");
        $myFunctions->addF("تعديل","Edit","e");
        $myFunctions->addF("حذف","delete","d");

        $what=$myTable->returnArray();
        $table="Avatars";
        $innerJoin="";
        $getArray=$_GET;
        require ("functions/generalFunctions.php");
        $start=getStartPage($getArray,$per_page);
        $db->select($table,"",$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);
        $input=$db->result_array();
        include("views/list.php");
  }
  public function CreateNew($input){

    $header="اضافه صوره رمزيه جديده";
    include("views/form.php");
    $form=new form("index.php","title");
    $form->addImage('imageID',"imageID","الصوره الرمزيه");
    $form->addElement('i',"0","hidden","");
    $form->addElement('fn',"insert","hidden","");
    $form->addElement('c',"Avatars","hidden","");
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
  $db->insert("Avatars", $what = array('imageID' => $respond['id']));
  include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","تمت العمليه , ","  لقد تم اضافه الصوره بنجاح");
    }else{
    messege("alert-danger","Falied ",$db->errorMessege());
    }
  }
  }
  public function delete($avatarID)
  {
    global $db;
    $db->delete("Avatars",$where=array('id' => $avatarID));
    include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","تمت العمليه بنجاح","تم مسح الصوره");
    echo("<script>$('#R$avatarID').hide();</script>");
    }else{
    messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
    }

  }
  public function view($id)
  {
    global $db;
    $What="*";
    $innerJoin = "";
    $db->select('Avatars',array('id'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    if(!$db->error){
    $result=$db->row_array();
    $db->select('members',array('ProfilePic'=>$result['imageID']),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);
    $usersNumb=$db->count();

    $header="";


    include("views/normalView.php");
    $NormalView=new NormalView;
    $ViewImage=$result['imageID'];


    $NormalView->addElement($usersNumb,"text","عدد مستخدمين الصوره");

    $body=$NormalView->RenderForm();
    $DeleteMessege="هل انت متاكد من حذف ";

    $menus='<button class="btn btn-md btn-danger" onclick="goTo(\'delete\',\'d\','.$result['id'].',\'members\',\''.$DeleteMessege.'\')" >حذف</button>';


    include("views/single.php");
    }else{
    $header="Error";
    $body=$db->errorMessege();
    include("views/single.php");
    }
  }

}







 ?>
