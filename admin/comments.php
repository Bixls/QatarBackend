<?php
class comments{

public function viewCommentbyEvent($eventID){
  global $db;
  $db->select('Events',array('id'=>$eventID),$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin="");
  $event=$db->row_array();;
  $Page_Title="التعليقات على ".$event['subject'];


  $myFunctions =new TableView;
  $myFunctions->addF("عرض ","View","v");
  $myFunctions->addF("خذف التعليق","Delete","d");


 $myTable =new TableView;
 $myTable->addE("ID","CommentID","`CommentID`");
 $myTable->addE("اسم العضو","name","`name`");
 $myTable->addE("القبيله","Gname","`Gname`");
 $myTable->addElement("الصوره الشخصيه","ProfilePic","`ProfilePic`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
 $myTable->addE("التعليق","comment","`comment`");
 $keyid="CommentID";
 global  $per_page;


 $what=$myTable->returnArray();
 $where=array('POSTID' => $eventID);
 $table="comments";
 $innerJoin="INNER JOIN
 (SELECT `groups`.`Gname` Gname ,
  `members`.`id`,`members`.`name` name,`members`.`ProfilePic` ProfilePic
  FROM groups INNER JOIN members ON members.groupID=groups.Gid)
  `members` ON `members`.`id`=`EventsComments`.`memberID`";
// $innerJoin.="INNER JOIN `members` ON `members`.`id`=`invitationsLog`.`memberID`";
 $getArray=$_GET;
 require ("functions/generalFunctions.php");
 $start=getStartPage($getArray,$per_page);
 $db->select('EventsComments',$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$what,$innerJoin);

 $input=$db->result_array();
 include("views/list.php");
}
public function viewCommentbyNews($newsID){
}
public function View($id){
}
public function Delete($id){
}
}


?>
