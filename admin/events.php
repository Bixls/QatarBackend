<?php


class events{

public function ViewUnApprovedEventList(){
$where=array('approved' => 0 );
 events::ViewList($where);
}
public function ViewEventList(){
  $where=array('approved' => 1 );
 events::ViewList($where);
}
public function ViewList($where){

  global $db;
  $table="Events";

  require_once("views/tablelist.php");
  $myTable =new TableView;

  $myTable->addE("ID","id","`Events`.`id`");
  $myTable->addE("vip","VIP","`Events`.`VIP`");
  $myTable->addE("esm el sha5s","name","`members`.`name`");
  $myTable->addE("subjecta","subject","`Events`.`subject`");
  $myTable->addElement("el sora","picture","`Events`.`picture`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
  $myTable->addE("el description","description","`Events`.`description`");
  $myTable->addE("esm el catgory","catName","`EventCatigories`.`catName`");
  $myTable->addE("esm el group","Gname","`Gname`");
  $keyid="id";
  global  $per_page;
  $myTable->addF("Approve ya 3m","Approve","a");
  $myTable->addF("ya 3m dis Approve","Disapprove","d");


  $what=$myTable->returnArray();
  $innerJoin="INNER JOIN (SELECT `groups`.`Gname` Gname ,`members`.`name` ,`members`.`id`
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
