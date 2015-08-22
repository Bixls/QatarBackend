<?php

  require_once("views/tablelist.php");

class events{

  public function ViewUnApprovedEventList(){
  $where=array('approved' => 0 );
  $Page_Title="الموافقة على المناسبات";
    $myFunctions =new TableView;
  $myFunctions->addF("عرض","View","v");
//  $myFunctions->addF("تعديل","Edit","e");
  $myFunctions->addF("موافقة","Approve","a");
  $myFunctions->addF("رفض","disapprove","c");
   events::ViewList($where,$Page_Title,$myFunctions);
  }
  public function ViewEventList(){
    $where=array();
    $Page_Title="جميع المناسبات";
    $myFunctions =new TableView;
    $myFunctions->addF("عرض","View","v");
  //  $myFunctions->addF("تعديل","Edit","e");
   events::ViewList($where,$Page_Title,$myFunctions);
  }
public function ViewList($where,$Page_Title,$myFunctions){

  global $db;
  $oldGet=$_GET;
  $inlineMenu="";
///////////////////////////////////// View approved only //////////////////////////
if(!array_key_exists('approved', $where))
{
$gArray=$oldGet;
$gArray['VA']=false;
$va=true;
if(array_key_exists('VA', $_GET)){
  if($_GET['VA']==false){$va=false;
  $_GET['VA']=true;
  $where['approved']=1;
  }
  }
  $inlineMenu.='<div class="checkbox inlineMenuItem"><label>
  <input class="chBox" ch="?'.http_build_query($_GET).'"  unch="?'.http_build_query($gArray).'" type="checkbox" '.($va?"checked":"").'>اظهر المناسبات الغير مفعله </label></div>';
}
///////////////////////////////////// Sort BYy //////////////////////////
$_GET=$oldGet;
$gArray=$_GET;
$gArray['EX']=false;
$ex=true;
if(array_key_exists('EX', $_GET)){
  if($_GET['EX']==false){$ex=false;
  $_GET['EX']=true;
  $timeNow=Date("Y-m-d h:m:s");

  $twhere="`TimeEnded` >= '".$timeNow."'";
  array_push($where,$twhere);
  //$where['approved']=1;
  }
  }
  $inlineMenu.='<div class="checkbox inlineMenuItem"><label>
  <input class="chBox" ch="?'.http_build_query($_GET).'"  unch="?'.http_build_query($gArray).'" type="checkbox" '.($ex?"checked":"").'>اظهار المناسبات المنتهيه</label></div>';

///////////////////////////////////// Sort BYy //////////////////////////
$inlineMenu.='<div class="inlineMenuItem">ترتيب حسب
      <select class="form-control" id="sel1">
        <option>تاريخ الانشاء</option>
        <option>تاريخ الانتهاء</option>
      </select></div>';
///////////////////////////////////// catigories //////////////////////////
$nowSelectedCat=0;
if(array_key_exists('catID', $_GET)){
  $where['eventType']=  $_GET['catID'];
  $nowSelectedCat=$_GET['catID'];
}
      $db->select('EventCatigories',"",$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
      $results=$db->result_array();
      $eventTypeSelect="";
foreach ($results as $value) {
$_GET['catID']=$value['catID'];
$eventTypeSelect.="<option ".($nowSelectedCat==$value['catID']?"selected='selected'":"")." value='?".http_build_query($_GET)."'>".$value['catName']."</option>";
}
unset($_GET['catID']);
$inlineMenu.='<div class="inlineMenuItem">اظهار
            <select class="form-control"  id="dynamic_select">
              <option value="?'.http_build_query($_GET).'">جميع المناسبات</option>
            '.$eventTypeSelect.'
            </select></div>';


///////////////////////////////////// catigories //////////////////////////



  $table="Events";

  $myTable =new TableView;

  $myTable->addE("ID","id","`Events`.`id`");
  $eventStatus = array('1' => "مفعله",'0'=>"غير مفعله" );
  $myTable->addCustomeElement("vip","VIP",array('0' =>"لا" ,'1'=>"نعم" ));

  $myTable->addE("الاسم","name","`members`.`name`");

  $eventStatus = array('1' => "مفعله",'0'=>"غير مفعله" );
  $myTable->addCustomeElement("حاله المناسبة","approved",$eventStatus);


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
  $db->select($table,$where,$limit=$start.",".$per_page,$order="TimeEnded DESC",$where_mode="AND",$print_query=false,$what,$innerJoin);
  $input=$db->result_array();

  $db->select($table,$where,$limit=false,$order="TimeEnded DESC",$where_mode="AND",$print_query=false,$what,$innerJoin);
    $numberOFPosts=$db->count();

  include("views/list.php");

}
public function getEventsbyMember($memberID){
  global $db;
  $db->select('members',array('id'=>$memberID),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $creator=$db->row_array();;
  $Page_Title=" المناسبات الخاصه بالعضو ".$creator['name'];

  $where=array('CreatorID' => $memberID );

  $myFunctions =new TableView;
  $myFunctions->addF("عرض","ViewEvent","v");
//  $myFunctions->addF("تعديل","Edit","e");
 events::ViewList($where,$Page_Title,$myFunctions);
}
public function getEventsbyGroup($GroupID){
  global $db;
  $db->select('groups',array('Gid'=>$GroupID),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $Group=$db->row_array();;
  $Page_Title="مناسبات قبيله  ".$Group['Gname'];
  $where=array('members`.`groupID' => $GroupID );
  $myFunctions =new TableView;
  $myFunctions->addF("عرض","ViewEvent","v");
//  $myFunctions->addF("تعديل","Edit","e");
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
  $menus="";
if($result['approved']==1){
if($result['VIP']&&!$expired)$isViewed="معروضه في الصحه الرئيسية و صفحه قبيله ".$creator['Gname'];
elseif(!$expired)$isViewed="معروضه في صفحه قبيله ".$creator['Gname'];
else $isViewed="انتهى وقت عرضها";
}else{
    $menus.='<button class="btn btn-md btn-success" onclick="goTo(\'Approve\',\'a\','.$result['id'].',\'events\',\'\')" >موافقة</button>';
    $menus.='<button class="btn btn-md btn-warning" onclick="goTo(\'Disapprove\',\'a\','.$result['id'].',\'events\',\'\')" >رفض</button>';

$isViewed="منتظره التفعيل";
}


  $NormalView->addElement(($isViewed),"text","حاله المناسبة");
  $NormalView->addElement(($result['VIP']==0?"لا":"نعم"),"text","VIP");
  $NormalView->addElement(($result['comments']==0?"لا":"نعم"),"text","السماح بالتعليقات");


  $NormalView->addElement($result['description'],"text","تفاصيل المناسبة ");
  $body=$NormalView->RenderForm();
  $DeleteMessege="هل انت متاكد من حذف ".$result['subject'];


  $menus.='<button class="btn btn-md btn-danger" onclick="goTo(\'delete\',\'d\','.$result['id'].',\'events\',\''.$DeleteMessege.'\')" >حذف</button>';
  $menus.='<a class="btn btn-md btn-default" href="?fn=viewGoingMembers&c=members&i='.$result['id'].'">عرض الذاهبون</a>';
  $menus.='<a class="btn btn-md btn-default" href="?fn=viewInvitedMembers&c=members&i='.$result['id'].'">عرض المدعوون</a>';
  $menus.='<a class="btn btn-md btn-default" href="?fn=viewCommentbyEvent&c=comments&i='.$result['id'].'">عرض التعليقات</a>';


  include("views/single.php");
  }else{
  $header="Error";
  $body=$db->errorMessege();
  include("views/single.php");
  }
}

public function delete($id){
  global $db;
  $db->delete("Events",$where=array('id' => $id));
  include("functions/generalFunctions.php");
  if(!$db->error){
  messege("alert-success","تمت العمليه بنجاح ,","لفد تم حذف المناسبة بنجاح");
  echo("<script>$('#R$id').hide();</script>");
  }else{
  messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
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
