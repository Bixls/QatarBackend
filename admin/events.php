<?php


class events{

public function ViewUnApprovedEventList(){
  global $db;
  $table="Events";
  global  $per_page;

  $list = array('id'=>'id' ,' Name'=>'VIP','Subject'=>'subject'
  ,'Picture'=>'picture','Event description'=>'description','Event Type'=>'catName','Creator Name'=>'name','Creator Group'=>'Gname');

  $customeFileds= array('Approve'=>"a",
                        'Disapprove'=>"d"
                      );
  $what= ('`Events`.`id` ,
    `members`.`name`,
    `EventCatigories`.`catName`,
    `Gname`,
    `Events`.`subject` ,
    `Events`.`description` ,
    `Events`.`VIP` ,
    `Events`.`picture` ,
    `Events`.`TimeEnded` ,
    `Events`.`description`');
  $innerJoin="INNER JOIN (SELECT `groups`.`Gname` Gname ,`members`.`name` ,`members`.`id`
  FROM groups INNER JOIN members ON members.groupID=groups.Gid)
   `members` ON `Events`.`CreatorID`=`members`.`id`
  INNER JOIN `EventCatigories` ON   `Events`.`eventType`=`EventCatigories`.`catID`";




  $getArray=$_GET;
  $where= array('Events`.`approved' => 0 );
  require ("functions/generalFunctions.php");
  $start=getStartPage($getArray,$per_page);
  $db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$what,$innerJoin);
  $input=$db->result_array();

  //print_r($input);
  $header=$list;
  $keyID="id";
  include("views/list.php");
}
public function ViewEventList(){

}
public function getEventsbyMember($memberID){

}
public function SearchEventsByName($searcher){

}
public function Approve($id){
  global $db;
  $db->update("Events",array('approved' =>1), $where=array("id"=>$id));
  include("functions/generalFunctions.php");
  messege("alert-success","Sucess      ","The Event has been approved successfully");

}
public function Disapprove($id){

}
public function RemoveEvent($id){

}
public function ViewEvent($id){

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
