<?php
  require_once("views/tablelist.php");
class members{


  public function viewUnApprovedMemberList(){
    $where=array('Verified' => 0 );
    $Page_Title="عرض الاضاء الجدد الغير موافق عليهم";
    $myFunctions =new TableView;
    $myFunctions->addF("موافقه","Approve","a");
    $myFunctions->addF("رفض","disapprove","c");
    $myFunctions->addF("عرض","View","v");
    $myFunctions->addF("تعديل","Edit","e");
   members::getMembersList($where,$Page_Title,$myFunctions);
  }
  public function getMembersList($where,$Page_Title,$myFunctions){
    global $db;


    $myTable =new TableView;
    $myTable->addE("ID","id","`id`");
    $myTable->addE("اسم العضو","name","`name`");
    $myTable->addE("القبيله","Gname","`Gname`");
    $myTable->addElement("الصوره الشخصيه","ProfilePic","`ProfilePic`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
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
    $Page_Title="جميع الاعضاء";
    $where=array('1' => 1 );
    $myFunctions =new TableView;
    $myFunctions->addF("عرض","View","v");
    $myFunctions->addF("تعديل","Edit","e");
    $myFunctions->addF("خذف","Delete","d");
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

  $header="<b>"."الاسم";
  $header.="</b> ".$result['name'];
  $db->select('Events',array('CreatorID'=>$id),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $CreatedEvents=$db->count();


  include("views/normalView.php");
  $NormalView=new NormalView;
  $ViewImage=$result['ProfilePic'];

  $NormalView->addElement($result['Mobile'],"text","التليفون");
  $memberState;
  if($result['Verified']==0){$memberState="منتظر التفعيل"; }elseif ($result['Verified']==1) {
  $memberState="مفعل"; }elseif ($result['Verified']==-1) {$memberState="مرفوض";}else{
    $memberState="تم ارسال الرساله بالكود";
    $memberState.=$result['Verified'];
  }
  $NormalView->addElement($memberState,"text","حاله العضو");
  $NormalView->addElement($result['inVIP'],"text","VIP عدد الدعوات");
  $NormalView->addElement($result['Gname'],"text","اسم القبيله");
  $NormalView->addElement($CreatedEvents,"text","عدد المناسبات");
  $body=$NormalView->RenderForm();
  $menus='<a href="#" onclick="goTo(\'Delete\',\'d\','.$result['id'].',\'members\')" >حذف</a>';
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
